<?php

class RotatorController extends AbstractController
{
    const ROTATOR_GALLERIES_ROOT_PATH = "/immagini/grafica/banners/rotator/";

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
