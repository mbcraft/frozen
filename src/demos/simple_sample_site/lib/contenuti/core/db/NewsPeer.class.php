<?php

class NewsPeer extends AbstractPeer
{
    public function __getMyTable()
    {
        return "tab_news";
    }
}

?>