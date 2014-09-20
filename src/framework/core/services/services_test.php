<?php


class MyService
{
    function myFunction()
    {
        
    }
}

class MyService2
{
    function myFunction2()
    {
        
    }
}


class TestServices extends UnitTestCase
{
    function testRegisterService()
    {
        Services::unregisterAllServices();
        
        Services::registerServiceFactory("test/service", new CachedInstanceServiceFactory(new MyService()));
        
        $this->assertTrue(Services::is_registered("test/service"),"Il servizio non e' stato registrato!!");
        $this->assertTrue(Services::get("test/service") instanceof MyService,"Il servizio non corrisponde alla classe registrata!!");
        
        $all_services = Services::get_all_registered_services();
        
        $this->assertEqual(count($all_services),1,"Il numero dei servizi registrati non corrisponde!!");
        $this->assertEqual($all_services[0],"test/service","Il nome del servizio registrato non corrisponde!!");
        
        Services::registerServiceFactory("test/service2", new NewInstanceServiceFactory("MyService2"));
        $this->assertTrue(Services::is_registered("test/service2"),"Il servizio non e' stato registrato!!");
        $this->assertTrue(Services::get("test/service2") instanceof MyService2,"Il servizio non corrisponde alla classe registrata!!");
        
        $all_services = Services::get_all_registered_services();
        
        $this->assertEqual(count($all_services),2,"Il numero dei servizi registrati non corrisponde!!");
    
        Services::unregisterAllServices();
        
        $all_services = Services::get_all_registered_services();
        
        
        $this->assertEqual(count($all_services),0,"Il numero dei servizi registrati non corrisponde!!");
    
        
        
    }
}

?>