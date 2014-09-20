<?php


class TestGallery extends UnitTestCase
{
    function testFolderStartingWithNumbers()
    {
        $folder_name = "001_my folder name";
        
        $matches = array();
        $this->assertTrue(preg_match("/\A\d+_/",$folder_name,$matches,PREG_OFFSET_CAPTURE),"Il pattern non cattura le cartelle che iniziano con numeri seguiti da underscore!!");
               
        $final_folder_name = substr($folder_name, strlen($matches[0][0]));
        
        $this->assertEqual("my folder name",$final_folder_name,"Il nome finale della cartella non corrisponde!!");
        
    }
    
    function testFolderStartingWithNumbers2()
    {
        $folder_name = "0011_my folder name";
        
        $matches = array();
        $this->assertTrue(preg_match("/\A\d+_/",$folder_name,$matches,PREG_OFFSET_CAPTURE),"Il pattern non cattura le cartelle che iniziano con numeri seguiti da underscore!!");
               
        $final_folder_name = substr($folder_name, strlen($matches[0][0]));
        
        $this->assertEqual("my folder name",$final_folder_name,"Il nome finale della cartella non corrisponde!!");
        
    }
}

?>