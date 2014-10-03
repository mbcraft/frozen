<?php

/* This software is released under the BSD license. Full text at project root -> license.txt */

class Backup
{
    const BACKUP_DIR = "/tmp/backup/";

    const DIR_BACKUP_TYPE = "dir_backup";

    static $current_backup_dir = self::BACKUP_DIR;

    public static function get_current_backup_dir()
    {
        return self::$current_backup_dir;
    }

    private static function checkBackupDir()
    {
        $d = new Dir(self::$current_backup_dir);
        $d->touch();
    }

    public static function set_current_backup_dir($new_backup_dir)
    {
        if ($new_backup_dir instanceof File)
            self::$current_backup_dir = $new_backup_dir->getPath();
        else
            self::$current_backup_dir = $new_backup_dir;
    }

    public static function backup_dir($dir)
    {
        self::checkBackupDir();

        if ($dir instanceof Dir)
            $d = $dir;
        else
            $d = new Dir($dir);

        $file = new File(self::getDirBackupFile($d));

        FGArchive::compress($file,$d,array("type"=>"dir_backup","description"=>"Backup of dir ".$d->getPath()));

        return $file->getPath();
    }

    public static function is_backup_file($f)
    {
        $properties = FGArchive::getArchiveProperties($f);

        if (isset($properties["type"]) && $properties["type"]==self::DIR_BACKUP_TYPE)
            return true;
        else
            return false;
    }

    public static function restore_dir($dir)
    {
        $backup_dir = new Dir(self::$current_backup_dir);
        if (!$backup_dir->exists())
            return false;

        if ($dir instanceof Dir)
            $d = $dir;
        else
            $d = new Dir($dir);

        $file = new File(self::getDirBackupFile($d));

        FGArchive::extract($file,$dir);

        return $file->getPath();
    }

    public static function is_table_backupped($table_name)
    {
        $f = self::getTableBackupFile($table_name);
        return $f && $f->exists() && !$f->isEmpty();
    }

    private static function getTableBackupFile($table_name)
    {
        return new File(self::$current_backup_dir.md5($table_name).".tbk");
    }

    public static function is_dir_backupped($table_name)
    {
        $f = self::getDirBackupFile($table_name);
        return $f && $f->exists() && !$f->isEmpty();
    }

    private static function getDirBackupFile($dir)
    {
        return new File(self::$current_backup_dir.md5($dir->getPath()).".fga");
    }

    public static function backup_table($table_name)
    {
        self::checkBackupDir();

        if (!DB::isConnectionOpen())
        {
            $keep_open = false;
            DB::openDefaultConnection();
        }
        else
            $keep_open = true;

        $exporter = DB::newTableDataImportExport();
        $exporter->export_data_to_file($table_name,self::getTableBackupFile($table_name));

        if (!$keep_open)
            DB::closeConnection();
    }

    public static function restore_table($table_name)
    {
        $backup_dir = new Dir(self::$current_backup_dir);
        if  (!$backup_dir->exists())
            return false;

        if (!DB::isConnectionOpen())
        {
            $keep_open = false;
            DB::openDefaultConnection();
        }
        else
            $keep_open = true;

        $importer = DB::newTableDataImportExport();
        $importer->import_data_from_file(self::getTableBackupFile($table_name));

        if (!$keep_open)
            DB::closeConnection();

        return true;
    }
}

?>