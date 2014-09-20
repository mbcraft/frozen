<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

class TestStringUtils extends UnitTestCase
{
    function testRemoveInitialWww()
    {
        $current_host = "www.eShopManager.it";
        $no_www = substr($current_host,4);

        $this->assertTrue(strpos($current_host,"www.")===0,"La posizione del www non e' stata rilevata correttamente!!");
        $this->assertEqual("eShopManager.it",$no_www,"La rimozione della stringa iniziale www non e' andata a buon fine!!");
    }

    function testUnderscoreToCamelCase()
    {
        $this->assertEqual(StringUtils::underscored_to_camel_case("contenuti_testuali"),"ContenutiTestuali","Il ritorno a camelcase non funziona correttamente!! : ".StringUtils::underscored_to_camel_case("contenuti_testuali"));
        $this->assertEqual(StringUtils::underscored_to_camel_case("gallery"),"Gallery","Il ritorno a camelcase non funziona correttamente!! : ".StringUtils::underscored_to_camel_case("gallery"));
        $this->assertEqual(StringUtils::underscored_to_camel_case("camel_case_test"),"CamelCaseTest","Il ritorno a camelcase non funziona correttamente!! : ".StringUtils::underscored_to_camel_case("camel_case_test"));

    }

    function testPregReplace()
    {
        $test_string = "This is a/test_string";
        $result = preg_replace("/[\/ ]/","_",$test_string);

        $this->assertEqual($result,"This_is_a_test_string","Il replace non e' stato effettuato correttamente!!");
    }

    function testCamelCaseSplit()
    {
        $this->assertEqual(StringUtils::camel_case_split("FPDF"),"fpdf","Lo split delle stringhe in camelcase non funziona correttamente!! : ".StringUtils::camel_case_split("FPDF"));
        $this->assertEqual(StringUtils::camel_case_split("ContenutiTestualiController"),"contenuti_testuali_controller","Lo split delle stringhe in camelcase non funziona correttamente!! : ".StringUtils::camel_case_split("ContenutiTestualiController"));
        $this->assertEqual(StringUtils::camel_case_split("ContenutiTestualiDO"),"contenuti_testuali_do","Lo split delle stringhe in camelcase non funziona correttamente!! : ".StringUtils::camel_case_split("ContenutiTestualiDO"));


        $this->assertEqual(StringUtils::camel_case_split("FPDF",true),"","Lo split delle stringhe in camelcase non funziona correttamente!! : ".StringUtils::camel_case_split("FPDF"));
        $this->assertEqual(StringUtils::camel_case_split("ContenutiTestualiController",true),"contenuti_testuali","Lo split delle stringhe in camelcase non funziona correttamente!! : ".StringUtils::camel_case_split("ContenutiTestualiController"));
        $this->assertEqual(StringUtils::camel_case_split("ContenutiTestualiDO",true),"contenuti_testuali","Lo split delle stringhe in camelcase non funziona correttamente!! : ".StringUtils::camel_case_split("ContenutiTestualiDO"));

        $this->assertEqual(StringUtils::camel_case_split("FPDF",true,"^^"),"","Lo split delle stringhe in camelcase non funziona correttamente!! : ".StringUtils::camel_case_split("FPDF"));
        $this->assertEqual(StringUtils::camel_case_split("ContenutiTestualiController",true,"^^"),"contenuti^^testuali","Lo split delle stringhe in camelcase non funziona correttamente!! : ".StringUtils::camel_case_split("ContenutiTestualiController"));
        $this->assertEqual(StringUtils::camel_case_split("ContenutiTestualiDO",true,"*"),"contenuti*testuali","Lo split delle stringhe in camelcase non funziona correttamente!! : ".StringUtils::camel_case_split("ContenutiTestualiDO"));

        $this->assertEqual(StringUtils::camel_case_split("FPDFController"),"fpdf_controller","Lo split delle stringhe in camelcase non funziona correttamente!! : ".StringUtils::camel_case_split("FPDFController"));
        $this->assertEqual(StringUtils::camel_case_split("FPDFController",true),"fpdf","Lo split delle stringhe in camelcase non funziona correttamente!! : ".StringUtils::camel_case_split("FPDFController",true));

        $this->assertEqual(StringUtils::camel_case_split("XSportBlastController"),"xsport_blast_controller","Lo split delle stringhe in camelcase non funziona correttamente!! : ".StringUtils::camel_case_split("XSportBlastController"));
        $this->assertEqual(StringUtils::camel_case_split("XSportBlastController",true),"xsport_blast","Lo split delle stringhe in camelcase non funziona correttamente!! : ".StringUtils::camel_case_split("XSportBlastController",true));

    }

    function testEndsWith()
    {
        $this->assertTrue(StringUtils::ends_with("ProvaDiRegistrazione","Registrazione"),"Il controllo di fine stringa non e' corretto!!");
        $this->assertFalse(StringUtils::ends_with("ProvaDiRegistrazione","zionerr"),"Il controllo di fine stringa non e' corretto!!");
        $this->assertFalse(StringUtils::ends_with("ProvaDiRegistrazione","Prova"),"Il controllo di fine stringa non e' corretto!!");
    }

    function testTrimEndingChars()
    {
        $this->assertEqual(StringUtils::trim_ending_chars("ProvaDiABC",3),"ProvaDi","Il trim degli ultimi caratteri non e' corretto!!");
        $this->assertEqual(StringUtils::trim_ending_chars("ProvaDiABC",5),"Prova","Il trim degli ultimi caratteri non e' corretto!!");
        $this->assertEqual(StringUtils::trim_ending_chars("ProvaDiABC",10),"","Il trim degli ultimi caratteri non e' corretto!!");
        try
        {
            StringUtils::trim_ending_chars("Ciao",5);
            $this->fail("Numero di caratteri piu' lungo della stringa.");
        }
        catch(Exception $ex)
        {
            //ok
        }
    }
}

