<?php
/*
 * NOTA DI COPYRIGHT
Questo framework è esclusiva proprietà di Frostlab gate. Ne è vietato l'utilizzo, la copia, la modifica o la redistribuzione 
sotto qualsiasi forma senza l'esplicito consenso da parte di Frostlab gate. Tutti i diritti riservati.
 *
 * COPYRIGHT NOTICE
This framework is exclusive property of Frostlab gate. Usage, copy, changes or redistribution in any form are forbidden
without an explicit agreement with Frostlab gate. All rights reserved.
 */

class TestPropertiesUtils extends UnitTestCase
{
    function testReadPlainFromFile()
    {
        //si presume che vada ma non si sa mai ...
        
        $props_file = new File("/".FRAMEWORK_CORE_PATH."tests/io/properties_dir/props_plain.ini");
        
        $props = PropertiesUtils::readFromFile($props_file, false);
        
        $this->assertEqual($props["prop_01"],"ciao");
        $this->assertEqual($props["prop_02"],"mondo");
    }
    
    function testReadSectionsFromFile()
    {
        //si presume che vada ma non si sa mai ...
        
        $props_file = new File("/".FRAMEWORK_CORE_PATH."tests/io/properties_dir/props_sections.ini");
        
        $props = PropertiesUtils::readFromFile($props_file, true);
        
        $this->assertEqual(count($props),2,"Il numero delle sezioni non corrisponde!! : ".count($props));
        
        $this->assertEqual($props["ciao"]["chiave"],"mondo");
        $this->assertEqual($props["hello"]["chiave"],"spank");

    }
    
    function testReadNumberedSectionsFromFile()
    {
        //si presume che vada ma non si sa mai ...
        
        $props_file = new File("/".FRAMEWORK_CORE_PATH."tests/io/properties_dir/props_sections_numbered.ini");
        
        $props = PropertiesUtils::readFromFile($props_file, true);
       
        $this->assertEqual(count($props),3,"Il numero delle sezioni non corrisponde!! : ".count($props));
        
        $this->assertEqual($props[1]["menu_title"],"Home");
        $this->assertEqual($props[2]["menu_link"],"http://www.mbcraft.it/credits.php");
        $this->assertEqual($props[3]["menu_title"],"Dove siamo");
        $this->assertEqual($props[3]["menu_description"],"Raggiungerci è molto semplice, prendete l'autobus AX8!!");

        //E' necessario usare l'escape per le stringhe!!!
        //ok viene già fatto.
    }
    
    
    function testSaveToFileWithSections()
    {
        $values = array("ciao" => array("prova" => "ok",3 => "world"),2 => array("ancora" => "funziona","strano" => "Questa frase è strana, contiene gli ' e le ()!=£$%&/ !!!"));
    
        $store = new File("/".FRAMEWORK_CORE_PATH."tests/io/properties_dir/storage/save_sections_test.ini"); 
        
        PropertiesUtils::saveToFile($store, $values, true);
        
        $read_props = PropertiesUtils::readFromFile($store, true);
        
        $this->assertEqual($read_props[2]["ancora"],"funziona");
        $this->assertEqual($read_props[2]["strano"],"Questa frase è strana, contiene gli ' e le ()!=£$%&/ !!!");
        
        $this->assertEqual($read_props["ciao"]["prova"],"ok");
        $this->assertEqual($read_props["ciao"][3],"world"); 
    }
    
        function testSaveToFilePlain()
        {
            $values = array(3 => 12,"ciao" => "prova" , "ok" => 3 , "world" => 2 , "ancora" => "funziona","strano" => "Questa frase è strana, contiene gli ' e le ()!=£$%&/ !!!");

            $store = new File("/".FRAMEWORK_CORE_PATH."tests/io/properties_dir/storage/save_sections_plain.ini"); 

            PropertiesUtils::saveToFile($store, $values, false);

            $read_props = PropertiesUtils::readFromFile($store, false);

            $this->assertEqual($read_props[3],12);
            $this->assertEqual($read_props["ciao"],"prova");
            $this->assertEqual($read_props["ok"],3);
            $this->assertEqual($read_props["world"],2);
            $this->assertEqual($read_props["ancora"],"funziona");
            $this->assertEqual($read_props["strano"],"Questa frase è strana, contiene gli ' e le ()!=£$%&/ !!!");

        }
        
        function testAddEntry()
        {
            $file = new File("/".FRAMEWORK_CORE_PATH."tests/io/properties_dir/test_folder_2/add_props.ini");
            if ($file->exists()) $file->delete();
            
            PropertiesUtils::addEntry($file, true, "prova", array("ciao" => 1,"mondo" => 2, 3 => "pluto"));
            
            $this->assertTrue($file->exists(),"Il file delle properties non è stato creato!!");
            $props = PropertiesUtils::readFromFile($file, true);
            
            $this->assertTrue(count($props)==1,"Il numero delle properties non corrisponde!");
            $entry = $props["prova"];
            $this->assertTrue(count($entry)==3,"Il numero delle voci non corrisponde!");
            $this->assertEqual($entry["ciao"],1);
            $this->assertEqual($entry["mondo"],2);
            $this->assertEqual($entry[3],"pluto");
            
            $file->delete();
            
        }
        
        function testRemoveEntry()
        {
            $file = new File("/".FRAMEWORK_CORE_PATH."tests/io/properties_dir/test_folder_2/remove_props.ini");
            
            $properties = array("entry1" => array("one" => 1,"two" => 2, "mondo" => "mah"), "entry2" => array("one" => 7,"two" => 16, "mondo" => "blah"), 3 => array("pizza" => 5,"problems"  => 0));
            
            PropertiesUtils::saveToFile($file, $properties, true);
            PropertiesUtils::removeEntry($file, true, "entry2");
            
            $removed = PropertiesUtils::readFromFile($file, true);
            
            $this->assertTrue(count($removed)==2,"Il numero delle proprietà non corrisponde!!");
            $this->assertTrue(isset($removed["entry1"]),"entry1 è stata cancellata!!");
            $this->assertFalse(isset($removed["entry2"]),"entry2 non è stata cancellata!!");
            $this->assertTrue(isset($removed[3]),"'3' è stata cancellata!!");
            
            $this->assertEqual($removed["entry1"]["one"],1,"Il valore della properties non corrisponde!");
            $this->assertEqual($removed["entry1"]["two"],2,"Il valore della properties non corrisponde!");
            $this->assertEqual($removed["entry1"]["mondo"],"mah","Il valore della properties non corrisponde!");
            
            $this->assertTrue(count($removed["entry1"])==3,"Il numero delle chiavi non corrisponde!");
            
            $this->assertEqual($removed[3]["pizza"],5,"Il valore della properties non corrisponde!");
            $this->assertEqual($removed[3]["problems"],0,"Il valore della properties non corrisponde!");
            
            $this->assertTrue(count($removed[3])==2,"Il numero delle chiavi non corrisponde!");
            
        }

        function testReadFromString1()
        {
            $myString = <<<END_OF_STRING
[1]
menu_title = Home
menu_link = http://www.mbcraft.it
menu_style = small_font

[2 abu jafar]
menu_title = Credits
menu_link = http://www.mbcraft.it/credits.php

[3]
menu_title = Dove siamo
menu_link = http://www.mbcraft.it/dove_siamo.php
menu_description = "Raggiungerci è molto semplice, prendete l'autobus AX8!!"
END_OF_STRING;
            $props = PropertiesUtils::readFromString($myString,true);

            $this->assertTrue(count($props)==3,"Il numero di sezioni non corrisponde!!");
            $this->assertEqual($props[1]["menu_title"],"Home","La properties non corrisponde!! : ".$props[1]["menu_title"]);
            $this->assertEqual($props["2 abu jafar"]["menu_title"],"Credits","La properties non corrisponde!! : ".$props["2 abu jafar"]["menu_title"]);

            $this->assertEqual($props[3]["menu_link"],"http://www.mbcraft.it/dove_siamo.php","La properties non corrisponde!!");
            $this->assertEqual($props[3]["menu_description"],"Raggiungerci è molto semplice, prendete l'autobus AX8!!","La properties non corrisponde!!");

        }

            function testReadFromString2()
        {
            $myString = <<<END_OF_STRING

proprieta_01 = Home
altra_prop = http://www.mbcraft.it
menu_style = small_font

ancora_props = Ancora proprietà
; Questo è un commento
ultima_props = L'ultima prop

END_OF_STRING;

            $props = PropertiesUtils::readFromString($myString,false);

            $this->assertTrue(count($props)==5,"Il numero di properties non corrisponde!! : ".count($props));
            $this->assertEqual($props["menu_style"],"small_font","La properties non corrisponde!!");
            $this->assertEqual($props["ancora_props"],"Ancora proprietà","La properties non corrisponde!!");
            $this->assertEqual($props["ultima_props"],"L'ultima prop","La properties non corrisponde!! : ".$props["ultima_props"]);

        }
    
}

?>