<?php

/* This software is released under the BSD license. Full text at project root -> license.txt */

if (!defined("DS")) define("DS","/");

abstract class __FileSystemElement
{
    protected $__full_path;
    protected $__path;
    
    private static $defaultPermissionsRwx = "-rwxrwxrwx";

    public static function toOctalPermissions($rwx_permissions)
    {
        $mode = 00;
        if ($rwx_permissions[1] == 'r') $mode += 0400;
        if ($rwx_permissions[2] == 'w') $mode += 0200;
        if ($rwx_permissions[3] == 'x') $mode += 0100;
        else if ($rwx_permissions[3] == 's') $mode += 04100;
        else if ($rwx_permissions[3] == 'S') $mode += 04000;

        if ($rwx_permissions[4] == 'r') $mode += 040;
        if ($rwx_permissions[5] == 'w') $mode += 020;
        if ($rwx_permissions[6] == 'x') $mode += 010;
        else if ($rwx_permissions[6] == 's') $mode += 02010;
        else if ($rwx_permissions[6] == 'S') $mode += 02000;

        if ($rwx_permissions[7] == 'r') $mode += 04;
        if ($rwx_permissions[8] == 'w') $mode += 02;
        if ($rwx_permissions[9] == 'x') $mode += 01;
        else if ($rwx_permissions[9] == 't') $mode += 01001;
        else if ($rwx_permissions[9] == 'T') $mode += 01000;

        return $mode;
    }

    public static function toRwxPermissions($octal_permissions)
    {
        if (($octal_permissions & 0xC000) == 0xC000) {
            // Socket
            $info = 's';
        } elseif (($octal_permissions & 0xA000) == 0xA000) {
            // Symbolic Link
            $info = 'l';
        } elseif (($octal_permissions & 0x8000) == 0x8000) {
            // Regular
            $info = '-';
        } elseif (($octal_permissions & 0x6000) == 0x6000) {
            // Block special
            $info = 'b';
        } elseif (($octal_permissions & 0x4000) == 0x4000) {
            // Directory
            $info = 'd';
        } elseif (($octal_permissions & 0x2000) == 0x2000) {
            // Character special
            $info = 'c';
        } elseif (($octal_permissions & 0x1000) == 0x1000) {
            // FIFO pipe
            $info = 'p';
        } else {
            // Unknown
            $info = 'u';
        }

        // Owner
        $info .= (($octal_permissions & 0x0100) ? 'r' : '-');
        $info .= (($octal_permissions & 0x0080) ? 'w' : '-');
        $info .= (($octal_permissions & 0x0040) ?
                    (($octal_permissions & 0x0800) ? 's' : 'x' ) :
                    (($octal_permissions & 0x0800) ? 'S' : '-'));

        // Group
        $info .= (($octal_permissions & 0x0020) ? 'r' : '-');
        $info .= (($octal_permissions & 0x0010) ? 'w' : '-');
        $info .= (($octal_permissions & 0x0008) ?
                    (($octal_permissions & 0x0400) ? 's' : 'x' ) :
                    (($octal_permissions & 0x0400) ? 'S' : '-'));

        // World
        $info .= (($octal_permissions & 0x0004) ? 'r' : '-');
        $info .= (($octal_permissions & 0x0002) ? 'w' : '-');
        $info .= (($octal_permissions & 0x0001) ?
                    (($octal_permissions & 0x0200) ? 't' : 'x' ) :
                    (($octal_permissions & 0x0200) ? 'T' : '-'));

        return $info;
    }

    public static function setDefaultPermissionsOctal($perms)
    {
        self::$defaultPermissionsRwx = self::toRwxPermissions($perms);
    }

    public static function getDefaultPermissionsOctal()
    {
        return self::toOctalPermissions(self::$defaultPermissionsRwx);
    }

    public static function setDefaultPermissionsRwx($perms)
    {
        self::$defaultPermissionsRwx = $perms;
    }

    public static function getDefaultPermissionsRwx()
    {
        return self::$defaultPermissionsRwx;
    }
    
    /*
     * IL PERCORSO E' SEMPRE RELATIVO ALLA ROOT, quindi tutti i metodi devono sempre eventualmente 
     * tagliare quella parte.
     * Fare attenzione all'utilizzo 
     */
    protected function __construct($path)
    {
        //SAFETY NET, rimuovo tutti i .. all'interno del percorso.
        $path = str_replace(DS."..", "", $path);
        //pulizia doppie barre dai percorsi
        $path = str_replace("//", "/", $path);
        
        if (strpos($path,SITE_ROOT_PATH)===0)
        {
            echo "PATH TROVATO : ".$path."<br/>";
            throw new IOException("Errore : path contenente la root del sito.");
        }
        else
          $fp = SITE_ROOT_PATH.$path;
        
        //DISABILITATO, IL LINK DEL FRAMEWORK CREA GROSSI PROBLEMI
        //non posso determinare il path se esco dal SITE_ROOT_PATH (è ovvio)
        //la chiamata a realpath potrebbe far cambiare sia la seconda parte dell'url che la prima parte
        
        //IN QUESTO MODO CREO UNA JAIL ALL'INTERNO DEL SITO.  
        /*
        if (file_exists($fp))
        {
            $fp = realpath ($fp);
            if (strpos($path,SITE_ROOT_PATH)!==0)
                $fp = SITE_ROOT_PATH;
        }
           
        */
                
        $this->__full_path = $fp;
        $this->__full_path = str_replace(DIRECTORY_SEPARATOR,DS,$this->__full_path);
        
        $this->__path = substr($fp,strlen(SITE_ROOT_PATH),strlen($fp)-strlen(SITE_ROOT_PATH));
        $this->__path = str_replace(DIRECTORY_SEPARATOR,DS,$this->__path);

    }

    function equals($file_or_dir)
    {
        if ($file_or_dir instanceof __FileSystemElement)
            return $this->getFullPath() == $file_or_dir->getFullPath();
        else 
            return false;
    }
    
    function isDir()
    {
        return is_dir($this->__full_path);
    }

    function isFile()
    {
        return is_file($this->__full_path);
    }

    function exists()
    {
        return file_exists($this->__full_path);
    }

    function getLastAccessTime()
    {
        return fileatime($this->__full_path);
    }

    function getModificationTime()
    {
        return filemtime($this->__full_path);
    }

    function setPermissions($rwx_permissions)
    {
        $octal_permissions = self::toOctalPermissions($rwx_permissions);

        chmod($this->__full_path, $octal_permissions);
    }

    function hasPermissions($rwx_permissions)
    {
        $current_perms = $this->getPermissions();

        for ($i=0;$i<strlen($current_perms);$i++)
        {
            if ($rwx_permissions[$i]!=="-")
                if ($rwx_permissions[$i]!==$current_perms[$i])
                    return false;
        }
        return true;
    }
    
    function getPermissions()
    {
        $perms = fileperms($this->__full_path);

        return self::toRwxPermissions($perms);
    }

    /*
     * Rinomina l'elemento lasciando invariata la sua posizione (cartella padre).
     * */
    abstract function rename($new_name);
    /*
     * Sposta nella posizione di target, se target esiste viene sovrascritto.
     * */
    function move_to($target_dir,$new_name=null)
    {
        if ($new_name!=null)
            $name = $new_name;
        else
            $name = $this->getName();

        if ($this->isDir())
        {
            $dest = new Dir($target_dir->getPath()."/".$name);
        }
        else
        {
            $dest = new File($target_dir->getPath()."/".$name);
        }

        $target_dir->touch();

        return rename($this->getFullPath(),$dest->getFullPath());
    }

    abstract function copy($location);

    function dump()
    {
        echo "DUMP __FileSystemElement : ".$this->__full_path;
    }

    function getFullPath()
    {
        return $this->__full_path;
    }

    function getPath($relative_to=null)
    {
        if ($relative_to==null)
            return $this->__path;
        else
        {
            if ($relative_to instanceof Dir)
                $path = $relative_to->getPath();
            else
                $path = $relative_to;
            if (strpos($this->__path,$path)===0)
            {
                return DS.substr($this->__path,strlen($path));
            }
            else throw new InvalidDataException("Il percorso non comincia col percorso specificato : ".$this->__path." non comincia con ".$path);
        }
    }
        
    function hasStoredProps()
    {
        return $this->getStoredProps()->exists();
    }
    
    function deleteStoredProps()
    {
        $this->getStoredProps()->delete();
    }
    
    function getStoredProps()
    {
        $path = $this->__path;
        $path = str_replace("//", "/", $path);
        
        $path_md5 = md5($path);
        $folder = "_".substr($path_md5,0,1);
        return Storage::getPropertiesStorage($folder, $path_md5);
    }

    function __toString()
    {
        return $this->getPath();
    }

    abstract function getName();

}

?>