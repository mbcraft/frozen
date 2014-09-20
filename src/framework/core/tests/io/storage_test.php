<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */


class TestStorage extends UnitTestCase {


    function testStorageWorkingWithSlashInFolderName() 
    {
        Storage::set_storage_root(DS . FRAMEWORK_CORE_PATH . "tests/io/storage_dir/");

        $p1 = Storage::getPropertiesStorage("pippo/pluto", "ciao");
        
        $p1->add("prova",array("a","b","c"));
        $p1->remove("prova");
        
        $p1->add("prova2",array("ciccia"));
        $props = $p1->readAll();
        
        $this->assertEqual($props["prova2"][0],"ciccia","La proprieta' non e' stata salvata con successo!!");
        
        $p2 = Storage::getPropertiesStorage("/pluto", "ciaoasd");
        $p3 = Storage::getPropertiesStorage("pippo/", "ciaoqwe");

        Storage::set_storage_root(Storage::get_default_storage_root());
    }
    

    function testStorageRootExists() {
        Storage::set_storage_root(DS . FRAMEWORK_CORE_PATH . "tests/io/permanent_storage/");

        $this->assertTrue(Storage::storage_root_exists(), "La storage root non esiste!!");

        Storage::set_storage_root(Storage::get_default_storage_root());
    }

    function testGetStorageFolder() {
        Storage::set_storage_root(DS . FRAMEWORK_CORE_PATH . "tests/io/permanent_storage/");

        $storage = Storage::getPropertiesStorage("my_folder", "storage_01");
        $this->assertTrue($storage->exists(), "Lo storage non esiste!!");
        $this->assertEqual("my_folder", $storage->getFolder());

        Storage::set_storage_root(Storage::get_default_storage_root());
    }

    function testGetStorageName() {
        Storage::set_storage_root(DS . FRAMEWORK_CORE_PATH . "tests/io/permanent_storage/");

        $storage = Storage::getPropertiesStorage("my_folder", "storage_02");
        $this->assertTrue($storage->exists(), "Lo storage non esiste!!");
        $this->assertEqual("storage_02", $storage->getName());

        Storage::set_storage_root(Storage::get_default_storage_root());
    }

    function testGetStorageGetAll() {
        Storage::set_storage_root(DS . FRAMEWORK_CORE_PATH . "tests/io/permanent_storage/");

        $storages = Storage::getAll("my_folder");
        $this->assertEqual(count($storages), 2, "Il numero degli storage non corrisponde!");

        Storage::set_storage_root(Storage::get_default_storage_root());
    }

    function testStorageDirMustExists() {
        Storage::set_storage_root(DS . FRAMEWORK_CORE_PATH . "tests/io/bad_storage/");

        try {
            Storage::getPropertiesStorage("boh", "ciccia");
            $this->fail("La directory base dello storage deve essere presente!!");
        } catch (Exception $ex) {
            //tutto ok
        }
    }

    function testStorageCreateIfNotPresent() {
        Storage::set_storage_root(DS . FRAMEWORK_CORE_PATH . "tests/io/storage_dir/");

        $d = new Dir(DS . FRAMEWORK_CORE_PATH . "tests/io/storage_dir/");
        foreach ($d->listFiles() as $f)
            $f->delete(true);

        $this->assertFalse($d->hasSingleSubdir(), "Lo storage e' gia' presente!!");

        $storage = Storage::getPropertiesStorage("boh", "ciccia");

        $this->assertTrue($d->hasSingleSubdir(), "Lo storage non e' stato creato!!");

        $this->assertFalse($storage->exists());
        foreach ($d->listFiles() as $f)
            $f->delete(true);

        Storage::set_storage_root(Storage::get_default_storage_root());
    }
    

    function testCreateStorageFileOnSave() {
        Storage::set_storage_root(DS . FRAMEWORK_CORE_PATH . "tests/io/storage_dir/");

        $d = new Dir(DS . FRAMEWORK_CORE_PATH . "tests/io/storage_dir/");
        foreach ($d->listFiles() as $f)
            $f->delete(true);

        $this->assertFalse($d->hasSingleSubdir(), "Lo storage e' gia' presente!!");

        $storage = Storage::getPropertiesStorage("boh", "ciccia");

        $this->assertFalse($storage->exists(), "Lo storage esiste gia'!!");

        $storage->create();

        $this->assertTrue($storage->exists(), "Lo storage non e' stato creato!!");

        $storage->delete();

        $this->assertFalse($storage->exists(), "Lo storage non e' stato eliminato!!");


        $this->assertFalse($storage->exists());
        foreach ($d->listFiles() as $f)
            $f->delete(true);

        Storage::set_storage_root(Storage::get_default_storage_root());
    }

    function testCreateStorageOnWrite() {
        Storage::set_storage_root(DS . FRAMEWORK_CORE_PATH . "tests/io/storage_dir/");

        $d = new Dir(DS . FRAMEWORK_CORE_PATH . "tests/io/storage_dir/");
        foreach ($d->listFiles() as $f)
            $f->delete(true);

        $this->assertFalse($d->hasSingleSubdir(), "Lo storage e' gia' presente!!");

        $storage = Storage::getPropertiesStorage("boh", "ciccia");

        $this->assertFalse($storage->exists(), "Lo storage esiste gia'!!");

        $test_props = array("test" => "value", "hello" => "world");

        $storage->add("category", $test_props);

        $this->assertTrue($storage->exists(), "Lo storage non e' stato creato!!");

        $storage->delete();

        $this->assertFalse($storage->exists(), "Lo storage non e' stato eliminato!!");

        $properties = $storage->readAll(); //readAll
        $this->assertTrue($storage->exists(), "Lo storage non e' stato creato per una lettura!!");
        $this->assertFalse($properties === null, "Il risultato ritornato e' ===null !!");
        $this->assertTrue(is_array($properties), "Il metodo non ha ritornato un array con uno storage inesistente!!");
        $this->assertTrue(count($properties) == 0, "L'array ritornato da una lettura di storage vuoto non e' vuoto!!");

        $storage->delete();

        $storage->remove("blah");   //remove
        $this->assertTrue($storage->exists(), "Lo storage non e' stato creato per una cancellazione!!");

        $storage->delete();

        $storage->saveAll(array()); //saveAll
        $this->assertTrue($storage->exists(), "Lo storage non e' stato creato per una cancellazione!!");

        $storage->delete();

        $this->assertFalse($storage->exists(), "Lo storage non e' stato eliminato!!");
        foreach ($d->listFiles() as $f)
            $f->delete(true);

        Storage::set_storage_root(Storage::get_default_storage_root());
    }
    
}

?>