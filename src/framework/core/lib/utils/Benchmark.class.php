<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */



/**
 * Fornisce funzionalità di benchmark nidificato in modo molto semplice :
 *
 * Benchmark::start($class,$method);
 *      ... altre chiamate nidificate ...
 * Benchmark::stop();
 *
 * Benchmark::print_as_html_comments();
 *
 * OK COMPLETATA.
 */

class Benchmark
{
    private $benchmark_signature=null;
    private $current_class=null;
    private $current_method=null;
    private $finished;
    
    private $start_time =null;
    private $end_time =null;


    private $nested_benchmarks = array();

    static $initialized = false;
    static $opened_benchmarks;

    protected function __construct($class_or_instance,$method)
    {
        if ($method!==null)
            $this->__init_signature($class_or_instance,$method);

        $this->finished = false;
    }

    private function get_class($class_or_instance)
    {
        if (is_object($class_or_instance)) return get_class($class_or_instance);
        $pos = strpos($class_or_instance, "::");
        if ($pos!=0)
            return substr ($class_or_instance, 0,pos);
        $pos = strpos($class_or_instance, "#");
        if ($pos!=0)
            return substr ($class_or_instance, 0,pos);
        return $class_or_instance;

    }

    private function __init_signature($class_or_instance,$method)
    {
 
        if (strpos($method,$this->get_class($class_or_instance))===0)
        {
            //instance method
            $splitted = explode("::",$method);
            $this->current_class = $splitted[0];
            $this->current_method = $splitted[1];
            $this->benchmark_signature = str_replace("::","@",$method);
            return;
        }
        
        if (strpos($class_or_instance,SITE_ROOT_PATH)===0)
        {
            //caso con file
            $this->current_class = "";
            $this->current_method = $method;

            $this->benchmark_signature = substr(str_replace(SITE_ROOT_PATH,"",$file_or_class_or_instance),1)." : ".$this->current_method;
            return;
        }

        if (strpos($method, $class_or_instance)===0)
        {
            //class method
            $this->benchmark_signature = $method;
            $this->current_class = $file_or_class_or_instance;
            $this->current_method = str_replace("::","",str_replace($file_or_class_or_instance, "", $method));
            return;

        }
        throw new Exception("Caso non previsto ...");

    }



    public static function __reset()
    {
        self::$initialized = false;
    }

    private static function init()
    {
        self::$initialized = true;
        $root_benchmark = new Benchmark(null,null);
        self::$opened_benchmarks = array();
        self::$opened_benchmarks[] = $root_benchmark;

    }

    public static function start($file_or_class_or_instance,$method)
    {
        if (!self::$initialized) self::init();
        $b = new Benchmark($file_or_class_or_instance, $method);
        self::$opened_benchmarks[] = $b;
        $b->start_time = microtime(true);
        return $b;
    }
    public static function stop()
    {
        if (!self::$initialized) self::init();

        if (count(self::$opened_benchmarks)==1)
            throw new Exception("Benchmark : Il numero dei benchmark non corrisponde");

        $b = array_pop(self::$opened_benchmarks);
        $b->end_time = microtime(true);
        $b->finished = true;
        $final_time = $b->end_time - $b->start_time;
        self::$opened_benchmarks[count(self::$opened_benchmarks)-1]->nested_benchmarks[] = $b;
        return $final_time;
    }

    public function benchmark_time_seconds()
    {
        $start = $this->start_time;
        $end = $this->end_time;

        return sprintf("%01.2f", ($end-$start)*100);
    }

    private function indent($level)
    {
        for ($i=0;$i<$level;$i++) echo "\t";
    }

    public static function print_as_html_comments()
    {
        if (!self::$initialized) self::init();

        if (count(self::$opened_benchmarks)!=1)
            Log::error(__METHOD__, "Il numero dei benchmark aperti non è 1!!!");
        $root_benchmark = self::$opened_benchmarks[0];
        echo "<!-- START Benchmarks list -->\n";
        $root_benchmark->recursive_print_as_html_comment(1);
        echo "<!-- END Benchmarks list -->\n";
    }

    private function recursive_print_as_html_comment($level)
    {
        if ($this!=self::$opened_benchmarks[0])
        {
            $this->indent($level);
            echo "<!-- Benchmark for ".$this->current_class."#".$this->current_method." : ".$this->benchmark_time_seconds()." sec. -->\n";
        }
        foreach ($this->nested_benchmarks as $bm)
        {
            $bm->recursive_print_as_html_comment($level+1);
        }
    }

    public static function get_opened_benchmarks_count()
    {
        if (!self::$initialized) self::init();
        
        return count(self::$opened_benchmarks)-1;
    }

    public function get_nested_benchmarks_count()
    {
        return count($this->nested_benchmarks);
    }

    public function get_benchmark_class()
    {
        return $this->current_class;
    }

    public function get_benchmark_method()
    {
        return $this->current_method;
    }

    public function get_benchmark_signature()
    {
        return $this->benchmark_signature;
    }

    public function is_finished()
    {
        return $this->finished;
    }

}

?>