<?php

require_once("../framework/init.php");

Auth::logout();

$current_host = Host::current();

header("Location: http://".$current_host."/test/login.php");

?>