<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */


class TestFileProps extends UnitTestCase
{

    function testProps()
    {
        $storage_test_root = "/".FRAMEWORK_CORE_PATH."tests/io/storage_dir/";
        Storage::set_storage_root($storage_test_root);

        $test_file = new File("/".FRAMEWORK_CORE_PATH."tests/io/file_props_test.php");

        $this->assertFalse($test_file->hasStoredProps(),"Il file ha delle proprieta' con lo storage vuoto!!");
        
        $storage = $test_file->getStoredProps();

        $storage->add("test", array("hello" => 1,"world" => "good"));

        $this->assertTrue($test_file->hasStoredProps(),"Il file storage delle proprieta' non e' stato creato!!");
        
        
        $file_path = $test_file->getPath();
        $sum = md5($file_path);
        $store_subdir = "_".substr($sum,0,1);
        
        $storage_test_root_dir = new Dir($storage_test_root); 
        $real_store_dir = $storage_test_root_dir->getSingleSubdir();
        
        $all_dirs = $real_store_dir->listFiles();
        $props_file_dir = $all_dirs[0];
        $this->assertEqual($props_file_dir->getName(),$store_subdir,"La directory creata non corrisponde!!");
        $final_stored_path = new File($real_store_dir->getPath().$props_file_dir->getName().DS.$sum.".ini");
        
        $this->assertTrue($final_stored_path->exists(),"Il file finale delle props non e' stato trovato!!");
        
        $test_file->deleteStoredProps();
        $this->assertFalse($test_file->hasStoredProps(),"Il file delle proprieta' non e' stato eliminato!!");
        
        
        $all_files = $real_store_dir->listFiles();
        foreach ($all_files as $f) { $f->delete(true); }
        Storage::set_storage_root(Storage::get_default_storage_root());

    }

}

?>