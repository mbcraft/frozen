<?php


class TestTree extends UnitTestCase
{
    function testPathTokensFunctions1()
    {
        $path = "/html/head/keywords";
        
        $path_tokens = Tree::path_tokens($path);

        $this->assertEqual(count($path_tokens),3,"Il numero dei path token non corrisponde!!");
        $this->assertEqual($path_tokens[0],"html");
        $this->assertEqual($path_tokens[1],"head");
        $this->assertEqual($path_tokens[2],"keywords");
        
        $last_token = Tree::last_path_token($path);
        $this->assertEqual($last_token,"keywords");
        
        $all_but_last = Tree::all_but_last_path_tokens($path);

        $this->assertEqual(count($all_but_last),2,"Il numero dei path token non corrisponde!!");
        $this->assertEqual($all_but_last[0],"html");
        $this->assertEqual($all_but_last[1],"head");
        
    }
    
    function testPathTokensFunctions2()
    {
        $path = "/html";
        
       
        $path_tokens = Tree::path_tokens($path);

        $this->assertEqual(count($path_tokens),1,"Il numero dei path token non corrisponde!!");
        $this->assertEqual($path_tokens[0],"html");
        
        $last_token = Tree::last_path_token($path);
        $this->assertEqual($last_token,"html");
        
        $all_but_last = Tree::all_but_last_path_tokens($path);
 
        $this->assertEqual(count($all_but_last),0,"Il numero dei path token non corrisponde!!");

    }
    
    function testPathTokensFunctions3()
    {
        $path = "/html//";
        
        $path_tokens = Tree::path_tokens($path);

        $this->assertEqual(count($path_tokens),1,"Il numero dei path token non corrisponde!!");
        $this->assertEqual($path_tokens[0],"html");
        
        $last_token = Tree::last_path_token($path);
        $this->assertEqual($last_token,"html");
        
        $all_but_last = Tree::all_but_last_path_tokens($path);
 
        $this->assertEqual(count($all_but_last),0,"Il numero dei path token non corrisponde!!");

    }
    
    function testPathTokensFunctions4()
    {
        $path = "//html///head/keywords/";
        
        $path_tokens = Tree::path_tokens($path);

        $this->assertEqual(count($path_tokens),3,"Il numero dei path token non corrisponde!!");
        $this->assertEqual($path_tokens[0],"html");
        $this->assertEqual($path_tokens[1],"head");
        $this->assertEqual($path_tokens[2],"keywords");
        
        $last_token = Tree::last_path_token($path);
        $this->assertEqual($last_token,"keywords");
        
        $all_but_last = Tree::all_but_last_path_tokens($path);

        $this->assertEqual(count($all_but_last),2,"Il numero dei path token non corrisponde!!");
        $this->assertEqual($all_but_last[0],"html");
        $this->assertEqual($all_but_last[1],"head");
        
    }
    
    function testSimpleLevel1()
    {
        $r = new Tree();
        
        $r->set("/first","my_value");
        
        $this->assertTrue($r->is_set("/first"),"Il nodo first non e' stato creato!!");
        
        $this->assertEqual($r->get("/first"),"my_value","Il valore impostato non corrisponde!!");
        
        $r->clear();
        
        $this->assertFalse($r->is_set("/first"),"Il nodo first e' stato trovato!!");
        
    }
    
    function testAdd()
    {
        $r = new Tree();
        
        $r->add("/html/head/keywords","hello");
        
        $this->assertEqual(count($r->get("/html/head/keywords")),1,"Il numero di keywords non corrisponde!!");
        
        $r->add("/html/head/keywords","spank");
        
        $this->assertEqual(count($r->get("/html/head/keywords")),2,"Il numero di keywords non corrisponde!!");
    }
    
    function testRemove()
    {
        $r = new Tree();
        
        $r->set("/html/head/keywords",array("hello","world"));
        
        $this->assertEqual(count($r->get("/html/head/keywords")),2,"Il numero di keywords non corrisponde!!");

        $r->set("/html/head/description","Questa è una descrizione di pagina!!");
        
        $this->assertTrue($r->is_set("/html/head/keywords"),"Il nodo /html/head/keywords non e' stato trovato!!");
        $this->assertTrue($r->is_set("/html/head/description"),"Il nodo /html/head/description non e' stato trovato!!");
        
        $r->remove("/html/head/keywords");
        $this->assertFalse($r->is_set("/html/head/keywords"),"Il nodo /html/head/keywords e' stato trovato!!");
        $this->assertTrue($r->is_set("/html/head/description"),"Il nodo /html/head/description non e' stato trovato!!");
        
        $r->remove("/html/head/description");
        $this->assertFalse($r->is_set("/html/head/description"),"Il nodo /html/head/description e' stato trovato!!");
        $this->assertTrue($r->is_set("/html/head"),"Il nodo /html/head non e' stato trovato!!");
        $this->assertTrue($r->is_set("/html"),"Il nodo /html non e' stato trovato!!");
    }
    
    function testClear()
    {        
        $r = new Tree();
        
        $r->set("/html/head/keywords",array("hello","spank"));
        
        $this->assertEqual(count($r->get("/html/head/keywords")),2,"Il numero di keywords non corrisponde!!");
        
        $this->assertTrue($r->is_set("/html/head/keywords"),"Il nodo /html/head/keywords non e' stato trovato!!");
        $this->assertTrue($r->is_set("/html/head"),"Il nodo /html/head non e' stato trovato!!");
        $this->assertTrue($r->is_set("/html"),"Il nodo /html non e' stato trovato!!");
        
        $r->clear();
        
        $this->assertFalse($r->is_set("/html/head/keywords"),"Il nodo /html/head/keywords e' stato trovato!!");
        $this->assertFalse($r->is_set("/html/head"),"Il nodo /html/head e' stato trovato!!");
        $this->assertFalse($r->is_set("/html"),"Il nodo /html e' stato trovato!!");
    }
    
    function testTreeSetGetAdd()
    {        
        $r = new Tree();
        
        $r->set("/html/head/keywords",array("hello","spank"));
        
        $this->assertEqual(count($r->get("/html/head/keywords")),2,"Il numero di keywords non corrisponde!!");
        
        $r->add("/html/head/keywords","ciccia");
        
        $this->assertEqual(count($r->get("/html/head/keywords")),3,"Il numero di keywords non corrisponde!!");
        
    }
    
    function testMerge()
    {        
        $r = new Tree();
        
        $r->set("/html/head/keywords",array("hello","spank"));
        
        $r->merge("/html/head/keywords",array("ciao","mondo"));
        
        $this->assertEqual(count($r->get("/html/head/keywords")),4,"Il numero di keywords non corrisponde!!");
    }
    
    function testPurge()
    {       
        $r = new Tree();
        
        $r->set("/html/head/keywords",array("hello","spank","blabla"));
        
        $this->assertEqual(count($r->get("/html/head/keywords")),3,"Il numero di keywords non corrisponde!!");
       
        $r->purge("/html/head/keywords",array("spank","blabla"));
        
        $this->assertEqual(count($r->get("/html/head/keywords")),1,"Il numero di keywords non corrisponde!!");

    }
    
    function testTreeHasNode()
    {       
        $r = new Tree();
        
        $this->assertFalse($r->is_set("/html/head/keywords"),"Il nodo /html/head/keywords e' stato trovato!!");
        
        $r->set("/html/head/keywords",array("hello","spank"));
        
        $this->assertTrue($r->is_set("/html/head/keywords"),"Il nodo /html/head/keywords non e' stato trovato!!");
        
        $r->remove("/html/head/keywords");
        
        $this->assertFalse($r->is_set("/html/head/keywords"),"Il nodo /html/head/keywords e' stato trovato!!");
        
    }
    
    
    function testGetChangeData()
    {
        $r = new Tree();
        
        $this->assertFalse($r->is_set("/html/head/keywords"),"Il nodo /html/head/keywords e' stato trovato!!");
        
        $r->set("/html/head/keywords",array("hello","spank"));
        
        $this->assertTrue($r->is_set("/html/head/keywords"),"Il nodo /html/head/keywords non e' stato trovato!!");
        $this->assertEqual(count($r->get("/html/head/keywords")),2,"Il numero di keywords non corrisponde!!");
       
        
        $html = $r->view("/html");
        
        $html->set("/head/keywords",array("pippo","pluto","paperino"));
        
        $this->assertEqual(count($html->get("/head/keywords")),3,"Il numero di keywords non corrisponde!!");
        
        $this->assertEqual(count($r->get("/html/head/keywords")),3,"Il numero di keywords non corrisponde!!");
        
    }
    
    function testBidirectionalView()
    {
        $t1 = new Tree();
        
        $t1->set("/prova","ciao");
        $t1->set("/altro/prove/valori",array("primo","secondo","terzo"));
        
        $t2 = $t1->view("/altro/prove");
        
        $this->assertEqual(count($t1->get("/altro/prove/valori")),3,"il numero dei valori non corrisponde!!");
        $this->assertEqual(count($t2->get("/valori")),3,"il numero dei valori non corrisponde!!");
    
        $t1->add("/altro/prove/valori","quarto");
        $this->assertEqual(count($t1->get("/altro/prove/valori")),4,"il numero dei valori non corrisponde!!");
        $this->assertEqual(count($t2->get("/valori")),4,"il numero dei valori non corrisponde!!");
    
        $t1->add("/altro/prove/valori","quinto");
        $this->assertEqual(count($t1->get("/altro/prove/valori")),5,"il numero dei valori non corrisponde!!");
        $this->assertEqual(count($t2->get("/valori")),5,"il numero dei valori non corrisponde!!");
     
    }
    
    function testComposedTrees()
    {
        $t1 = new Tree();
        $t1->set("/master/test",array("a","b","c","d"));
        $t1->set("/master/some_other_values","blahblahblah");
        
        $t2 = new Tree();
        $t2->set("/intresting/new_values",array("e","f","g","h","i"));
        
        $t1->set("/master/some_other_values",$t2);
        
        $this->assertEqual(count($t1->get("/master/some_other_values/intresting/new_values")),5,"Il numero dei valori nel branch non corrisponde!!");


        //TREE LINKING IS NOT SUPPORTED.
        //$t2->add("/intresting/new_values","q");
        //$this->assertEqual(count($t2->get("/intresting/new_values")),6,"Il numero dei valori nel branch non corrisponde!!");
        
        //$this->assertEqual(count($t1->get("/master/some_other_values/intresting/new_values")),6,"Il numero dei valori nel branch non corrisponde!!");
        
    }

    function testNormalizeData()
    {
        $string = "hello!!";

        $this->assertEqual($string,Tree::normalize_data($string),"Il dato normalizzato non corrisponde!!");
    }


    function testDataEntry()
    {
        $t1 = new Tree();
        $t1->set("/master/test","xyz");

        $this->assertEqual($t1->get("/master/test"),"xyz","Il valore di /master/test non e' xyz!!");

        $t1->merge("/master/first_test",array("first" => "my_first_value"));
        $t1->merge("/master/second_test",array("second" => "my_second_value"));

        $this->assertEqual($t1->get("/master/first_test/first"),"my_first_value","Il valore di test non corrisponde!!");
        $this->assertEqual($t1->get("/master/second_test/second"),"my_second_value","Il valore di test non corrisponde!!");

    }

}

