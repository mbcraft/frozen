<?php

class TestRequest extends UnitTestCase
{
    function testRequestPart()
    {
        $request = "/indice/pagina.php?param1=cicicia";
        
        $request_part = Request::getRequestPart($request);
        
        $this->assertEqual($request_part,"/indice/pagina.php","La parte della request non  corrisponde!!");
    }

    function testGetRequestPath()
    {
        $this->assertEqual(Request::getRequestPath("/prova/"),"/prova/","Il path non corrisponde a /prova/ !! : ".Request::getRequestPath("/prova/"));
        $this->assertEqual(Request::getRequestPath("/"),"/","Il path non corrisponde a / !! : ".Request::getRequestPath("/"));

        $this->assertEqual(Request::getRequestPath("/prova/ugh/ciao.php"),"/prova/ugh/","Il path non corrisponde a /prova/ugh/ !! : ".Request::getRequestPath("/prova/ugh/ciao.php"));
    }

    function testGetRequestName()
    {
        $this->assertEqual(Request::getRequestName("/prova/"),"index","Il nome della richiesta non e' 'index' !!".Request::getRequestName("/prova/"));
        $this->assertEqual(Request::getRequestName("/"),"index","Il nome della richiesta non e' 'index' !!".Request::getRequestName("/"));

        $this->assertEqual(Request::getRequestName("/prova/ugh/ciao.xml"),"ciao","Il nome della richiesta non e' 'ciao' !! : ".Request::getRequestName("/prova/ugh/ciao.xml"));
    }

    function testGetRequestFormat()
    {
        $this->assertEqual(Request::getRequestFormat("/prova/"),"php","Il formato della richiesta non e' 'php' !!");
        $this->assertEqual(Request::getRequestFormat("/"),"php","Il formato della richiesta non e' 'php' !!");

        $this->assertEqual(Request::getRequestFormat("/prova/ugh/ciao.xml"),"xml","Il formato della richiesta non e' 'xml' !!");
    }
    
    function testPagePath()
    {
        $request_part = Request::getRequestPart("/guest/prova.php");
        
        $dot_pos = strpos($request_part,".");
        
        $page_path = substr($request_part,1,$dot_pos-1);
        
        $this->assertEqual("guest/prova",$page_path,"Il path della pagina non corrisponde!!");
    }
    
    function testRequestPartNoParams()
    {
        $request = "/indice/pagina.php";
        
        $request_part = Request::getRequestPart($request);
        
        $this->assertEqual($request_part,"/indice/pagina.php","La parte della request non corrisponde!!");
        
        $parameters_part = Request::getParametersPart($request);
        
        $this->assertNull($parameters_part,"La parte dei parametri non  e' nulla!!");
    }
    
    function testRequestPartNoPage()
    {
        $request = "/indice/";
        
        $request_part = Request::getRequestPart($request);
        
        $this->assertEqual($request_part,"/indice/index.php","La parte della request non corrisponde!!");
        
        $parameters_part = Request::getParametersPart($request);
        
        $this->assertNull($parameters_part,"La parte dei parametri non  e' nulla!!");
    }
    
    function testRequestPartOnlySlash()
    {
        $request = "/";
        
        $request_part = Request::getRequestPart($request);
        
        $this->assertEqual($request_part,"/index.php","La parte della request non corrisponde!!");
        
        $parameters_part = Request::getParametersPart($request);
        
        $this->assertNull($parameters_part,"La parte dei parametri non  e' nulla!!");
    }
    
    function testRequestNothing()
    {
        $request = "";
        
        $request_part = Request::getRequestPart($request);
        
        $this->assertEqual($request_part,"/index.php","La parte della request non corrisponde!!");
        
        $parameters_part = Request::getParametersPart($request);
        
        $this->assertNull($parameters_part,"La parte dei parametri non  e' nulla!!");
    }
    
    function testParametersPart()
    {
        $request = "/indice/pagina.php?param1=cicicia";
        
        $parameters_part = Request::getParametersPart($request);
        
        $this->assertEqual($parameters_part,"param1=cicicia","La parte dei parametri non corrisponde!!");
    }
    
    function testParametersPartNoQuestionMark()
    {
        $request = "/indice/pagina.php";
        
        $parameters_part = Request::getParametersPart($request);
        
        $this->assertNull($parameters_part,"La parte dei parametri non e' null!!");
    }
    
    function testParametersPartNoParams()
    {
        $request = "/indice/pagina.php?";
        
        $parameters_part = Request::getParametersPart($request);
        
        $this->assertEqual($parameters_part,"","La parte dei parametri non corrisponde!!");
    }
    
    function testParametersPartNoPageWithParams()
    {
        $request = "/indice/?param=blu";
        
        $parameters_part = Request::getParametersPart($request);
        
        $this->assertEqual($parameters_part,"param=blu","La parte dei parametri non corrisponde!!");
    }

    function testGetRemoteIp()
    {
        $ip = Request::getRemoteIp();
        $ip_nums = explode(".",$ip);

        $this->assertTrue(count($ip_nums),4,"Il numero di parti di cui e' composto l'ip non corrisponde!!");
        foreach ($ip_nums as $num)
        {
            $this->assertTrue($num>=0 && $num<256,"Il numero non e' valido.");
        }

    }

    function testGetAcceptedLanguages()
    {
        $accepted_languages = Request::getAcceptedLanguages();
        $last_perc = 1;
        foreach ($accepted_languages as $lang => $perc)
        {
            $this->assertTrue($last_perc>=$perc,"Le percentuali dei linguaggi accettati non sono ordinate in ordine decrescente!!");
            $last_perc = $perc;
            $this->assertTrue($perc<=1 && $perc>0,"La percentuale di accettazione del linguaggio non e' valida!!");
        }
    }

    function testGetAcceptedMimeTypes()
    {
        $accepted_mime_types = Request::getAcceptedMimeTypes();
        $last_perc = 1;
        foreach ($accepted_mime_types as $mime => $perc)
        {
            $this->assertTrue($last_perc>=$perc,"Le percentuali dei linguaggi accettati non sono ordinate in ordine decrescente!!");
            $last_perc = $perc;
            $this->assertTrue($perc<=1 && $perc>0,"La percentuale di accettazione del linguaggio non e' valida!!");
        }
    }

    function testGetAcceptedEncodings()
    {
        $accepted_encodings = Request::getAcceptedEncodings();
        $this->assertTrue(is_array($accepted_encodings),"Gli encoding supportati non sono un array!!");
    }

}

?>