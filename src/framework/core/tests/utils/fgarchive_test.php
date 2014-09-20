<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

class TestFGArchive extends UnitTestCase
{
    function testCompress()
    {

        $d = new Dir("/".FRAMEWORK_CORE_PATH."tests/utils/compress/");
        $d->touch();

        $f = new File("/".FRAMEWORK_CORE_PATH."tests/utils/compress/test.fga");
        $f->delete();

        $this->assertFalse($f->exists());

        FGArchive::compress($f,new Dir("/".FRAMEWORK_CORE_PATH."tests/utils/compress/data/"));

        $this->assertTrue($f->exists());

        $f->delete();

    }

    function testCompressUncompress()
    {
        $f = new File("/".FRAMEWORK_CORE_PATH."tests/utils/compress/test.fga");
        $f->delete();

        FGArchive::compress($f,new Dir("/".FRAMEWORK_CORE_PATH."tests/utils/compress/data/"));

        $ext_dir = new Dir("/".FRAMEWORK_CORE_PATH."tests/utils/extract/");
        $ext_dir->touch();

        $f = new File("/".FRAMEWORK_CORE_PATH."tests/utils/compress/test.fga");
        $this->assertTrue($f->exists(),"Il file da decomprimere non esiste!!");

        FGArchive::extract($f,$ext_dir);

        $f1 = new File("/".FRAMEWORK_CORE_PATH."tests/utils/extract/cartella.png");
        $this->assertTrue($f1->exists(),"Il file cartella.png non e' stato estratto!!");
        $this->assertEqual($f1->getSize(),441,"La dimensione di cartella.png non corrisponde!!");

        $f2 = new File("/".FRAMEWORK_CORE_PATH."tests/utils/extract/file1.txt");
        $this->assertTrue($f2->exists(),"Il file file1.txt non e' stato estratto!!");

        $f3 = new File("/".FRAMEWORK_CORE_PATH."tests/utils/extract/file2.dat");
        $this->assertTrue($f3->exists(),"Il file file2.dat non e' stato estratto!!");

        $d1 = new Dir("/".FRAMEWORK_CORE_PATH."tests/utils/extract/empty_folder");
        $this->assertTrue($d1->exists(),"La cartella vuota non e' stata estratta!!");

        $d2 = new Dir("/".FRAMEWORK_CORE_PATH."tests/utils/extract/folder");
        $this->assertTrue($d2->exists(),"La cartella folder non e' stata estratta!!");

        $f4 = new File("/".FRAMEWORK_CORE_PATH."tests/utils/extract/folder/sub/yep.txt");
        $this->assertTrue($f4->exists(),"Il file yep.txt non e' stato estratto!!");
        $this->assertEqual($f4->getSize(),10,"La dimensione di yep.txt non corrisponde!!");

        $this->assertTrue($ext_dir->delete(true),"La directory coi file estratti non e' stata elimintata!!");

        $this->assertFalse($f1->exists(),"Il file cartella.png esiste ancora!!");

    }

    function testArchiveVersion()
    {
        $f = new File("/".FRAMEWORK_CORE_PATH."tests/utils/compress/test.fga");
        $f->delete();

        $this->assertFalse($f->exists());

        FGArchive::compress($f,new Dir("/".FRAMEWORK_CORE_PATH."tests/utils/compress/data/"));

        $this->assertTrue($f->exists());

        $version = FGArchive::getArchiveVersion($f);

        $this->assertEqual(FGArchive::CURRENT_MAJOR,$version["major"],"La major version non corrisponde!!");
        $this->assertEqual(FGArchive::CURRENT_MINOR,$version["minor"],"La minor version non corrisponde!!");
        $this->assertEqual(FGArchive::CURRENT_REV,$version["rev"],"La revision non corrisponde!!");

        $f->delete();

    }

    function testArchiveProperties()
    {
        $f = new File("/".FRAMEWORK_CORE_PATH."tests/utils/compress/test.fga");
        $f->delete();

        $this->assertFalse($f->exists());

        $input_properties["description"] = "Archivio immagini rotator";
        $input_properties["image1"] = "colori.jpg";
        $input_properties["image2"] = "other";

        FGArchive::compress($f,new Dir("/".FRAMEWORK_CORE_PATH."tests/utils/compress/data/"),$input_properties);

        $this->assertTrue($f->exists());

        $output_properties = FGArchive::getArchiveProperties($f);

        $this->assertEqual($output_properties["description"],"Archivio immagini rotator","La descrizione non e' stata letta correttamente dall'archivio!!");
        $this->assertEqual($output_properties["image1"],"colori.jpg","La proprieta' image1 non e' stata letta correttamente dall'archivio!!");
        $this->assertEqual($output_properties["image2"],"other","La proprieta' image2 non e' stata letta correttamente dall'archivio!!");

        $f->delete(true);
    }

}

?>