<?php

/* This software is released under the BSD license. Full text at project root -> license.txt */

class Cache 
{
    const DEFAULT_CACHE_FILE_EXTENSION = ".key";
    const DEFAULT_EXPIRE_TIME = 86400;  //1 day
    const DEFAULT_CACHE_DIR = "/tmp/cache";
    
    private static $cache_expire_time = self::DEFAULT_EXPIRE_TIME;
    private static $cache_dir = null;
    
    public static function get_cache_expire_time()
    {
        return self::$cache_expire_time;
    }
    
    public static function set_cache_expire_time($expire_time)
    {
        self::$cache_expire_time = $expire_time;
    }
    
    public static function get_cache_dir()
    {
        return self::$cache_dir;
    }
    
    public static function set_cache_dir($dir)
    {
        if ($dir instanceof Dir)
            self::$cache_dir = $dir;
        else
            self::$cache_dir = new Dir($dir);
    }
    
    private static function init()
    {
        if (self::$cache_dir===null)
            self::set_cache_dir(self::DEFAULT_CACHE_DIR);
        
        if (!self::$cache_dir->exists())
            self::$cache_dir->touch();
        
        $files = self::$cache_dir->listFiles();
        
        foreach ($files as $f)
        {
            if (time()-$f->getLastAccessTime()>self::$cache_expire_time)
                $f->delete();
        }
        
    }
    
    public static function delete()
    {
        self::init();
        self::$cache_dir->delete(true);
    }
    
    public static function has_key($key)
    {
        self::init();
        
        $files = self::$cache_dir->listFiles();
        foreach ($files as $f)
        {
            if ($f->getFilename()===$key.self::DEFAULT_CACHE_FILE_EXTENSION)
                return true;
        }
        return false;
    }
    
    public static function get($key)
    {
        self::init();
        
        $files = self::$cache_dir->listFiles();
        foreach ($files as $f)
        {
            if ($f->getFilename()===$key.self::DEFAULT_CACHE_FILE_EXTENSION)
                return $f->getContent();
        }
        
        throw new IOException("Cache element not found!!");
    }
    
    public static function get_path($key)
    {
        self::init();
        
        $files = self::$cache_dir->listFiles();
        foreach ($files as $f)
        {
            if ($f->getFilename()===$key.self::DEFAULT_CACHE_FILE_EXTENSION)
                return $f->getPath();
        }
        
        throw new IOException("Cache element not found : current dir permissions : ".self::$cache_dir->getPermissions()." . Maybe needed rw perms?");
    }
    
    public static function set($key,$content)
    {
        self::init();
        
        $f = self::$cache_dir->newFile($key.self::DEFAULT_CACHE_FILE_EXTENSION);
    
        $f->setContent($content);
    }
}

?>