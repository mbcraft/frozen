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

require_once(FRAMEWORK_CORE_PATH."lib/controller/ControllerFactory.class.php");

class TestControllerFactory extends UnitTestCase
{
    function testIsControllerClass()
    {
        $this->assertTrue(ControllerFactory::is_controller_class("pippo_pluto_Controller"), "Il nome della classe del controller non e' valido!");
        $this->assertTrue(ControllerFactory::is_controller_class("UnaProvaController"), "Il nome della classe del controller non e' valido!");
        $this->assertFalse(ControllerFactory::is_controller_class("SecondoGiro"), "Il nome della classe del controller e' valido!");
    }

    /*
    function testControllerNameFromPath()
    {
        $this->assertEqual(ControllerFactory::get_controller_name_from_path("pippopluto_"),"pippopluto","Il nome del controller non corrisponde! : ");
        $this->assertEqual(ControllerFactory::get_controller_name_from_path("pippo_pluto"),"pippo_pluto","Il nome del controller non corrisponde! : ");
        $this->assertEqual(ControllerFactory::get_controller_name_from_path("pippo-pluto"),"pippopluto","Il nome del controller non corrisponde! : ");
        $this->assertEqual(ControllerFactory::get_controller_name_from_path("__pippo__pluto"),"pippo_pluto","Il nome del controller non corrisponde! : ");
    }
    */

    function testControllerNameFromClass()
    {
        $this->assertEqual(ControllerFactory::get_controller_name_from_class("FPDFController"),"fpdf","Il nome del controller non corrisponde! : ".ControllerFactory::get_controller_name_from_class("FPDFController"));
        $this->assertEqual(ControllerFactory::get_controller_name_from_class("FPDFStaticController"),"fpdf_static","Il nome del controller non corrisponde! : ".ControllerFactory::get_controller_name_from_class("FPDFStaticController"));
        $this->assertEqual(ControllerFactory::get_controller_name_from_class("StaticRSSController"),"static_rss","Il nome del controller non corrisponde! : ".ControllerFactory::get_controller_name_from_class("StaticRSSController"));

        $this->assertEqual(ControllerFactory::get_controller_name_from_class("PippoPlutoController"),"pippo_pluto","Il nome del controller non corrisponde! : ".ControllerFactory::get_controller_name_from_class("PippoPlutoController"));
        $this->assertEqual(ControllerFactory::get_controller_name_from_class("Pippo_PlutoController"),"pippo_pluto","Il nome del controller non corrisponde! : ".ControllerFactory::get_controller_name_from_class("pippo_plutoController"));
        $this->assertEqual(ControllerFactory::get_controller_name_from_class("__Pippo__PlutoController"),"__pippo_pluto","Il nome del controller non corrisponde! : ".ControllerFactory::get_controller_name_from_class("__pippo__plutoController"));
    }
}

