<?
/* This software is released under the BSD license. Full text at project root -> license.txt */
require_once("../init.php");

$d = new Dir("/framework/core/lib/");

class CopyrightVisitor
{
    function visit($dir)
    {
        $all_files = $dir->listFiles();
    
        
        foreach ($all_files as $f)
        {
            $valid = $f->isFile() && ($f->getFullExtension() == "class.php" || $f->getFullExtension() == "interface.php");
            if ($valid && !$this->has_copyright($f))
                echo $f->getPath()." hasn't copyright."."<br />";
        }
        
    }
    
    function has_copyright($f)
    {
        $te = new TextEditor();
    
        $te->load_content_from_file($f);

        $pattern = "/NOTA"." DI "."COPYRIGHT/m";

        $matches = $te->matches_pattern($pattern);

        return count($matches[0])>0;
    }
    
    function add_copyright($f)
    {
        $te = new TextEditor();

        $te->load_content_from_file($f);

        $copyright = "<?

    /*
    * NOTA DI COPYRIGHT
    Questo framework è esclusiva proprietà di Frostlab gate. Ne è vietato l'utilizzo, la copia, la modifica o la redistribuzione 
    sotto qualsiasi forma senza l'esplicito consenso da parte di Frostlab gate. Tutti i diritti riservati.
    *
    * COPYRIGHT NOTICE
    This framework is exclusive property of Frostlab gate. Usage, copy, changes or redistribution in any form are forbidden
    without an explicit agreement with Frostlab gate. All rights reserved.
    */

    ";
        $matches = $te->matches_pattern("/(class)|(interface)/m");


    }
}


$d = new Dir("/framework/modules/");
$d->visit(new CopyrightVisitor());

?>