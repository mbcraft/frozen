<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

/*
* Elimina un DO e relativo Peer
* */
class DropDoModuleAction extends AbstractModuleAction
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

        $do_file_name = $name."DO.class.php";
        $peer_file_name = $name."Peer.class.php";

        $d = new Dir($location);
        $do_file = $d->newFile($do_file_name);
        $do_file->delete();
        $peer_file = $d->newFile($peer_file_name);
        $peer_file->delete();
        $d->delete();
    
    }
}

?>