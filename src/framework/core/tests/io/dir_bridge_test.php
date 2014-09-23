<?php

class TestDirBridge extends UnitTestCase
{
    
    function testAdd()
    {
        $module_plug_test_root = new Dir("/".FRAMEWORK_CORE_PATH."tests/base/module_plug_root/");
        $module_plug_test_root->newSubdir("blocks")->touch();

        $target_dir = new Dir("/".FRAMEWORK_CORE_PATH."tests/base/module_plug_root/");

        $plug = new DirBridge($target_dir,new Dir("/".FRAMEWORK_CORE_PATH."tests/base/fakeroot/modules/ecommerce/cart/"));

        $plug->add("js/");
        $plug->add("blocks/test.block.php");


        $f_block = new File("/".FRAMEWORK_CORE_PATH."tests/base/module_plug_root/blocks/test.block.php");
        $this->assertTrue($f_block->exists(),"Il file test.block.php non e' stato copiato!!");

        $f_no_plug = new File("/".FRAMEWORK_CORE_PATH."tests/base/module_plug_root/blocks/no_plug.block.php");
        $this->assertFalse($f_no_plug->exists(),"Il file no_plug.block.php e' stato copiato!!");

        $f_jslib1 = new File("/".FRAMEWORK_CORE_PATH."tests/base/module_plug_root/js/my_js_lib/mylib.js");
        $this->assertTrue($f_jslib1->exists(),"Il file libreria js1 non e' stato copiato!!");

        $f_jslib2 = new File("/".FRAMEWORK_CORE_PATH."tests/base/module_plug_root/js/my_js_lib/mylib2.js");
        $this->assertTrue($f_jslib2->exists(),"Il file libreria js2 non e' stato copiato!!");

        $all_module_plug_files = $module_plug_test_root->listFiles();
        foreach ($all_module_plug_files as $ff)
            $ff->delete(true);
    }

    function testRemove()
    {
        $module_plug_test_root = new Dir("/".FRAMEWORK_CORE_PATH."tests/base/module_plug_root/");
        $target_dir = new Dir("/".FRAMEWORK_CORE_PATH."tests/base/module_plug_root/");

        $plug = new DirBridge($target_dir,new Dir("/".FRAMEWORK_CORE_PATH."tests/base/fakeroot/modules/ecommerce/cart/"));


        $sub_dir = $module_plug_test_root->newSubdir("blocks");

        $block_file = $sub_dir->newFile("test.block.php");
        $block_file->setContent("BLA BLA BLA");

        $this->assertTrue($block_file->exists(),"Il file test.block.php non e' presente!!");

        $plug->remove("blocks/test.block.php");

        $this->assertFalse($block_file->exists(),"Il file test.block.php non e' stato rimosso!!");

        $js_dir = $module_plug_test_root->newSubdir("js");
        $js_dir->touch();

        $my_js_lib_subdir = $js_dir->newSubdir("my_js_lib");
        $my_js_lib_subdir->touch();

        $mylib_file = $my_js_lib_subdir->newFile("mylib.js");
        $mylib_file->setContent("HELLO!!");
        $this->assertTrue($mylib_file->exists(),"Il file non e' stato creato!!");

        $mylib3_file = $my_js_lib_subdir->newFile("mylib3.js");
        $mylib3_file->setContent("WORLD!!");
        $this->assertTrue($mylib3_file->exists(),"Il file non e' stato creato!!");

        $plug->remove("js/");
        $this->assertFalse($mylib_file->exists(),"Il file mylib.js non e' stato rimosso!!");
        $this->assertTrue($mylib3_file->exists(),"Il file mylib3.js e' stato rimosso!!");

        $all_module_plug_files = $module_plug_test_root->listFiles();
        foreach ($all_module_plug_files as $ff)
            $ff->delete(true);
    }

    function testMkdir()
    {
        $dir = new Dir("/".FRAMEWORK_CORE_PATH."tests/base/module_plug_root/prova/");

        $module_plug_test_root = new Dir("/".FRAMEWORK_CORE_PATH."tests/base/module_plug_root/");
        $target_dir = new Dir("/".FRAMEWORK_CORE_PATH."tests/base/module_plug_root/");

        $plug = new DirBridge($target_dir,new Dir("/".FRAMEWORK_CORE_PATH."tests/base/fakeroot/modules/ecommerce/cart/"));

        $this->assertFalse($dir->exists(),"La directory da creare esiste gia'!!");

        $plug->mkdir("prova");
        $this->assertTrue($dir->exists(),"La directory non è stata creata!!");
        $dir->delete();
    }


    function testRmdir()
    {
        $dir = new Dir("/".FRAMEWORK_CORE_PATH."tests/base/module_plug_root/prova/");

        $module_plug_test_root = new Dir("/".FRAMEWORK_CORE_PATH."tests/base/module_plug_root/");
        $target_dir = new Dir("/".FRAMEWORK_CORE_PATH."tests/base/module_plug_root/");

        $plug = new DirBridge($target_dir,new Dir("/".FRAMEWORK_CORE_PATH."tests/base/fakeroot/modules/ecommerce/cart/"));

        $this->assertFalse($dir->exists(),"La directory c'e' gia'!!");
        $dir->touch();
        $this->assertTrue($dir->exists(),"La directory non e' stata creata!!");

        $plug->rmdir("prova");

        $this->assertFalse($dir->exists(),"La directory non e' stata eliminata!!");
    }

}

?>