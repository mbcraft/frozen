<?php

/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

require_once ("BasicObject.class.php");
/**
 * Classe astratta utilizzata per i loader di risorse ricorsivi e non.
 *
 * @author marco.bagnaresi
 */

abstract class AbstractLoader extends BasicObject
{
    const COLLISION_MODE_KEEP_ORIGINAL = "keep_original";
    const COLLISION_MODE_OVERWRITE = "overwrite";
    const COLLISION_MODE_ERROR = "error";
    
    private $FILENAME_SUFFIX;
    private $FILENAME_SUFFIX_LEN;

    protected $ELEMENT_NAME;

    private $scanned_dirs = array();
    private $elements = array();
    private $scan_recursively;
    private $keep_dir_as_namespace;
    private $dump_scans;
    private $__current_root;

    static $skip_dirs = array("." => 0,".." => 1, ".svn" => 1);

    protected function __construct($suffix,$scan_recursively,$keep_dir_as_namespace,$dump_scans=false)
    {
        $this->ELEMENT_NAME = ucfirst(substr($suffix, 1, strlen($suffix)-1-4)); //. -1  e .php -4

        $this->FILENAME_SUFFIX = $suffix;
        $this->FILENAME_SUFFIX_LEN = strlen($suffix);
        $this->scan_recursively = $scan_recursively;
        $this->keep_dir_as_namespace = $keep_dir_as_namespace;
        $this->dump_scans = $dump_scans;
    }

    //protected abstract function autoconfigure();

    public abstract function add_directory($dir);
    
    public final function get_element_name_from_filename($filename)
    {
        return str_replace($this->FILENAME_SUFFIX, "", $filename);
    }

    public final function get_element_content_by_name($name)
    {
        $path = $this->get_element_path_by_name($name);
        return file_get_contents(SITE_ROOT_PATH.DS.$path);
    }
    
    public final function get_element_path_by_name($name)
    {
        if (array_key_exists($name, $this->elements))
        {
            return $this->elements[$name];
        }
        else
            $this->__error(__METHOD__, $this->ELEMENT_NAME." non trovato : $name .");
    }

    public final function scan_from_site_root($dir)
    {
        $this->scanned_dirs[] = $dir;
        
        $this->__current_root = $dir;
        
        $this->scan(SITE_ROOT_PATH,$dir);
    }
    
    public final function get_scanned_directories()
    {
        return $this->scanned_dirs;
    }

    /*
     * Effettua una scansione ricorsiva delle directory qui elencate e ricerca tutti i file
     * che terminano con .ELEMENT_NAME.php e li memorizza in un hash che conterra'
     * NomeElemento => Path
     */
    private final function scan($root_path,$dir)
    {
        if ($this->dump_scans) echo "Scanning : ".$dir."<br />";

        if (!is_dir($root_path.$dir))
        {
            $this->__warn(__METHOD__, "La directory ".$root_path.$dir." non e' una directory valida ... skip ...");
            return;
        }
        //IMPORTANTE SCANDIR DEVE RITORNARE IN ORDINE ALFABETICO!!! Default = 0 -> OK
        if (!array_key_exists($dir,self::$skip_dirs))
        {
            $file_list = scandir($root_path.$dir);
            foreach ($file_list as $filename)
            {
                if (!array_key_exists($filename,self::$skip_dirs))
                {
                    //echo "Scanning : [ ".$filename." ]";
                    $full_path = $root_path.$dir.$filename;
                    if ($this->scan_recursively && $this->is_subdirectory($root_path.$dir,$filename))
                    {
                        $this->scan($root_path,$dir.$filename.DIRECTORY_SEPARATOR);
                    }
                    else
                    {
                        if (is_file($full_path) && $this->is_valid_filename($filename))
                        {
                            if ($this->dump_scans) echo "Valid file found : ".$dir.$filename."<br />";

                            $this->valid_file_found($dir, $filename);
                        }
                        
                    }
                }

            }
        }
    }
    
    protected function collision_detected($element_key,$new_path,$old_path)
    {
        return self::COLLISION_MODE_ERROR;
    }

    public final function has_found_element($name)
    {
        return array_key_exists($name, $this->elements);
    }

    protected function valid_file_found($dir,$filename)
    {
        if ($this->dump_scans) echo "Valid file found : DIR=".$dir." FILENAME=".$filename."<br />";
        $path = $dir.$filename;

        if ($this->keep_dir_as_namespace)
        {
            //devo togliere solo la prima parte ...
            $element_key = $dir.$this->get_element_name_from_filename($filename);
            //questa e' ok, da questa tolgo solo la prima parte ...
            if ($this->dump_scans) echo "Current root : ".$this->__current_root."<br />";
            //$element_key = str_replace($this->__current_root,"",$element_key);
            $element_key = substr($element_key,strlen($this->__current_root));  // <-- working
            $element_key = str_replace(DIRECTORY_SEPARATOR, "/", $element_key);
        }
        else
            $element_key = $this->get_element_name_from_filename($filename);

        if ($this->dump_scans) echo "Element key set : ".$element_key."<br />";

        //già un elemento con lo stesso nome
        $mode = self::COLLISION_MODE_OVERWRITE;
        if (array_key_exists($element_key, $this->elements))
            $mode = $this->collision_detected($element_key,$path,$this->get_element_path_by_name($element_key));
        
        if ($mode==self::COLLISION_MODE_ERROR)
            $this->__error(__METHOD__, "Collisione di nomi : $element_key 1:".$this->elements[$element_key]." 2:".$path);
        
        if ($mode==self::COLLISION_MODE_KEEP_ORIGINAL)
                return;
        
        if ($mode==self::COLLISION_MODE_OVERWRITE)
        {
            $path_without_starting_slash =  substr($path,1);
            $this->elements[$element_key] = $path_without_starting_slash; //rimuovo la barra davanti, così facilito gli include e i require.
            if (Log::$debug)
                $this->__debug(__METHOD__, $this->ELEMENT_NAME." found : $element_key : $path_without_starting_slash .");
            $this->element_found($element_key);
            return;
        }
        
        throw new Exception("Collision mode not supported by AbstractLoader : ".$mode);
    }

    protected function element_found($full_key) {}

    /*
     * Determina se un nome di file e' considerato valido per questo scanner o no.
     */

    public final function is_valid_filename($filename)
    {
        $len = strlen($filename);
        if ($len<$this->FILENAME_SUFFIX_LEN  || $filename==__FILE__) return false;

        $pos = strpos($filename,$this->FILENAME_SUFFIX);
        if ($pos!==false && $pos+$this->FILENAME_SUFFIX_LEN==$len)
            return true;
        else
            return false;
    }

    private final function is_subdirectory($dir,$filename)
    {
        if (is_dir($dir.$filename)) return true;
        else
            return false;
    }

    public function list_all()
    {
        foreach ($this->elements as $key => $value)
        {
            echo $this->ELEMENT_NAME." ".$key." found : ".$value."<br />";
        }
    }

    public function get_element_keys()
    {
        return array_keys($this->elements);
    }
    
    public function reset()
    {
        $this->elements = array();
    }
    
}


?>