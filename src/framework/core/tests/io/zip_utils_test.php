<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */


class TestZipUtils extends UnitTestCase
{
    function testCreateArchive()
    {
        //controllo l'esistenza delle cartelle di test da utilizzare
        $create_dir = new Dir("/".FRAMEWORK_CORE_PATH."tests/io/zip_test/create/");
        $this->assertTrue($create_dir->exists(),"La directory create non esiste!!");
        
        $save_dir = new Dir("/".FRAMEWORK_CORE_PATH."tests/io/zip_test/saved/");
        $this->assertTrue($save_dir->exists(),"La directory save non esiste!!");
        
        
        $target_file = new File("/".FRAMEWORK_CORE_PATH."tests/io/zip_test/saved/test_archive.zip");
        $this->assertFalse($target_file->exists());
        
        $dir_to_zip = "/".FRAMEWORK_CORE_PATH."tests/io/zip_test/create/";
        
        ZipUtils::createArchive($target_file,$dir_to_zip);
        
        $this->assertTrue($target_file->exists(),"Il file zip non è stato creato!!");
        $this->assertTrue($target_file->getSize()>0,"Il file creato ha dimensione vuota!!");
        
        $target_file->delete();
        $this->assertFalse($target_file->exists(),"Il file zip non è stato eliminato!!");
        
        $saved_files = $save_dir->listFiles();
        foreach ($saved_files as $f)
        {
            $f->delete(true);
        }
    }
    
    function testExtractArchive()
    {
        $create_dir = new Dir("/".FRAMEWORK_CORE_PATH."tests/io/zip_test/create/");
        $this->assertTrue($create_dir->exists(),"La directory create non esiste!!");
        
        $save_dir = new Dir("/".FRAMEWORK_CORE_PATH."tests/io/zip_test/saved/");
        $this->assertTrue($save_dir->exists(),"La directory save non esiste!!");
        
        $extract_dir = new Dir("/".FRAMEWORK_CORE_PATH."tests/io/zip_test/extract/");
        $this->assertTrue($extract_dir->exists(),"La directory extract non esiste!!");
        
        $extract_dir_files = $extract_dir->listFiles();
        foreach ($extract_dir_files as $f)
        {
            $f->delete(true);
        }
        
        $target_file = new File("/".FRAMEWORK_CORE_PATH."tests/io/zip_test/saved/test_archive.zip");
        $this->assertFalse($target_file->exists());
        
        $dir_to_zip = "/".FRAMEWORK_CORE_PATH."tests/io/zip_test/create/";
        
        ZipUtils::createArchive($target_file,$dir_to_zip);
        
        $this->assertTrue($target_file->exists(),"Il file zip non è stato creato!!");
        $this->assertTrue($target_file->getSize()>0,"Il file creato ha dimensione vuota!!");
        
        //ora estraggo l'archivio
        $extract_root = "/".FRAMEWORK_CORE_PATH."tests/io/zip_test/extract/";
        
        
        ZipUtils::expandArchive($target_file, $extract_root);
        
        $this->assertEqual(count($extract_dir->listFiles()),3,"Il numero dei file estratti non corrisponde!!");
        $f1 = new File($extract_root."my_file_01.php");
        $this->assertTrue($f1->exists(),"Il file my_file_01.php non e' stato estratto!!");
        $this->assertTrue(!$f1->isEmpty(),"Il file my_file_01.php e' vuoto!!");
        
        $d1 = new Dir($extract_root."another_dir/");
        $d2 = new Dir($extract_root."my_subdir/");
        $f2 = new File($extract_root."another_dir/blabla.ini");
        $this->assertTrue($f2->exists(),"Il file blabla.ini non e' stato estratto!!");
        $this->assertTrue(!$f2->isEmpty(),"Il file blabla.ini e' vuoto!!");
                
        $saved_files = $save_dir->listFiles();
        foreach ($saved_files as $f)
        {
            $f->delete(true);
        }
        
        $extracted_files = $extract_dir->listFiles();
        foreach ($extracted_files as $f)
        {
            $f->delete(true);
        }
        
    }
}

?>