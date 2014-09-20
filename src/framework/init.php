<?php

/* This software is released under the BSD license. Full text at project root -> license.txt */

if (!defined("SITE_ROOT_PATH"))
{
//imposta l'include path in modo assoluto per la root del sito
$real_script_name = str_replace("/",DIRECTORY_SEPARATOR,$_SERVER['SCRIPT_NAME']);
$site_root_path = str_replace($real_script_name, "", $_SERVER['SCRIPT_FILENAME']);
define ("SITE_ROOT_PATH",$site_root_path);
$inc_path = get_include_path().PATH_SEPARATOR.$site_root_path;

set_include_path($inc_path);
//echo get_include_path();

define ("FRAMEWORK_CORE_PATH","framework/core/");
define ("FRAMEWORK_MODULES_PATH","framework/modules/");

//directory separator
define ("DS","/");

}

//carico le funzioni tradizionali
require_once(FRAMEWORK_CORE_PATH."lib/base/load_functions.php");
//carico il classloader
require_once(FRAMEWORK_CORE_PATH."lib/base/classloader.php");


//carico la classe x benchmark
//require_once(FRAMEWORK_CORE_PATH."lib/base/Benchmark.class.php");
//carico il loader delle configurazioni
require_once(FRAMEWORK_CORE_PATH."lib/base/FrameworkConfigLoader.class.php");
require_once(FRAMEWORK_CORE_PATH."lib/base/FrameworkIniConfigLoader.class.php");
//require_once(FRAMEWORK_CORE_PATH."lib/base/__ModulesConfigAutoloader.class.php");
require_once(FRAMEWORK_CORE_PATH."lib/base/AppConfigLoader.class.php");
require_once(FRAMEWORK_CORE_PATH."lib/base/AppIniConfigLoader.class.php");


//Benchmark::start(__FILE__,"__ConfigAutoloader::instance()");
FrameworkConfigLoader::instance();
FrameworkIniConfigLoader::instance();

AppConfigLoader::instance();
AppIniConfigLoader::instance();

//Benchmark::stop();

date_default_timezone_set(Config::instance()->TIMEZONE);

?>