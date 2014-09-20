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
    
    function testControllerNameFromClass()
    {
        $this->assertEqual(ControllerFactory::get_controller_name_from_class("FPDFController"),"fpdf","Il nome del controller non corrisponde! : ".ControllerFactory::get_controller_name_from_class("FPDFController"));
        $this->assertEqual(ControllerFactory::get_controller_name_from_class("FPDFStaticController"),"fpdf_static","Il nome del controller non corrisponde! : ".ControllerFactory::get_controller_name_from_class("FPDFStaticController"));
        $this->assertEqual(ControllerFactory::get_controller_name_from_class("StaticRSSController"),"static_rss","Il nome del controller non corrisponde! : ".ControllerFactory::get_controller_name_from_class("StaticRSSController"));

        $this->assertEqual(ControllerFactory::get_controller_name_from_class("PippoPlutoController"),"pippo_pluto","Il nome del controller non corrisponde! : ".ControllerFactory::get_controller_name_from_class("PippoPlutoController"));
        $this->assertEqual(ControllerFactory::get_controller_name_from_class("Pippo_PlutoController"),"pippo_pluto","Il nome del controller non corrisponde! : ".ControllerFactory::get_controller_name_from_class("Pippo_PlutoController"));
        $this->assertEqual(ControllerFactory::get_controller_name_from_class("__Pippo__PlutoController"),"pippo_pluto","Il nome del controller non corrisponde! : ".ControllerFactory::get_controller_name_from_class("__Pippo__PlutoController"));
    }

    function testIsControllerClass2()
    {
        $this->assertTrue(ControllerFactory::is_controller_class("ErrorController"),"ErrorController non e' un controller!");
        $this->assertTrue(ControllerFactory::is_controller_class("ModuliController"),"ModuliController non e' un controller!");


        $this->assertFalse(ControllerFactory::is_controller_class("FolderPeer"),"FolderPeer e' un controller!!");
        $this->assertFalse(ControllerFactory::is_controller_class("ImmaginiDO"),"ImmaginiDO e' un controller!!");
        $this->assertFalse(ControllerFactory::is_controller_class("EventiPeer"),"EventiPeer e' un controller!!");
        $this->assertFalse(ControllerFactory::is_controller_class("XMLBuilder"),"XMLBuilder e' un controller!!");
        $this->assertFalse(ControllerFactory::is_controller_class("DataHolder"),"DataHolder e' un controller!!");
        $this->assertFalse(ControllerFactory::is_controller_class("ArrayUtils"),"ArrayUtils e' un controller!!");
        $this->assertFalse(ControllerFactory::is_controller_class("ProfileMap"),"ProfileMap e' un controller!!");
        $this->assertFalse(ControllerFactory::is_controller_class("PageLoader"),"PageLoader e' un controller!!");
        $this->assertFalse(ControllerFactory::is_controller_class("ModulePlug"),"ModulePlug e' un controller!!");
        $this->assertFalse(ControllerFactory::is_controller_class("FileWriter"),"FileWriter e' un controller!!");
        $this->assertFalse(ControllerFactory::is_controller_class("FormWriter"),"FormWriter e' un controller!!");
        $this->assertFalse(ControllerFactory::is_controller_class("RouteMatch"),"RouteMatch e' un controller!!");
        $this->assertFalse(ControllerFactory::is_controller_class("EpiTwitter"),"EpiTwitter e' un controller!!");
        $this->assertFalse(ControllerFactory::is_controller_class("Securimage"),"Securimage e' un controller!!");
        $this->assertFalse(ControllerFactory::is_controller_class("AjaxHelper"),"AjaxHelper e' un controller!!");

    }
}

?>