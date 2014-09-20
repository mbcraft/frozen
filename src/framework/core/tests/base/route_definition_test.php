<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */


require_once(FRAMEWORK_CORE_PATH."lib/controller/RouteDefinition.class.php");

class RouteDefinitionTest extends UnitTestCase
{

    public function testEngineRequestUrl()
    {
        $this->assertEqual(Engines::getRequestUri(), "/".FRAMEWORK_CORE_PATH."tests/all_tests.php");
    }
    
    public function testRouteDefinition0()
    {
        $rd = new RouteDefinition("/pippo/***.php", true,"pippo", 1, "php");

        $this->assertTrue($rd->matches("/pippo/pluto.php"), "Match url semplice");
        $this->assertTrue($rd->matches("/pippo/paperino.php"), "Match url semplice 2");
    }

    public function testRouteDefinition1()
    {
        $rd = new RouteDefinition("/pippo/***.php", true,"pippo", "1", "php");

        $this->assertTrue($rd->matches("/pippo/pluto.php"), "Match url semplice");
        $this->assertTrue($rd->matches("/pippo/paperino.php"), "Match url semplice 2");
    }

    public function testRouteDefaults()
    {
        $rd = new RouteDefinition("/", true, "root", "index", "php");

        $this->assertTrue($rd->matches("/"), "Match con barra");
        $this->assertFalse($rd->matches(""), "Match senza barra");

        if ($rd->matches("/"))
        {
            $match = $rd->getMatch("/");

            $this->assertEqual("root", $match->getController(), "Controller di default non corrisponde");
            $this->assertEqual("index", $match->getAction(), "Action di default non corrisponde");
            $this->assertEqual("php", $match->getFormat(), "Formato di default non corrisponde");
        }
    }

    public function testSimpleRouteDef()
    {
        $rd = new RouteDefinition("/prodotti/***/*num*/*word*",true , "prodotti", 1, "php");

        $this->assertTrue($rd->matches("/prodotti/prova.php/15/asc"), "Match con /prodotti/prova.php/15/asc");
        $this->assertTrue($rd->matches("/prodotti/prova_help/50/desc"), "No match con /prodotti/prova_help/50/desc");
        $this->assertTrue($rd->matches("/prodotti/prova/15/ok"), "No match con /prodotti/prova.php/15/ok");
        $this->assertFalse($rd->matches("/prodotti/prova.php/ciccia/asc"), "Match con /prodotti/prova.php/ciccia/asc");

        $match_url = "/prodotti/prova_help/15/bau";
        $this->assertTrue($rd->matches($match_url), "No match con /prodotti/prova_help/15/asc");

        if ($rd->matches($match_url))
        {
            $match = $rd->getMatch($match_url);

            $this->assertEqual($match->getController(), "prodotti", "Il controller non corrisponde");
            $this->assertEqual($match->getAction(), "prova_help", "L'azione non corrisponde");
            $this->assertEqual($match->getFormat(), "php", "Il formato non corrisponde");

        }
    }

    public function testComplexRouteDef()
    {
        $rd = new RouteDefinition("/prodotti/*no_dot*.*no_dot*/*num*/*word*",true, "prodotti", 1, 2);

        $this->assertTrue($rd->matches("/prodotti/prova.php/15/asc"), "No match con /prodotti/prova.php/15/asc : " . $rd->getMatchingPattern());
        $this->assertFalse($rd->matches("/products/prova.json/50/desc"), "No match con /products/prova.json/50/desc");
        $this->assertTrue($rd->matches("/prodotti/prova.json/15/ok"), "Match con /prodotti/prova.json/15/ok");
        $this->assertFalse($rd->matches("/prodotti/prova.php/ciccia/asc"), "Match con /prodotti/prova.php/ciccia/asc");

        $url = "/prodotti/prova.php/15/asc";
        $this->assertTrue($rd->matches($url), "No match con /prodotti/prova.xml/15/asc");

        if ($rd->matches($url))
        {
            $match = $rd->getMatch("/prodotti/prova.php/15/asc");

            $this->assertEqual($match->getController(), "prodotti", "Il controller non corrisponde");
            $this->assertEqual($match->getAction(), "prova", "L'azione non corrisponde");
            $this->assertEqual($match->getFormat(), "php", "Il formato non corrisponde");

        }
    }

    public function testPartialMatch()
    {
        $rd = new RouteDefinition("/admin/***.****opt_slash*", true, "admin", 1, 2);

        $this->assertFalse($rd->matches("/admin"), "No match con /admin");
        $this->assertFalse($rd->matches("/admin/"), "No match con /admin/");
        $this->assertTrue($rd->matches("/admin/index.php"), "No match con /admin/index.php");
        $this->assertTrue($rd->matches("/admin/index.php/"), "No match con /admin/index.php/");
    }

    public function testDotRouteDef()
    {
        $rd = new RouteDefinition("/prodotti/*no_dot*.*no_dot*",true, "prodotti", 1, 2);

        $this->assertTrue($rd->matches("/prodotti/prova.html"), "La url non fa match");
        $this->assertFalse($rd->matches("/prodotti/prova.html/"), "La url con lo slash finale non fa match");

        if ($rd->matches("/prodotti/prova.html"))
        {

            $match = $rd->getMatch("/prodotti/prova.html");

            $this->assertEqual($match->getController(), "prodotti", "Il controller non corrisponde");
            $this->assertEqual($match->getAction(), "prova", "La action non corrisponde");
            $this->assertEqual($match->getFormat(), "html", "Il formato non corrisponde");
        }
    }

    /*
      public function testDotRouteDefOk()
      {
      $rd = new __RouteDefinition("/%CONTROLLER=prodotti|products.%ACTION.%VIEW/");

      $this->assertFalse($rd->matches_url("/prodotti.prova.html"));
      $this->assertFalse($rd->matches_url("/prodotti.prova.html/"));
      $this->assertFalse($rd->matches_url("/products.ok.js"));
      }
     */
}

