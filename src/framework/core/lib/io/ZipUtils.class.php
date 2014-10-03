<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

class ZipUtils
{
    public static function expandArchive($zip_file,$target_folder)
    {
        $zip_archive = new ZipArchive();
     
        if ($zip_file instanceof File)
            $real_zip_file = $zip_file;
        else
            $real_zip_file = new File($zip_file);
        
        
        if ($target_folder instanceof Dir)
            $target_dir = $target_folder;
        else
            $target_dir = new Dir($target_folder);
        
        $zip_archive->open($real_zip_file->getFullPath());
        
        $zip_archive->extractTo($target_dir->getFullPath());
        
        $zip_archive->close();
    }
    
    public static function createArchive($save_file,$folder_to_zip,$local_dir="/")
    {
        if ($folder_to_zip instanceof Dir)
            $dir_to_zip = $folder_to_zip;
        else
            $dir_to_zip = new Dir($folder_to_zip);
        
        $zip_archive = new ZipArchive();

        $zip_archive->open($save_file->getFullPath(),  ZipArchive::CREATE);

        ZipUtils::recursiveZipFolder($zip_archive, $dir_to_zip,$local_dir);

        $zip_archive->close();
    }
    
    private static function recursiveZipFolder($zip_archive,$current_folder,$local_dir)
    {        
        foreach ($current_folder->listFiles() as $dir_entry)
        {
            if ($dir_entry->isFile())
            {
                $zip_archive->addFile($dir_entry->getFullPath(),$local_dir.$dir_entry->getFilename());
            }
            else
            {
                $zip_archive->addEmptyDir($local_dir.$dir_entry->getName().DS);
                ZipUtils::recursiveZipFolder($zip_archive, $dir_entry,$local_dir.$dir_entry->getName().DS);
            }
        }
    }
}

?>