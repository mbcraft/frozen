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

class FixSpaces
{
    private $leading_spaces_patterns = "/\A[\s]+/mix";
    private $trailing_spaces_patterns = "/[\s]+\Z/mix";
    private $problematic_files_found = array();
    
    function scan_file($f)
    {
        $content = $f->getContent();

        if (preg_match($this->leading_spaces_patterns,$content))
        {
            $content = preg_replace($this->leading_spaces_patterns,"",$content);
            $f->setContent($content);
            return "LEADING SPACES";
        }
        if (preg_match($this->trailing_spaces_patterns,$content))
        {
            $content = preg_replace($this->trailing_spaces_patterns,"",$content);
            $f->setContent($content);
            return "TRAILING SPACES";
        }
        return null;
    }
 
    
   function scan()
   {
       $root_dir = new Dir("/");
       $this->scan_dir($root_dir);
   }
   
   function needs_scanning($f)
    {
        if ($f->getExtension()=="php")
        {
            return true;
        }
        else return false;
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
                    $result = $this->scan_file($ff);
                    if ($result!==null)
                        $this->problematic_files_found[] = array($ff->getPath(),$result);
                }
        }
    }
    
    function print_report()
    {
        if (count($this->problematic_files_found)>0)
        {
            foreach ($this->problematic_files_found as $ff)
            {
                echo "Problematic file fixed : ".$ff[0]." : ".$ff[1]."<br />";
            }
        }
        else
        {
            echo "Your website seems OK .<br />";
        }
    }
}

//START WEBSCAN CODE ...

echo "-- FixSpaces 1.0 -- Powered by Frostlab gate<br />";

$scanner = new FixSpaces();
echo "Scanning ... ";
$scanner->scan();
echo "done!<br />";
echo "Report :<br />";
$scanner->print_report();
echo "<hr>";


?>