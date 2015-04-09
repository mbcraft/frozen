<?php


class GalleryController extends AbstractController
{
    const GALLERY_ROOT_PATH = "/immagini/user/gallery/";
        
    function __get_default_layout()
    {
        return "icecube";
    }
    
    function get_gallery()
    {
        $gallery_name = Params::get("gallery_name");
        
        $result = array();
        
        $result["gallery_name"] = $gallery_name;
        
        $d = new Dir(self::GALLERY_ROOT_PATH.$gallery_name);
        $files = $d->listFiles();
        
        $image_list = array();
        
        foreach ($files as $f)
        {            
            if ($f->isFile() && $f->getExtension()!=".ini")
            {
                $image = array();
                $image["path"] = $f->getPath();
                $image["title"] = str_replace("_"," ",$f->getName());
                $image_list[$f->getFilename()] = $image;
            }
        }
        $gallery_dir = new Dir(self::GALLERY_ROOT_PATH.$gallery_name.DS);
        $found_files = $gallery_dir->findFilesEndingWith("gallery.ini");
        
        if (count($found_files)>0)
        {
            $gallery_ini_file = $found_files[0];
            $gallery_props = PropertiesUtils::readFromFile($gallery_ini_file, true);
            $enhanced_image_list = array();
            foreach ($section as $s)
            {
                $path = $s["path"];
                if (strpos($path,"DS")===0)
                    $new_image["path"] = $path;
                else
                    $new_image["path"] = self::GALLERY_ROOT_PATH.$gallery_name.$s["path"];

                $f = new File($new_image["path"]);
                $new_image["title"] = isset($s["title"]) ? $s["title"] : str_replace("_"," ",$f->getName());
                $new_image["description"] = isset($s["description"]) ? $s["description"] : null;
                $enhanced_image_list[] = $new_image;
            }
            $result["image_list"] = $enhanced_image_list;
        }
        else
            $result["image_list"] = $image_list;
        return $result;
    }
}

?>
