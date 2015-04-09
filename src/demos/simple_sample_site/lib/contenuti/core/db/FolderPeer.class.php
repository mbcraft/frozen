<?php

/*
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_parent_folder` BIGINT UNSIGNED,
  `nome` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `descrizione` varchar(512) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `keywords` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `chiave` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
*/

class FolderPeer extends AbstractPeer
{
    public function __getMyTable()
    {
        return "tab_folders";
    }
}

?>