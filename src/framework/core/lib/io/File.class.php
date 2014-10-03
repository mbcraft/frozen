<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */


/*
 * Rappresenta un puntatore a un determinato percorso, in questo caso un file
 */
class File extends __FileSystemElement
{
    const TMP_DIR = "/tmp/";

    function __construct($path)
    {
        $new_path = str_replace("\\", DS, $path);

        parent::__construct($new_path);
    }

    function getDirectory()
    {
        return new Dir(dirname($this->__path));
    }
    
    function getName()
    {
        $result = pathinfo($this->__full_path);
        return $result['filename'];
    }

  /*
   * Rinomina il file senza effettuare spostamenti di sorta.
   * */
    function rename($new_name)
    {
        if (strstr($new_name,"/")!==false)
            throw new InvalidParameterException("Il nome contiene caratteri non ammessi ( / )!!");

        $this_dir = $this->getDirectory();

        $target_path = $this_dir->getPath()."/".$new_name;

        $target_file = new File($target_path);
        if ($target_file->exists()) return false;

        return rename($this->__full_path,$target_file->getFullPath());
    }

/*
 * TESTED
 */
    function getFilename()
    {
        $result = pathinfo($this->__full_path);
        return $result['filename'].".".$result['extension'];
    }
/*
 * TESTED
 *
 * eg : .jpg
 */
    function getExtension()
    {
        $result = pathinfo($this->__full_path);
        
        return $result['extension'];
    }
/*
 * TESTED
 */
    function getFullExtension()
    {
        $filename = $this->getFilename();
        $result = preg_match("/\.(.+)/",$filename,$matches);

        return $matches[1];
    }
/*
 * TESTED
 */
    function getContent()
    {
        return file_get_contents($this->__full_path);
    }

    function getContentHash()
    {
        return sha1_file($this->__full_path);
    }
/*
 * TESTED
 */
    function setContent($content)
    {
        file_put_contents($this->__full_path, $content, LOCK_EX);
    }

    function getSize()
    {
        return filesize($this->__full_path);
    }
/*
 * TESTED
 */
    function delete()
    {
        return @unlink($this->__full_path);
    }

    function isEmpty()
    {
        return $this->getSize()==0;
    }

    function copy($target_dir,$new_name=null)
    {      
        if ($target_dir instanceof Dir)
        {
            if ($new_name==null)
                $new_name = $this->getFilename();
            return copy($this->__full_path,$target_dir->__full_path.DS.$new_name);
        }
    }

    function filenameMatches($pattern)
    {
        return preg_match($pattern, $this->getFilename())!=0;
    }
    

    function touch()
    {
        touch($this->__full_path);
    }

    public function openReader()
    {
        if (!$this->exists()) throw new IllegalStateException("Impossibile aprire il reader al percorso : ".$this->__full_path.". Il file non esiste!!");


        $handle = fopen($this->__full_path,"r");

        if ($handle===false) throw new IllegalStateException("Impossibile aprire il reader al percorso : ".$this->__full_path.".");

        if (flock($handle, LOCK_SH))
        {
            return new FileReader($handle);
        }
        else 
        {
            fclose($this->my_handle);
            return null;
        }
    }

    public function openWriter()
    {
        $handle = fopen($this->__full_path,"c+");

        if ($handle===false) throw new IllegalStateException("Impossibile aprire il writer al percorso : ".$this->__full_path);

        if (flock($handle,LOCK_EX))
        {
            return new FileWriter($handle);
        }
        else 
        {
            fclose($this->my_handle);
            return null;
        }
    }

    public function getIncludePath()
    {
        $my_path = $this->getPath();

        $included_file_path = substr($my_path,1);

        return $included_file_path;
    }

    public function includeFile()
    {
        $my_path = $this->getPath();

        $included_file_path = substr($my_path,1);

        include($included_file_path);
    }
    
    public function includeFileOnce()
    {
        $my_path = $this->getPath();

        $included_file_path = substr($my_path,1);

        include_once($included_file_path);
    }
    
    public function requireFileOnce()
    {
        $my_path = $this->getPath();

        $included_file_path = substr($my_path,1);

        require_once($included_file_path);
    }

    public static function newTempFile()
    {
        return new File(tempnam(self::TMP_DIR,"tmp_"));
    }

    public function __toArray()
    {
        $result = array();

        $result["full_path"] = $this->getFullPath();
        $result["path"] = $this->getPath();
        $result["name"] = $this->getName();
        $result["extension"] = $this->getExtension();
        $result["full_extension"] = $this->getFullExtension();
        $result["type"] = "file";

        $size = $this->getSize();

        $result["size"] = $size;

        $result["size_auto"] = $size." bytes";
        if ($size>1024*2)
            $result["size_auto"] = ($size/1024)." KB";
        if ($size>(1024^2)*2)
            $result["size_auto"] = ($size/(1024^2))." MB";
        if ($size>((1024^3)*2))
            $result["size_auto"] = ($size/(1024^3))." GB";

        return $result;
    }

}

?>