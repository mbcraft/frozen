<?php

/*
 * USAGE (at the end of the home page) :
 *
 * require_once("include/portfolio.php");
 * probe_portfolio_ping("934804037432072398432");
 *
 * */

function do_portfolio_ping($validation_code)
{
    if (function_exists("pcntl_fork"))
    {
    	$pid = call_user_func("pcntl_fork");
    	if ($pid) return;
    }

    $current_host = $_SERVER["HTTP_HOST"];

    $query_opts = array("format" => 1, "current_host" => $_SERVER["HTTP_HOST"],"validation_code" => $validation_code);

    $query = http_build_query($query_opts);

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    curl_setopt($ch, CURLOPT_URL,"http://www.frostlab.it/actions/sito_portfolio/ping.php?".$query);

    $result = curl_exec($ch);

    if (strpos($result,"OK")===false)
        mail("debug@frostlab.it","--- Portfolio pingback error ---","Si e' verificato un errore nel ping del portfolio per il sito ".$current_host.". Risultato : ".$result);

    curl_close($ch);
}

function probe_portfolio_ping($validation_code,$frequency=2)
{
    if (!rand(0,$frequency))
        do_portfolio_ping($validation_code);
}

?>
