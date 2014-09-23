<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

abstract class Storage
{
    const DEFAULT_STORAGE_ROOT = "/include/storage/";
    const VALID_FOLDER_AND_STORAGE_NAME_PATTERN = "/^[0-9_a-z\-\.]+$/i";
    
    private static $storage_root = self::DEFAULT_STORAGE_ROOT;
    
    private $folder;
    private $name;
    protected $storage_dir;
    protected $storage_file;

    const PROPERTIES_STORAGE = ".ini";
    const XML_STORAGE = ".xml";
    const DATA_STORAGE = ".dat";
    
    public static function storage_root_exists()
    {
        $d = new Dir(self::$storage_root);
        return $d->exists();
    }
    
    public static function get_default_storage_root()
    {
        return self::DEFAULT_STORAGE_ROOT;
    }
    
    public static function get_storage_root()
    {
        return self::$storage_root;
    }
    
    public static function set_storage_root($new_root)
    {
        self::$storage_root = $new_root;
    }

    public static function byExtension($folder,$name,$extension)
    {
        $my_type = ".".$extension;
        switch ($my_type)
        {
            case self::DATA_STORAGE : return new DataStorage($folder,$name);
            case self::PROPERTIES_STORAGE : return new PropertiesStorage($folder,$name);
            case self::XML_STORAGE : return new XMLStorage($folder,$name);
            default : throw new InvalidParameterException("Estensione di storage non supportata!");
        }
    }

    public static function getDataStorage($folder,$name)
    {
        return new DataStorage($folder,$name,self::DATA_STORAGE);
    }

    public static function getPropertiesStorage($folder,$name)
    {
        return new PropertiesStorage($folder,$name,self::PROPERTIES_STORAGE);
    }

    public static function getXMLStorage($folder,$name)
    {
        return new XMLStorage($folder,$name,self::XML_STORAGE);
    }
    
    protected function __construct($folder,$name,$storage_type)
    {
        /*
        if (!preg_match(self::VALID_FOLDER_AND_STORAGE_NAME_PATTERN,$folder))
            throw new IOException("Nome del folder non valido!");
        
        if (!preg_match(self::VALID_FOLDER_AND_STORAGE_NAME_PATTERN,$name))
            throw new IOException("Nome del file non valido!");
        */

        $this->folder = $folder;
        $this->name = $name;
        
        $storage_dir = self::get_verified_storage();

        $this->storage_type = $storage_type;
        $this->storage_dir = new Dir($storage_dir->getPath().$folder.DS);
        $this->storage_file = new File($storage_dir->getPath().$folder.DS.$name.$storage_type);
    }

    function getStorageType()
    {
        return $this->storage_type;
    }
    
    function getFolder()
    {
        return $this->folder;
    }
    
    function getName()
    {
        return $this->name;
    }
    
    function exists()
    {
        return $this->storage_file->exists();
    }
    
    function create()
    {
        $this->storage_dir->touch();
        $this->storage_file->touch();
    }
    
    function delete()
    {
        $this->storage_file->delete();
    }


    private static function get_verified_storage()
    {
        $protected_storage_dir = new Dir(self::$storage_root);
        if (!$protected_storage_dir->exists())
            throw new IOException("La cartella dello storage non esiste : ".self::$storage_root);
        
        if (count($protected_storage_dir->listFiles())>1) 
        {
            throw new IOException("Lo storage non è valido.");
        }
        if ($protected_storage_dir->isEmpty())
            $protected_storage_dir->newRandomSubdir();
            
        return $protected_storage_dir->getSingleSubdir();
    }
    
    /*
     * Ritorna tutti gli storage all'interno di una determinata cartella.
     * Se la cartella non esiste viene creata.
     */

    static function getAll($folder)
    {
        $real_storage_dir = Storage::get_verified_storage();
        
        $result = array();
        
        $folder_dir = new Dir($real_storage_dir->getPath().$folder.DS);
        if (!$folder_dir->exists())
                $real_storage_dir->newSubdir($folder);
        
        $all_storages_files = $folder_dir->listFiles();
        foreach ($all_storages_files as $f)
        {
            if ($f->isFile())
                $result[] = Storage::byExtension($folder,$f->getName(),$f->getExtension());
        }
        return $result;
    }

    /*
     * Elimina tutte le cartelle di storage vuote.
     */

    private static function __recursive_clean($dir)
    {
        $folders = $dir->listFiles();
        foreach ($folders as $folder)
        {
            if ($folder->isEmpty())
                $folder->delete();
            else
                self::__recursive_clean($folder);
        }
    }
    /*
     * Rimuove tutte le directory vuote presenti nello storage.
     * Funziona ricorsivamente.
     * */
    public static function clean()
    {
        $real_storage_dir = Storage::get_verified_storage();
        self::__recursive_clean($real_storage_dir);

    }
}

?>