<?php

class SingleAdminController extends AbstractController
{
    const FILTER_CHIAVE_EQUALS = "__filter_chiave__EQUALS";

    const TESTI_ROOT_SINGLE_ADMIN = "ROOT_FOLDER_TESTI_SINGLE_ADMIN";
    const IMMAGINI_ROOT_SINGLE_ADMIN = "ROOT_FOLDER_IMMAGINI_SINGLE_ADMIN";
    const DOCUMENTI_ROOT_SINGLE_ADMIN = "ROOT_FOLDER_DOCUMENTI_SINGLE_ADMIN";
    const GALLERIES_ROOT_SINGLE_ADMIN = "ROOT_FOLDER_GALLERIES_SINGLE_ADMIN";

    function get_root_folder_testi()
    {
        $folder = call("folders","get",array(self::FILTER_CHIAVE_EQUALS => self::TESTI_ROOT_SINGLE_ADMIN));

        if ($folder!==null) return $folder;
        else
        {
            call("folders","create_root",array("chiave" => self::TESTI_ROOT_SINGLE_ADMIN,"nome" => "Cartella root per testi dell'amministratore"));
            return call("folders","get",array(self::FILTER_CHIAVE_EQUALS => self::TESTI_ROOT_SINGLE_ADMIN));
        }
    }

    function get_root_folder_immagini()
    {
        $folder = call("folders","get",array(self::FILTER_CHIAVE_EQUALS => self::IMMAGINI_ROOT_SINGLE_ADMIN));

        if ($folder!==null) return $folder;
        else
        {
            call("folders","create_root",array("chiave" => self::IMMAGINI_ROOT_SINGLE_ADMIN,"nome" => "Cartella root per immagini dell'amministratore"));
            return call("folders","get",array(self::FILTER_CHIAVE_EQUALS => self::IMMAGINI_ROOT_SINGLE_ADMIN));
        }
    }

    function get_root_folder_documenti()
    {
        $folder = call("folders","get",array(self::FILTER_CHIAVE_EQUALS => self::DOCUMENTI_ROOT_SINGLE_ADMIN));
        
        if ($folder!==null) return $folder;
        else
        {
            call("folders","create_root",array("chiave" => self::DOCUMENTI_ROOT_SINGLE_ADMIN,"nome" => "Cartella root per documenti dell'amministratore"));
            return call("folders","get",array(self::FILTER_CHIAVE_EQUALS => self::DOCUMENTI_ROOT_SINGLE_ADMIN));
        }
    }

    function get_root_folder_galleries()
    {
        $folder = call("folders","get",array(self::FILTER_CHIAVE_EQUALS => self::GALLERIES_ROOT_SINGLE_ADMIN));

        if ($folder!==null) return $folder;
        else
        {
            call("folders","create_root",array("chiave" => self::GALLERIES_ROOT_SINGLE_ADMIN,"nome" => "Cartella root per galleries dell'amministratore"));
            return call("folders","get",array(self::FILTER_CHIAVE_EQUALS => self::GALLERIES_ROOT_SINGLE_ADMIN));
        }

    }
}

?>