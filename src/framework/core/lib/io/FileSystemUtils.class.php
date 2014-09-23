<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

/*START-PHP-CONTENT*/

class FileSystemUtils
{
    static function isCurrentDirName($name)
    {
        return $name==".";
    }

    static function isParentDirName($name)
    {
        return $name=="..";
    }

    static function isFile($path)
    {
        return is_file(SITE_ROOT_PATH.$path);
    }

    static function isDir($path)
    {
        return is_dir(SITE_ROOT_PATH.$path);
    }

    static function getWorkingDirectory()
    {
        return new Dir(getcwd());
    }

    static function setWorkingDirectory($new_dir)
    {
        if ($new_dir instanceof Dir)
            chdir($new_dir->__full_path);
        else
            chdir($new_dir);
    }

    static function getFreeDiskSpace()
    {
        return disk_free_space(SITE_ROOT_PATH);
    }

    static function getTotalDiskSpace()
    {
        return disk_total_space(SITE_ROOT_PATH);
    }


}

/*END-PHP-CONTENT*/

?>