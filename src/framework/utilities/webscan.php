<?php

/* This software is released under the BSD license. Full text at project root -> license.txt */


//imposta l'include path in modo assoluto per la root del sito
$real_script_name = str_replace("/",DIRECTORY_SEPARATOR,$_SERVER['SCRIPT_NAME']);
$site_root_path = str_replace($real_script_name, "", $_SERVER['SCRIPT_FILENAME']);
define ("SITE_ROOT_PATH",$site_root_path);
$inc_path = get_include_path().PATH_SEPARATOR.$site_root_path;

set_include_path($inc_path);


require_once("framework/utilities/io/__FileSystemElement.class.php");
require_once("framework/utilities/io/FileSystemUtils.class.php");
require_once("framework/utilities/io/Dir.class.php");
require_once("framework/utilities/io/File.class.php");

class WebScan
{
    private $virus_patterns = array("/\/t\.php\?/","/img.?.?.?\.net/","/echo \"\"\.gzuncompress\(base64_decode/");
    private $infected_files_found = array();
    
    function scan_file($f)
    {
        $content = $f->getContent();

        foreach ($this->virus_patterns as $pat)
        {
            if (preg_match($pat,$content))
                return true;
        }
        return false;
    }
 
    
   function scan()
   {
       $root_dir = new Dir("/");
       $this->scan_dir($root_dir);
   }
   
   function needs_scanning($f)
    {
        if ($f->getExtension()=="htm" || $f->getExtension()=="html" || $f->getExtension()=="php" || $f->getExtension()=="js")
        {
            if ($f->getName()!="webscan.php")
                return true;    
        }

            return false;

    }

    function scan_dir($d)
    {
        $all_files = $d->listFiles();
        foreach ($all_files as $ff)
        {
            if ($ff->isDir())
                $this->scan_dir($ff);
            else
                if ($this->needs_scanning($ff))
                {
                    if ($this->scan_file($ff))
                        $this->infected_files_found[] = $ff;
                }
        }
    }
    
    function print_report()
    {
        if (count($this->infected_files_found)>0)
        {
            foreach ($this->infected_files_found as $ff)
            {
                echo "Infected file : ".$ff->getPath()."<br />";
            }
        }
        else
        {
            echo "Your website seems CLEAN .<br />";
        }
    }
}

//START WEBSCAN CODE ...

echo "-- WebScan 1.0 -- Powered by MBCRAFT<br />";

$scanner = new WebScan();
echo "Scanning ... ";
$scanner->scan();
echo "done!<br />";
echo "Report :<br />";
$scanner->print_report();
echo "<hr>";


?>