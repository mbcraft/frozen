<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

class RotatorController extends AbstractController
{
    const ROTATOR_GALLERIES_ROOT_PATH = "/immagini/grafica/banners/rotator/";

    /*
     * Ritorna le immagini di un determinato rotator
     * */
    function get_rotator_images()
    {
        $rotator_name = Params::get("rotator_name");

        $result = array();

        $d = new Dir(self::ROTATOR_GALLERIES_ROOT_PATH.$rotator_name);

        if ($d->exists())
        {
            $all_files = $d->listFiles();

            foreach ($all_files as $f)
            {
                $result[] = $f->getFilename();
            }
        }

        return $result;
    }

    /*
     * Aggiunge l'immagine ad un rotator
     * */
    function add_rotator_image()
    {
        $rotator_name = Params::get("rotator_name");

        $d = new Dir(self::ROTATOR_GALLERIES_ROOT_PATH.$rotator_name);
        if ($d->exists())
            Upload::saveTo("my_file",self::ROTATOR_GALLERIES_ROOT_PATH.$rotator_name.DS);
        else
        {
            Flash::error("Errore durante il caricamento dell'immagine!! Contattare l'assistenza : info@mbcraft.it");
            return Redirect::failure();
        }
        Flash::ok("Immagine caricata con successo!!");
        return Redirect::success();

    }

    /*
     * Elimina l'immagine da un rotator
     * */
    function delete_rotator_image()
    {
        $rotator_name = Params::get("rotator_name");
        $image = Params::get("image");

        $f = new File(self::ROTATOR_GALLERIES_ROOT_PATH.$rotator_name.DS.$image);
        $f->delete();

        return Redirect::success();
    }

    /*
     * Ritorna l'elenco dei rotator
     * */
    function get_available_rotators()
    {
        $result = array();

        $d = new Dir(self::ROTATOR_GALLERIES_ROOT_PATH);
        $dirs = $d->listFolders();
        foreach ($dirs as $d)
        {
            $result[] = $d->getName();
        }

        return $result;
    }

    function get_rotator()
    {
        $result = array();
        
        $result["rotator_name"] = Params::get("name");
        $result["image_list"] = array();
        
        $d = new Dir(self::ROTATOR_GALLERIES_ROOT_PATH.$result["rotator_name"]."/");
        if ($d->exists())
        {
            $files = $d->listFiles();
            foreach ($files as $f)
            {
                if ($f->isFile())
                {
                    $img = array();
                    $img["path"] = $f->getPath();
                    $img["title"] = str_replace("_"," ",$f->getName());
                    $result["image_list"][] = $img;
                }
            }
        }
        else
            echo "Rotator gallery directory not found! : ".$d->getPath();
        
        return $result;
    }
}
?>