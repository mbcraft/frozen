<?php

/* This software is released under the BSD license. Full text at project root -> license.txt */

class ModuleArchiver
{
    const MODULES_ARCHIVE_DIR = "/tmp/modules/";

    static function save_as_archive($category_name,$module_name)
    {
        if (!AvailableModules::is_module_available($category_name, $module_name))
                throw new IllegalStateException("Il modulo ".$category_name."/".$module_name."non risulta disponibile!!");
        
        $d = new Dir(self::MODULES_ARCHIVE_DIR);
        $d->touch();
        
        $spec = AvailableModules::get_available_module_definition($category_name, $module_name);

        $category_name = $spec->get_category_name();
        $module_name = $spec->get_module_name();
        
        $version = $spec->get_current_version();
        
        $v = $version["major_version"]."_".$version["minor_version"]."_".$version["revision"];

        $archive_dir = new Dir(self::MODULES_ARCHIVE_DIR);
        $archive_dir->touch();
        
        $source_dir = new Dir(ModuleUtils::get_modules_path()."/".$category_name."/".$module_name."/");
        $target_file = $archive_dir->newFile($category_name."__".$module_name."-".$v.".ffa");
        
        $properties = array();
        $properties["category_name"] = $category_name;
        $properties["module_name"] = $module_name;
        $properties["major_version"] = $version["major_version"];
        $properties["minor_version"] = $version["minor_version"];
        $properties["revision"] = $version["revision"];
 
        return FFArchive::compress($target_file, $source_dir,$properties);
    }
    
    static function get_available_module_archives()
    {
        $d = new Dir(self::MODULES_ARCHIVE_DIR);
        $d->touch();
        
        $d = new Dir(self::MODULES_ARCHIVE_DIR);
        $all_files = $d->listFiles();
        $result = array();
        foreach ($all_files as $ff)
        {
            $result[] = $ff->getName();
        }
        
        return $result;
    }

    static function extract_from_archive($filename)
    {
        $modules_archive_dir = new Dir(self::MODULES_ARCHIVE_DIR);
        $modules_archive_dir->touch();
       
        $module_archive = $modules_archive_dir->newFile($filename);

        $properties = FFArchive::getArchiveProperties($module_archive);
        
        $module_dir = new Dir(ModuleUtils::get_modules_path()."/".$properties["category_name"]."/".$properties["module_name"]);
        
        return FFArchive::extract($module_archive, $module_dir);
    }
    
    static function download_from_repository($key,$module_name)
    {
        $target_file = new File(ModuleArchiver::MODULES_ARCHIVE_DIR.$key);
        Http::get_to_file(Config::instance()->MODULE_REPOSITORY_DOWNLOAD_URL."?key=".$key."&module_name=".$module_name, $target_file);
    }
    
    static function push_to_repository($key,$module_name)
    {
        $source_file = new File(ModuleArchiver::MODULES_ARCHIVE_DIR.$module_name);
        
        $params = array();
        $params["key"] = $key;
        $params["module_name"] = $module_name;
        $params["my_file"] = $source_file;
        
        Http::post(Config::instance()->MODULE_REPOSITORY_UPLOAD_URL,$params);
    }
    
    static function get_available_repository_modules($key)
    {
        $result =  Http::get(Config::instance()->MODULE_REPOSITORY_LIST_URL."&key=".$key);
    
        
    }


}

?>