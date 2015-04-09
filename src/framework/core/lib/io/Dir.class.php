<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

/*
 * Rappresenta un puntatore a un determinato percorso, in questo caso una directory
 */
class Dir extends __FileSystemElement
{

    
    const DEFAULT_EXCLUDES = "NO_HIDDEN_FILES";

    const NO_HIDDEN_FILES = "NO_HIDDEN_FILES";
    static $noHiddenFiles = array("/\A\..*\Z/");
    const SHOW_HIDDEN_FILES = "SHOW_HIDDEN_FILES";
    static $showHiddenFiles = array("/\A[\.][\.]?\Z/");

    function __construct($path)
    {
        if ($path=="") $new_path = DS;
        //replace \ with /
        $new_path = str_replace("\\", DS, $path);
        
        if (substr($new_path,strlen($new_path)-1,1)!=DS) 
                $new_path=$new_path.DS;
       
        parent::__construct($new_path);
        
    }
    
    function visit($visitor)
    {
        $visitor->visit($this);
        
        $all_folders = $this->listFolders();
        
        foreach ($all_folders as $fold)
        {
            $visitor->visit($fold);
        }
    }
    
    /*
     * Ritorna il livello della directory :
     * / : 0
     * /test/ : 1
     * /test/js/mooo/ : 3
     */
    function getLevel()
    {
        preg_match_all("/\//", $this->__path,$matches);
        return count($matches[0])-1;
    }
    
    function touch()
    {
        if (!$this->exists())
        {
            @mkdir($this->__full_path,  self::getDefaultPermissionsOctal(),true);
        }
        else
            touch($this->__full_path);
    }



    function getParentDir()
    {
        $parent_dir = dirname($this->__full_path);
        
        $relative_parent_dir = substr($parent_dir,strlen(SITE_ROOT_PATH),strlen($parent_dir)-strlen(SITE_ROOT_PATH));
        
        return new Dir($relative_parent_dir);
    }

    /*
   * Rinomina il file senza effettuare spostamenti di sorta.
   * */
    function rename($new_name)
    {
        if (strstr($new_name,"/")!==false)
            throw new InvalidParameterException("Il nome contiene caratteri non ammessi ( / )!!");

        $parent_dir = $this->getParentDir();

        $target_path = $parent_dir->getPath()."/".$new_name;

        $target_dir = new Dir($target_path);
        if ($target_dir->exists()) return false;

        return rename($this->__full_path,$target_dir->getFullPath());
    }
    
    function getName()
    {
        return $this->getDirName();
    }

    function getDirName()
    {
        return basename($this->__full_path);
    }
        
    function hasSubdirOrSame($subdir)
    {         
        while (strlen($subdir->getFullPath()) >= strlen($this->getFullPath()))
        {

            if ($this->equals($subdir))
                return true;
            else
                return $this->hasSubdirOrSame($subdir->getParentDir());
        }
        return false;             
    }
    
    /*
     * Crea una nuova sottocartella con dei caratteri casuali.
     */
    function newRandomSubdir()
    {
        return $this->newSubdir(Random::newHexString());    
    }

    function newSubdir($name)
    {
        if (FileSystemUtils::isDir($this->__path.DS.$name))
        {
            //directory already exists
            //echo "Directory already exists : ".$this->__full_path."/".$name;
            return new Dir($this->__path.DS.$name);
        }
        if (FileSystemUtils::isFile($this->__path.DS.$name))
        {
            throw new __IOException();
        }
        //directory or files do not exists
        
        $result = @mkdir($this->__full_path.$name, __FileSystemElement::getDefaultPermissionsOctal(),true);
        
        
        if ($result==true)
            return new Dir($this->__path.$name);
        else
        {
            throw new IOException("Unable to create dir : ".$this->__full_path.$name);
        }

    }
/*
 * TESTED
 */
    function isEmpty()
    {
        return count($this->listFiles())===0;
    }

    function listFolders($myExcludes=self::DEFAULT_EXCLUDES)
    {
        $excludesSet = false;

        if (!$excludesSet && $myExcludes === self::NO_HIDDEN_FILES)
        {
            $excludesSet = true;
            $excludes = self::$noHiddenFiles;
        }

        if (!$excludesSet && $myExcludes === self::SHOW_HIDDEN_FILES)
        {
            $excludesSet = true;
            $excludes = self::$showHiddenFiles;
        }
        if (!$excludesSet)
            $excludes = $myExcludes;

        $all_results = scandir($this->__full_path);

        $all_dirs = array();

        foreach ($all_results as $element)
        {
            $skip = false;
            foreach ($excludes as $pt)
            {
                if (preg_match($pt, $element))
                {
                    $skip = true;
                }
            }

            //è da saltare?
            if (!$skip)
            {
                if ($this->isDir())
                    $partial_path = $this->__path.$element;

                if (FileSystemUtils::isDir($this->__path.$element))
                    $all_dirs[] = new Dir($partial_path);
            }

        }

        return $all_dirs;
    }
/*
 * TESTED
 */
    function listFiles($myExcludes=self::DEFAULT_EXCLUDES)
    {     
        $excludesSet = false;
        
        if (!$excludesSet && $myExcludes === self::NO_HIDDEN_FILES) 
        {
            $excludesSet = true;
            $excludes = self::$noHiddenFiles;
        }
        
        if (!$excludesSet && $myExcludes === self::SHOW_HIDDEN_FILES) 
        {
            $excludesSet = true;
            $excludes = self::$showHiddenFiles;
        }
        if (!$excludesSet)
            $excludes = $myExcludes;

        $all_results = scandir($this->__full_path);

        $all_dirs = array();
        $all_files = array();
        
        foreach ($all_results as $element)
        {            
            $skip = false;
            foreach ($excludes as $pt)
            {
                if (preg_match($pt, $element)) 
                {
                    $skip = true;
                }
            }

            //è da saltare?
            if (!$skip)
            {
                if ($this->isDir())
                    $partial_path = $this->__path.$element;
                
                if (FileSystemUtils::isDir($this->__path.$element))
                    $all_dirs[] = new Dir($partial_path);
                else
                if (FileSystemUtils::isFile($this->__path.DS.$element))
                    $all_files[] = new File($partial_path);
            }                

        }
      
        return array_merge($all_dirs, $all_files);

    }
    
    function findFilesStartingWith($string)
    {
        $dot_escaped = str_replace(".", "[\.]", $string);
        return $this->findFiles("/\A".$dot_escaped."/");
    }
    
    function findFilesEndingWith($string)
    {
        $dot_escaped = str_replace(".", "[\.]", $string);
        return $this->findFiles("/".$dot_escaped."\Z/");
    }
    
    function findFiles($myIncludes)
    {
        if (is_array($myIncludes))
            $includes = $myIncludes;
        else
            $includes = array($myIncludes);
        
        $all_results = scandir($this->__full_path);

        $all_dirs = array();
        $all_files = array();
        
        foreach ($all_results as $element)
        {            
            $include = false;
            $done = false;
            foreach ($includes as $pt)
            {
                if (!$done && preg_match($pt, $element)) 
                {
                    $include = true;
                    $done = true;
                }
            }

            //è da saltare?
            if ($include)
            {
                if ($this->isDir())
                    $partial_path = $this->__path.$element;
                
                if (FileSystemUtils::isDir($this->__path.$element))
                    $all_dirs[] = new Dir($partial_path);
                else
                if (FileSystemUtils::isFile($this->__path.DS.$element))
                    $all_files[] = new File($partial_path);
            }                

        }
      
        return array_merge($all_dirs, $all_files);
    }

    function newFile($name)
    {
        return new File($this->__path.DS.$name);
    }

    /*
     * Cancella la cartella. $recursive è true, cancella anche tutto il contenuto ricorsivamente.
     * Ritorna true se l'operazione è riuscita, false altrimenti.
     */
    function delete($recursive = false)
    {
        if ($recursive)
        {
            $dir_content = $this->listFiles(Dir::SHOW_HIDDEN_FILES);
            foreach ($dir_content as $elem)
            {
                if ($elem instanceof Dir)
                    $elem->delete(true);
                else
                    $elem->delete();
            }
        }

        return @rmdir($this->__full_path);
    }
    
    function hasSingleSubdir()
    {
        $content = $this->listFiles();
        if (count($content)==1)
        {
            $dir_elem = $content[0];
            if ($dir_elem->isDir()) return true;
        }
        return false;
    }

    function randomRename()
    {}
    
    function getSingleSubdir()
    {
        $content = $this->listFiles();
        if (count($content)==1)
        {
            $dir_elem = $content[0];
            if ($dir_elem->isDir()) return $dir_elem;
            throw new Exception("L'elemento presente all'interno della directory non è una cartella.");
        }
        throw new Exception("Errore nell'esecuzione del metodo getSingleSubdir. Numero elementi:".count($content));
    }

    function hasSubdirs()
    {
        $content = $this->listFiles();
        foreach ($content as $f)
        {
            if ($f->isDir()) return true;
        }
        return false;
    }
    
    /*
     * Copia una cartella all'interno di un'altra sottocartella
     */
    function copy($path,$new_name=null)
    {
        if ($path instanceof Dir)
            $target_dir = $path;
        else
            $target_dir = new Dir($path);

        if ($target_dir instanceof Dir)
        {          
            if ($new_name==null)
                $new_name = $this->getName();
            
            $copy_dir = $target_dir->newSubdir($new_name);
            
            $all_files = $this->listFiles();
            foreach ($all_files as $elem)
            {
                $elem->copy($copy_dir);
            }
        }

    }

    function isParentOf($folder)
    {
        if ($folder instanceof Dir)
            $d = $folder;
        else
            $d = new Dir($folder);

        $path_a = $this->getPath();
        $path_b = $d->getPath();

        return StringUtils::starts_with($path_b,$path_a);
    }

    function __toArray()
    {
        $result = array();
        
        $result["full_path"] = $this->getFullPath();
        $result["path"] = $this->getPath();
        $result["name"] = $this->getDirName();
        $result["type"] = "dir";
        $result["empty"] = $this->isEmpty();

        return $result;
    }

}

?>