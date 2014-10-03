<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

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