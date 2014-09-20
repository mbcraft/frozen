<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */


require_once(FRAMEWORK_CORE_PATH."lib/io/__FileSystemElement.class.php");
require_once(FRAMEWORK_CORE_PATH."lib/io/Dir.class.php");
require_once(FRAMEWORK_CORE_PATH."lib/io/File.class.php");

class TestPlainDir extends UnitTestCase
{

    function testHasSubdirs()
    {
        $d = new Dir("/".FRAMEWORK_CORE_PATH."tests/io/advances_dir_list/");
        $this->assertFalse($d->hasSubdirs(),"Sono state trovate sottocartelle in una cartella che non ne ha!!");
    
        $d2 = new Dir("/".FRAMEWORK_CORE_PATH."tests/io/copy_source/");
        $this->assertTrue($d2->hasSubdirs(),"Non sono state trovate sottocartelle in una cartella che ne ha!!");
        
    }

    function testFindFilesBasic()
    {
        $d = new Dir("/".FRAMEWORK_CORE_PATH."tests/io/advances_dir_list/");
        
        $only_menu_ini = $d->findFiles("/[_]*menu[\.]ini/");
        $this->assertTrue(count($only_menu_ini)==1,"Il numero dei file trovati non corrisponde!!");       
        
    }
    
    function testFindFilesStartingWithBasic()
    {
        $d = new Dir("/".FRAMEWORK_CORE_PATH."tests/io/advances_dir_list/");
        
        $only_the_starting = $d->findFilesStartingWith("the");
        $this->assertTrue(count($only_the_starting)==1,"Il numero dei file trovati non corrisponde!!");       
        
    }

    function testFindFilesEndingWithBasic()
    {
        $d = new Dir("/".FRAMEWORK_CORE_PATH."tests/io/advances_dir_list/");
        
        $only_image_png = $d->findFilesEndingWith("image.png");
        
        $this->assertTrue(count($only_image_png)==2,"Il numero dei file trovati non corrisponde!!");       
        
    }
    
    function testSubdirs()
    {
        $root = new Dir("/".FRAMEWORK_CORE_PATH."tests/io/test_dir/");
        
        $subfolder = new Dir("/".FRAMEWORK_CORE_PATH."tests/io/test_dir/content_dir");
        
        $this->assertTrue($root->hasSubdirOrSame($subfolder));
        $this->assertFalse($subfolder->hasSubdirOrSame($root));
        $this->assertTrue($root->hasSubdirOrSame($root));
        $this->assertTrue($subfolder->hasSubdirOrSame($subfolder));
         
    }

    function testDirLevel()
    {
        $level_0 = new Dir("/");
        $this->assertEqual($level_0->getLevel(),0,"Il livello 0 della directory non e' corretto : ".$level_0->getLevel());
        
        $level_1 = new Dir("/test/");
        $this->assertEqual($level_1->getLevel(),1,"Il livello 1 della directory non e' corretto : ".$level_1->getLevel());
        
        $level_3 = new Dir("/test/js/mooo/");
        $this->assertEqual($level_3->getLevel(),3,"Il livello 3 della directory non e' corretto : ".$level_3->getLevel());
        
    }
    
    function testEquals()
    {
        $dir1= new Dir("/".FRAMEWORK_CORE_PATH."tests/io/test_dir/");
        
        $dir2 = new Dir("/".FRAMEWORK_CORE_PATH."tests/io/test_dir");
        
        $this->assertTrue($dir1->equals($dir2),"Le directory non coincidono!!");
    }

    function testRootTestDirectory()
    {
        $d1 = new Dir("/".FRAMEWORK_CORE_PATH."tests/io/test_dir/");

        $this->assertTrue($d1->exists(),"La directory di test non esiste!!!");
        $this->assertTrue($d1->isDir(),"La directory di test non è una directory!!!");
        $this->assertFalse($d1->isFile(),"La directory di test è un file!!!");
        
        $this->assertFalse($d1->isEmpty(),"La directory di test è vuota!!!");
    }

    function testEmptyDirectory()
    {
        $d2 = new Dir("/".FRAMEWORK_CORE_PATH."tests/io/test_dir/empty_dir");

        $this->assertTrue($d2->exists());
        $this->assertTrue($d2->isDir());
        $this->assertFalse($d2->isFile());
        //$this->assertTrue($d2->isEmpty()); //.svn ???
    }

    function verifyContentDir($content_dir)
    {
        $this->assertTrue($content_dir->isDir());
        $this->assertFalse($content_dir->isEmpty());
    }

    function verifyEmptyDir($empty_dir)
    {
        $this->assertTrue($empty_dir->isDir());

        $subdir = $empty_dir->newSubdir("test");
        
        $this->assertTrue($subdir->isEmpty());

        $this->assertTrue($subdir->delete(),"Impossibile cancellare una cartella vuota.");

        $this->assertFalse($subdir->exists());
    }

    function testGetParentDir()
    {
        $d1 = new Dir("/".FRAMEWORK_CORE_PATH."tests/io/test_dir/empty_dir");
        
        $parent = $d1->getParentDir();
        
        $this->assertEqual(DS.FRAMEWORK_CORE_PATH."tests/io/test_dir/",$parent->getPath());
    }

    function testDirectoryContent()
    {
        $d1 = new Dir("/".FRAMEWORK_CORE_PATH."tests/io/test_dir/");

        $this->assertTrue($d1->isDir());

        $content = $d1->listFiles();

        $this->assertEqual(3,count($content)); //.svn ???

        foreach ($content as $dir)
        {
            if ($dir->getName()=="content_dir")
                $this->verifyContentDir($dir);
            else
                $this->verifyEmptyDir($dir);
        }
    }


    function testHasSingleSubdir()
    {
        $dir = new Dir("/".FRAMEWORK_CORE_PATH."tests/io/test_dir/single_subdir/");
        
        $this->assertTrue($dir->hasSingleSubdir());
        
        $dir2 = new Dir("/".FRAMEWORK_CORE_PATH."tests/io/test_dir/content_dir/");
        
        $this->assertFalse($dir2->hasSingleSubdir());
        
        $dir3 = new Dir("/".FRAMEWORK_CORE_PATH."tests/io/test_dir/single_subdir/blablablax/");
        
        $this->assertFalse($dir3->hasSingleSubdir());
    }

    function testGetSingleSubdir()
    {
        $dir = new Dir("/".FRAMEWORK_CORE_PATH."tests/io/test_dir/single_subdir/");
        
        $sub_dir = $dir->getSingleSubdir();
        
        $this->assertEqual("/".FRAMEWORK_CORE_PATH."tests/io/test_dir/single_subdir/blablablax/",$sub_dir->getPath());
    }

    function testGetSingleSubdirFailManyElements()
    {
        $dir = new Dir("/".FRAMEWORK_CORE_PATH."tests/io/test_dir/content_dir/");
        
        try
        {
            $sub_dir = $dir->getSingleSubdir();
            $this->fail("Il metodo getSingleSubdir non ha lanciato l'eccezione prevista.");
        }
        catch (Exception $ex)
        {
        } 
    }

    function testGetSingleSubdirFailSingleFile()
    {
        $dir = new Dir("/".FRAMEWORK_CORE_PATH."tests/io/test_dir/single_subdir/blablablax/");
        
        try
        {
            $sub_dir = $dir->getSingleSubdir();
            $this->fail("Il metodo getSingleSubdir non ha lanciato l'eccezione prevista.");
        }
        catch (Exception $ex)
        {
        } 
    }
    
    function testCopy()
    {
        $source_dir = new Dir("/".FRAMEWORK_CORE_PATH."tests/io/copy_source/");
    
        $target_dir = new Dir("/".FRAMEWORK_CORE_PATH."tests/io/copy_target/");
        
        //pulisco la cartella di destinazione
        foreach ($target_dir->listFiles() as $f)
            $f->delete(true);
        
        $source_dir_elems = $source_dir->listFiles();
        foreach ($source_dir_elems as $elem)
        {
            $elem->copy($target_dir);
        }
        
        $tiny_file = new File("/".FRAMEWORK_CORE_PATH."tests/io/copy_target/my_tiny_file.txt");
        $this->assertTrue($tiny_file->exists(),"Il file non è stato copiato!!");
        $this->assertEqual($tiny_file->getContent(),"TINY TINY TINY","Il contenuto del file non corrisponde!!");
    
        $my_subdir = new Dir("/".FRAMEWORK_CORE_PATH."tests/io/copy_target/my_subdir");
        $this->assertTrue($my_subdir->exists(),"La sottocartella non è stata copiata!!");
        
        $another_file = new File("/".FRAMEWORK_CORE_PATH."tests/io/copy_target/my_subdir/another_file.txt");
        $this->assertTrue($another_file->exists(),"Il file non è stato copiato!!");
        $this->assertEqual($another_file->getContent(),"BLA BLA BLA","Il contenuto del file non corrisponde!!");
    
        foreach ($target_dir->listFiles() as $f)
            $f->delete(true);
    }


    function testTouch()
    {
        $d = new Dir("/".FRAMEWORK_CORE_PATH."tests/io/touch_test/my_new_dir/");
        $this->assertFalse($d->exists(),"La directory esiste già!");
        $d->touch();
        $this->assertTrue($d->exists(),"La directory non è stata creata!");
        try
        {
            $d->touch();
        //devo poter fare touch senza eccezioni su una directory che già esiste
        }
        catch (Exception $ex)
        {
            $this->fail("Impossibile fare touch() su una cartella già esistente senza lanciare un'eccezione!!");
        }
        
        $d->delete();
        $this->assertFalse($d->exists(),"La directory non è stata cancellata!");
        
        
    }

    function testTouchSubdirs()
    {
        $d = new Dir("/".FRAMEWORK_CORE_PATH."tests/io/touch_test/my_new_dir/another_dir/again/");
        $this->assertFalse($d->exists(),"La directory esiste già!");
        $d->touch();
        $this->assertTrue($d->exists(),"La directory non è stata creata!");
        try
        {
            $d->touch();
            //devo poter fare touch senza eccezioni su una directory che già esiste
        }
        catch (Exception $ex)
        {
            $this->fail("Impossibile fare touch() su una cartella già esistente senza lanciare un'eccezione!!");
        }

        $d->delete();
        $this->assertFalse($d->exists(),"La directory non è stata cancellata!");

        $d_root = new Dir("/".FRAMEWORK_CORE_PATH."tests/io/touch_test/my_new_dir");
        $d_root->delete(true);
        $this->assertFalse($d->exists(),"La directory root dell'albero esiste ancora!!");

    }

    function testRenameDirs()
    {
        $d = new Dir("/".FRAMEWORK_CORE_PATH."tests/io/rename_test/dir/");
        $d->touch();

        $this->assertTrue($d->exists(),"La directory non e' stata creata!!");

        $f1 = $d->newFile("my_file.txt");
        $f1->setContent("Ciao!!");

        $this->assertTrue($f1->exists(),"Il file non e' stato creato nella cartella!!");

        $d2 = new Dir("/".FRAMEWORK_CORE_PATH."tests/io/rename_test/target/");
        $d2->delete(true);
        $this->assertFalse($d2->exists(),"La directory esiste gia'!!");
        $this->assertTrue($d->rename("target"));

        $this->assertFalse($d->exists(),"La directory non e' stata rinominata con successo!!");
        $this->assertTrue($d2->exists(),"La directory non e' stata rinominata con successo!!");
        $f2 = new File("/".FRAMEWORK_CORE_PATH."tests/io/rename_test/target/my_file.txt");
        $this->assertTrue($f2->exists(),"Il file non e' stato spostato insieme alla directory!!");

        $d3 = new Dir("/".FRAMEWORK_CORE_PATH."tests/io/rename_test/existing_dir/");
        $this->assertFalse($d2->rename("existing_dir"),"Il rename e' stato effettuato su una directory che gia' esiste!!");

        $this->assertFalse($d2->isEmpty(),"La directory non spostata non contiene piu' il suo file!!");
        $this->assertTrue($d3->isEmpty(),"La directory gia' esistente e' stata riempita con pattume!!");

        $this->expectException("InvalidParameterException");
        $d4 = new Dir("/".FRAMEWORK_CORE_PATH."tests/io/rename_test/another_target/buh/");
        $this->assertFalse($d2->rename("another_target/buh"),"Rename con spostamento andato a buon fine!!");

        $d2->delete(true);
    }

    function testPatternHiddenFiles()
    {
        $pattern = Dir::$showHiddenFiles;
        
        $this->assertTrue(preg_match($pattern[0],"."));
        $this->assertTrue(preg_match($pattern[0],".."));
        $this->assertFalse(preg_match($pattern[0],".htaccess"));
        $this->assertFalse(preg_match($pattern[0],"prova.txt"));
    }

    function testPatternNoHiddenFiles()
    {
        $pattern = Dir::$noHiddenFiles;
        
        $this->assertTrue(preg_match($pattern[0],"."));
        $this->assertTrue(preg_match($pattern[0],".."));
        $this->assertTrue(preg_match($pattern[0],".htaccess"));
        $this->assertFalse(preg_match($pattern[0],"prova.txt"));
    }

    function testListFiles()
    {
        $d = new Dir("/".FRAMEWORK_CORE_PATH."tests/io/list_files_test/");
                
        $this->assertEqual(count($d->listFiles()),2,"Il numero di file col list di default non corrisponde!!");
        $this->assertEqual(count($d->listFiles(Dir::DEFAULT_EXCLUDES)),2,"Il numero di file col list di default non corrisponde!!");
        
        $this->assertEqual(count($d->listFiles(Dir::NO_HIDDEN_FILES)),2,"Il numero di file col list di default non corrisponde!!");
        
        $this->assertTrue(count($d->listFiles(Dir::SHOW_HIDDEN_FILES))>=3,"Il numero di file col list dei file nascosti non corrisponde!!");
           
        $expected_names = array(".htaccess",".svn","plain.txt","a_dir");
        $files = $d->listFiles(Dir::SHOW_HIDDEN_FILES);

        foreach ($files as $f)
        {
            if ($f->isDir())
                $this->assertTrue(ArrayUtils::has_value($expected_names, $f->getName()));
            else
                $this->assertTrue(ArrayUtils::has_value($expected_names, $f->getFilename()));
        }
    }
     

    function testDeleteEmptyWithHidden()
    {

        $is_local = strpos($_SERVER["HTTP_HOST"],".")===false;

        if ($is_local)
        {
            $d = new Dir("/".FRAMEWORK_CORE_PATH."tests/io/delete_test_dir_empty/the_dir/");
            $this->assertTrue($d->exists(),"La cartella dal eliminare non esiste!!");

            

            if (count($d->listFiles(Dir::SHOW_HIDDEN_FILES))==0)
            {
                $d->delete();
                $this->assertFalse($d->exists(),"La cartella dal eliminare e' stata eliminata!!");
            }
            else
            {
                $d->delete();
                $this->assertTrue($d->exists(),"La cartella dal eliminare non e' stata eliminata!!");
            }
            $d->touch();
        }
    }

    function testDeleteRealEmpty()
    {
        $d = new Dir("/".FRAMEWORK_CORE_PATH."tests/io/delete_test_dir_empty/real_empty_dir/");
        $this->assertFalse($d->exists(),"La cartella dal eliminare non esiste!!");

        $d->touch();

        $this->assertTrue($d->exists(),"La cartella da eliminare non è stata creata!!");
        $d->delete();
        $this->assertFalse($d->exists(),"La cartella da eliminare non è stata eliminata!!");

    }

    function testDeleteRecursive()
    {
        $d = new Dir("/".FRAMEWORK_CORE_PATH."tests/io/delete_test_dir/");
        $this->assertTrue($d->exists(),"La cartella dal eliminare non esiste!!");
        $this->assertTrue($d->isEmpty(),"La cartella da popolare non e' vuota!!");

        $the_dir = $d->newSubdir("the_dir");

        $blabla = $the_dir->newFile("blabla.ini");
        $blabla->setContent("[section]\n\nchiave=valore\n\n");
        $hidden_test = $the_dir->newSubdir("hidden_test");
        $htaccess = $hidden_test->newFile(".htaccess");
        $htaccess->setContent("RewriteEngine on\n\n");
        
        $prova = $hidden_test->newFile("prova.txt");
        $prova->setContent("Questo e' un file con un testo di prova");
        
        $the_dir->delete(true);
        $this->assertFalse($the_dir->exists(),"La directory non e' stata eliminata!!");
        $this->assertTrue($d->isEmpty(),"Il contenuto della cartella non e' stato rimosso completamente!!");

    }

    function testGetPathRelative()
    {
        $my_included_file = new Dir("/".FRAMEWORK_CORE_PATH."tests/io/include_teiop/");

        $rel_path = $my_included_file->getPath(new Dir("/".FRAMEWORK_CORE_PATH."tests"));
        $this->assertEqual("/io/include_teiop/",$rel_path,"Il percorso relativo non viene elaborato correttamente!! : ".$rel_path);

        $rel_path = $my_included_file->getPath(new Dir("/".FRAMEWORK_CORE_PATH."tests/io/"));
        $this->assertEqual("/include_teiop/",$rel_path,"Il percorso relativo non viene elaborato correttamente!! : ".$rel_path);

        $this->expectException("InvalidDataException");
        $this->assertEqual("/include_teiop/",$my_included_file->getPath(new Dir("/pluto/tests/io/include_test")),"Il percorso relativo non viene elaborato correttamente!!");

    }

     
}

?>