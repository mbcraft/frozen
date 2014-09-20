<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */


class GalleryController extends AbstractController
{
    /*
     * Crea una gallery per l'utente corrente
     * */
    function create_gallery()
    {
        $peer = new GalleryPeer();
        $gallery = $peer->new_do();
        $peer->setupByParams($gallery);
        $gallery->folder = Random::newHexString();
        
        $peer_collection = new GalleryCollectionPeer();

        $collection = $peer_collection->find_by_id($gallery->id_gallery_collection);
        
        $d = new Dir(GalleryCollectionController::GALLERY_COLLECTION_ROOT_DIR.$collection->folder."/".$gallery->folder);
        $d->touch();
        
        $peer->save($gallery);
        
        if (is_html())
        {
            return Redirect::success();
        }
        else
        {
            return Result::ok();
        }
    }
 

    /*
     * Elimina una gallery per l'utente corrente
     * */
    function delete_gallery()
    {
        $id_gallery = Params::get("id_gallery");
        
        $peer_gallery = new GalleryPeer();
        $gal = $peer_gallery->find_by_id($id_gallery);
        
        $peer_collection = new GalleryCollectionPeer();
        $collection = $peer_collection->find_by_id($gal->id_gallery_collection);
        
        $peer_gallery_image = new GalleryImagePeer();
        $peer_gallery_image->id_gallery__EQUAL($id_gallery);
        $all_images = $peer_gallery_image->find();
        
        foreach ($all_images as $img)
        {
            call("gallery_image","delete_image",array("id_gallery_image" => $img->id_gallery_image));
        }        
        $dir = new Dir(GalleryCollectionController::GALLERY_COLLECTION_ROOT_DIR.$collection->folder."/".$gal->folder);
        $dir->delete(true);

        $peer_gallery->delete($gal);

        if (is_html())
        {
            return Redirect::success();
        }
        else
        {
            return Result::ok();
        }
        
    }

    /*
     * Ritorna l'elenco degli elementi nella cartella corrente
     * */
    function index()
    {
        $id_gallery_collection = Params::get("id_gallery_collection");
        
        $peer = new GalleryPeer();
        $peer->id_gallery_collection__EQUAL($id_gallery_collection);
        $gallery_list = $peer->find();
        
        return ActiveRecordUtils::toArray($gallery_list);
    }

    /*
     * Metodo di utilità per recuperare le cartelle in modo ricorsivo.
     * */
    /*
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
    */
    
    function modify_gallery()
    {
        $peer = new GalleryPeer();
        $do = $peer->updateByParams();
        $peer->save($do);

        if (is_html())
            return Redirect::success();
        else
            return Result::ok();
    }
    
    /*
     * Questo metodo restituisce tutto l'albero delle cartelle delle gallery a partire da una determinata
     * cartella.
     *
     * */

    
    /*
     * Ritorna la gallery con tutte le immagini e percorso addizionale.
     * 
     */
    function get_gallery()
    {
        if (Params::is_set("id_gallery"))
        {
            $id_gallery = Params::get("id_gallery");
        
            $peer = new GalleryPeer();
            $gallery = $peer->find_by_id($id_gallery);
        }
        else
        {
            $gallery_name = Params::get("gallery_name");
            
            $tokens = preg_split("/\//",$gallery_name);
            $collection_key = $tokens[0];
            $gallery_key = $tokens[1];
                        
            $collection = call("gallery_collection","get_collection_by_key",array("key" => $collection_key));
                                            
            $peer = new GalleryPeer();
            
            $peer->id_gallery_collection__EQUAL($collection["id_gallery_collection"]);
            $peer->key__EQUAL($gallery_key);
                       
            $gallery = $peer->find_single_result();
        }

        
        $collection_peer = new GalleryCollectionPeer();
        $gallery_collection = $collection_peer->find_by_id($gallery->id_gallery_collection);
        
        $folder_path = GalleryCollectionController::GALLERY_COLLECTION_ROOT_DIR.$gallery_collection->folder."/".$gallery->folder;
        
        $gallery_data = ActiveRecordUtils::toArray($gallery);
        
        $image_list = call("gallery_image","index",array("__filter_id_gallery__EQUAL" => $gallery_data["id_gallery"]));
        foreach ($image_list as $k => &$img)
        {
            $img["path"] = $folder_path."/".$img["image_name"];
        }
        $gallery_data["image_list"] = $image_list;
        $gallery_data["gallery_name"] = $gallery_collection->key."/".$gallery->key;
        $gallery_data["id_collection"] = $gallery->id_gallery_collection;
        
        
        
        return $gallery_data;
    }

}

?>