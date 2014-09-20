<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

class TestBackup extends UnitTestCase
{
    function testBackupDir()
    {
        $resulting_path = Backup::backup_dir("/".FRAMEWORK_CORE_PATH."tests/io/advances_dir_list/");

        $f = new File($resulting_path);

        $this->assertTrue($f->exists(),"Il file di backup non e' stato creato!!");

        $this->assertTrue($f->getSize()>0,"Il file ha dimensione nulla!!");

        $f->delete();
    }

/*
    function testBackupDirAndRestore()
    {
        $original_path = "/".FRAMEWORK_CORE_PATH."tests/io/advances_dir_list/";

        Backup::backup_dir($original_path);

        $copy_path = "/".FRAMEWORK_CORE_PATH."tests/io/copy_advances_dir_list/";
        $d = new Dir($original_path);
        $d->copy($copy_path);

        $copy_dir = new Dir($copy_path);
        $this->assertTrue($copy_dir->exists(),"La directory della copia dei file non e' stata creata!!");

        if ($copy_dir->exists())
            $d->delete(true);

        Backup::restore_dir($original_path);

        $d2 = new Dir($copy_path);

        $all_files = $d2->listFiles();

        foreach ($all_files as $f)
        {
            $name = $f->getFilename();

            $f2 = $d->newFile($name);

            $this->assertTrue($f2->exists(),"Il file backuppato non e' stato rigenerato!!");
            $this->assertEqual($f2->getSize(),$f->getSize(),"La dimensione del file ricreato non coincide!!");
        }
    }
*/
}



?>