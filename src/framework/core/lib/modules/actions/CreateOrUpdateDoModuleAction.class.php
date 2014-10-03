<?php

/*
* Crea o aggiorna DO e relativo Peer.
* */
class CreateOrUpdateDoModuleAction extends AbstractModuleAction
{
    function setup($tag,$attributes)
    {
        $this->tag = tag;
        $this->attributes = $attributes;
    }
    
    function execute()
    {
        $attributes = $this->attributes;
    
        $name = $attributes->name;
        $location = $attributes->location;
        $table_name = $attributes->table_name;

        $do_file_name = $name."DO.class.php";
        $peer_file_name = $name."Peer.class.php";

        $d = new Dir($location);
        $d->touch();

        $do_file = $d->newFile($do_file_name);
        $do_file->setContent("<?
        class ".$name."DO extends AbstractDO
        {
            static function __getMyTable()
            {
                return \"".$table_name."\";
            }
        }
?>");
        $peer_file = $d->newFile($peer_file_name);
        $peer_file->setContent("<?
        class ".$name."Peer extends AbstractPeer {}
?>");
     
    }
}

?>