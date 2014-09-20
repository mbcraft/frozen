<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

class GalleryController extends AbstractController
{
    const GALLERY_ROOT_PATH = "/immagini/gallery/user";

    /*
     * Ok è sempre l'utente corrente che modifica la gallery
     */
    const SESSION_GALLERY_CURRENT_FOLDER = "/session/admin/gallery/current_folder";

    function load_root_as_current_folder()
    {
        Session::set(self::SESSION_GALLERY_CURRENT_FOLDER,$this->get_user_root());

        return Redirect::success();
    }

    function get_user_root()
    {
        if (!Session::is_set("/session/username")) throw new IllegalStateException("A user must be logged!!");

        return self::GALLERY_ROOT_PATH."/".Session::get("/session/username")."/";
    }

    /*
     * Crea una gallery per l'utente corrente
     * */
    function create_gallery()
    {
        $gallery_name = Params::get("gallery_name");
        $dir = new Dir($this->get_current_folder()."/".$gallery_name);
        $dir->touch();
        $gallery_ini = $dir->newFile("_gallery.ini");
        $gallery_ini->touch();

        if (is_html())
        {
            return Redirect::success();
        }
        else
        {
            return Result::ok();
        }
    }

    function create_folder()
    {
        $folder_name = Params::get("folder_name");
        $dir = new Dir($this->get_current_folder()."/".$folder_name);
        $dir->touch();

        if (is_html())
        {
            return Redirect::success();
        }
        else
        {
            return Result::ok();
        }
    }

    function delete_folder()
    {
        $folder_name = Params::get("folder_name");
        $dir = new Dir($this->get_current_folder()."/".$folder_name);
        $gallery_ini = $dir->newFile("_gallery.ini");
        if (!$gallery_ini->exists())
        {
            $dir->delete(true);

            if (is_html())
            {
                return Redirect::success();
            }
            else
            {
                return Result::ok();
            }
        }
        else
        {
            if (is_html())
            {
                return Redirect::failure();
            }
            else
            {
                return Result::error("Impossibile eliminare la cartella");
            }
        }
    }

    /*
     * Elimina una gallery per l'utente corrente
     * */
    function delete_gallery()
    {
        $gallery_name = Params::get("gallery_name");
        $dir = new Dir($this->get_current_folder()."/".$gallery_name);
        $gallery_ini = $dir->newFile("_gallery.ini");
        if ($gallery_ini->exists())
        {
            $dir->delete(true);

            if (is_html())
            {
                return Redirect::success();
            }
            else
            {
                return Result::ok();
            }
        }
        else
        {
            if (is_html())
            {
                return Redirect::failure();
            }
            else
            {
                return Result::error("Impossibile eliminare la gallery");
            }
        }
    }

    /*
     * Ritorna l'elenco degli elementi nella cartella corrente
     * */
    function index()
    {
        $current_folder = new Dir($this->get_current_folder());
        $all_subfolders = $current_folder->listFolders();

        $result = array();
        $result["elements"] = array();

        foreach ($all_subfolders as $fold)
        {
            $gallery_marker = $fold->newFile("_gallery.ini");
            $f = array();
            if ($gallery_marker->exists())
            {
                $f = array();
                $f["type"] = "gallery";
                $f["name"] = $fold->getName();
            }
            else
            {
                $f = array();
                $f["type"] = "folder";
                $f["name"] = $fold->getName();
            }
            $result["elements"][] = $f;
        }

        return $result;
    }

    /*
     * Aggiunge un'immagine alla gallery
     * */
    function add_image()
    {
        if (Upload::isUploadSuccessful("file"))
        {

            $gallery_dir = new Dir($this->get_current_folder());
            $uploaded_img = Upload::saveTo("file",$gallery_dir);

            if (isset(Config::instance()->GALLERY_RESIZE_BY_WIDTH))
            {
                image_w($uploaded_img->getPath(),Config::instance()->GALLERY_RESIZE_BY_WIDTH);
            }
            else if (isset(Config::instance()->GALLERY_RESIZE_BY_HEIGHT))
            {
                image_h($uploaded_img->getPath(),Config::instance()->GALLERY_RESIZE_BY_HEIGHT);
            }
            
            $peer = new GalleryImagePeer();
            

            return Redirect::success();
        }
        else
        {
            Flash::error(Upload::getUploadError("file"));
            return Redirect::failure();
        }
    }

    /*
     * Elimina un'immagine dalla gallery
     * */
    function delete_image()
    {
        $image_name = Params::get("image_name");

        $f = new File($this->get_current_folder()."/".$image_name);

        ImagePicker::delete_image_thumbnails($f);

        $f->delete();

        return Redirect::success();
    }
   

    /*
     * Metodo di utilità per recuperare le cartelle in modo ricorsivo.
     * */
    static function recursive_get_folders($parent_path,$folder)
    {
        $sub_folders = $folder->listFolders();
        if (count($sub_folders)>0)
        {
            $result = array();
            foreach ($sub_folders as $f)
            {
                $elem = array();
                
                $name = $f->getName();
                $matches = array();

                if (preg_match("/\A\d+_/",$name,$matches,PREG_OFFSET_CAPTURE))
                    $real_name = substr($name, strlen($matches[0][0]));
                else
                    $real_name = $name;

                $elem["name"] = $real_name;
                $elem["path"] = $parent_path."/".$f->getName();
                $elem["childs"] = self::recursive_get_folders($parent_path.$f->getName(),$f);

                $result[] = $elem;
                                
            }

            return $result;
        }
        else
            return null;
    }

    /*
     * Questo metodo restituisce tutto l'albero delle cartelle delle gallery a partire da una determinata
     * cartella.
     *
     * */

    function get_gallery_tree()
    {
        $folder_name = Params::get("folder_name");
        $d = new Dir(self::GALLERY_ROOT_PATH."/".$folder_name);

        $result = array();
        $result["tree_path"] = $d->getPath();
        $result["tree_elements"] = self::recursive_get_folders($folder_name,$d);

        if (is_html())
        {
            //$result[Block::MARKER_KEY] = "gallery/base/tree";
            return $result;
        }

        return $result;
    }

    function get_current_gallery()
    {
        $current_folder = new Dir($this->get_current_folder());
        return call("gallery","get_gallery",array("gallery_name" => substr($current_folder->getPath(),strlen(self::GALLERY_ROOT_PATH."/"))));
    }

    /*
     * Questo metodo scorre la cartella e legge tutti i file restituendoli per la gallery.
     * 
     * */
    function get_gallery()
    {
        $gallery_name = Params::get("gallery_name");

        $result = array();

        $result["gallery_name"] = $gallery_name;

        $d = new Dir(self::GALLERY_ROOT_PATH."/".$gallery_name);
        $files = $d->listFiles();

        $image_list = array();

        foreach ($files as $f)
        {
            if ($f->isFile() && $f->getExtension()!="ini")
            {
                $image = array();
                $image["path"] = $f->getPath();
                $image["title"] = str_replace("_"," ",$f->getName());
                $image["name"] = $f->getFilename();
                $image["type"] = "image";
                $image_list[] = $image;
            }
        }

        $result["image_list"] = $image_list;

        return $result;
    }

    function get_parent_folder()
    {
        $current_folder = new Dir($this->get_current_folder());

        $root_dir = new Dir($this->get_user_root());
        if ($root_dir->isParentOf($current_folder))
        {
            return $current_folder->getParent()->getPath();
        }
        else
            return $root_dir->getPath();
    }

    function is_root()
    {
        if ($this->get_user_root()==$this->get_current_folder())
            return true;
        else
            return false;
    }

    function set_current_folder()
    {
        $root_dir = new Dir($this->get_user_root());

        $folder = Params::get("folder");

        if (!$root_dir->isParentOf($folder)) throw new InvalidDataException("La cartella specificata non e' valida!!");

        Session::set(self::SESSION_GALLERY_CURRENT_FOLDER,Params::get("folder"));

        if (is_html())
            return Redirect::success();
        else
            return Result::ok();
    }

    function get_current_folder()
    {
        if (!Session::is_set(self::SESSION_GALLERY_CURRENT_FOLDER))
            Session::set(self::SESSION_GALLERY_CURRENT_FOLDER,$this->get_user_root());

        return Session::get(self::SESSION_GALLERY_CURRENT_FOLDER);
    }
}

?>