<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */


require_once(FRAMEWORK_CORE_PATH."lib/utils/Benchmark.class.php");

class TestBenchmark extends UnitTestCase
{
    function testBasicState()
    {
        Benchmark::__reset();

        $this->assertEqual(Benchmark::get_opened_benchmarks_count(),0,"Benchmark gia' aperti");
        $b = Benchmark::start(__CLASS__, __METHOD__);
        $this->assertEqual(Benchmark::get_opened_benchmarks_count(),1,"Nessun benchmark aperto");
        $this->assertTrue(Benchmark::stop()>=0,"Il tempo del benchmark e' inferiore a 0");
        $this->assertEqual(Benchmark::get_opened_benchmarks_count(),0,"Benchmark ancora aperto.");

        $r = Benchmark::start(__CLASS__,__METHOD__);
            $this->assertEqual(Benchmark::get_opened_benchmarks_count(),1,"Benchmark aperti non 1.");

            $this->assertEqual($r->get_nested_benchmarks_count(), 0,"Numero di benchmark annidati non 0");
                Benchmark::start(__CLASS__,__METHOD__);
                Benchmark::stop();
                $this->assertEqual(Benchmark::get_opened_benchmarks_count(),1,"Benchmark aperti non 1.");

            $this->assertEqual($r->get_nested_benchmarks_count(), 1,"Numero di benchmark annidati non 1");
                Benchmark::start(__CLASS__,__METHOD__);
                Benchmark::stop();
                $this->assertEqual(Benchmark::get_opened_benchmarks_count(),1,"Benchmark aperti non 1.");
            $this->assertEqual($r->get_nested_benchmarks_count(), 2,"Numero di benchmark annidati non 2");
                Benchmark::start(__CLASS__,__METHOD__);
                $this->assertEqual(Benchmark::get_opened_benchmarks_count(),2,"Benchmark aperti non 2.");
                Benchmark::stop();
                $this->assertEqual(Benchmark::get_opened_benchmarks_count(),1,"Benchmark aperti non 1.");
            $this->assertEqual($r->get_nested_benchmarks_count(), 3,"Numero di benchmark annidati non 3");
        Benchmark::stop();
    }

    public function testStopCoherence()
    {
        Benchmark::__reset();

        Benchmark::start(__CLASS__,__METHOD__);
        Benchmark::stop();

        try
        {
            Benchmark::stop();
            $this->fail("Non c'e' coerenza nel numero di benchmark aperti e chiusi");

        }
        catch (Exception $ex)
        {

        }
    }

    public function testBenchmarkClassMethod()
    {
        Benchmark::__reset();
        $b = Benchmark::start(__CLASS__, __METHOD__);
        $this->assertEqual($b->get_benchmark_class(),"TestBenchmark","La classe del benchmark non corrisponde");
        $this->assertEqual($b->get_benchmark_method(),"testBenchmarkClassMethod","Il metodo del benchmark non corrisponde");
        $this->assertEqual($b->get_benchmark_signature(), "TestBenchmark@testBenchmarkClassMethod");
        $this->assertFalse($b->is_finished(),"Il benchmark risulta terminato!");
        Benchmark::stop();
        $this->assertTrue($b->is_finished(),"Il benchmark non risulta terminato!");
    }



    public static function myStaticMethod($tester)
    {
        Benchmark::__reset();
        $b = Benchmark::start(__CLASS__, __METHOD__);
        $tester->assertEqual($b->get_benchmark_class(),"TestBenchmark","La classe del benchmark non corrisponde");
       
        $tester->assertEqual($b->get_benchmark_method(), "myStaticMethod","Il metodo del benchmark non corrisponde");
        $tester->assertEqual($b->get_benchmark_signature(), "TestBenchmark@myStaticMethod");
        $tester->assertFalse($b->is_finished(),"Il benchmark risulta terminato!");
        Benchmark::stop();
        $tester->assertTrue($b->is_finished(),"Il benchmark non risulta terminato!");
    }
    
    
    public function testStaticBenchmark()
    {
        $method_name = "myStaticMethod";
        
        TestBenchmark::${"method_name"}($this);
    }
     
    

    public function testBenchmarkObjectMethod()
    {
        Benchmark::__reset();

        $b = Benchmark::start($this, __METHOD__);
        $this->assertEqual($b->get_benchmark_class(),"TestBenchmark","La classe del benchmark non corrisponde");
        $this->assertEqual($b->get_benchmark_method(),"testBenchmarkObjectMethod","Il metodo del benchmark non corrisponde");
        $this->assertEqual($b->get_benchmark_signature(), "TestBenchmark@testBenchmarkObjectMethod");
        $this->assertFalse($b->is_finished(),"Il benchmark risulta terminato!");
        Benchmark::stop();
        $this->assertTrue($b->is_finished(),"Il benchmark non risulta terminato!");
    }
}

