<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

require_once("../../../init.php");

//Benchmark::start(__FILE__, "TOTAL_PAGE_TIME");

try
{
    Log::info("routing", "Initializing framework.");
    Framework::init();
    Log::info("routing","Framework initialized");

    Log::info("routing", "Executing request ...");
    Engines::executeRequest();
    Log::info("routing", "Request executed.");

}
catch (Exception $ex)
{
    echo "Exception !! ".$ex->getMessage();
    Log::print_logs_as_html_list();    
}

//Benchmark::stop();

//Benchmark::print_as_html_comments();

?>