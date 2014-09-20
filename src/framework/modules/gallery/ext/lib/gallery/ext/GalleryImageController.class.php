<?
/* This software is released under the BSD license. Full text at project root -> license.txt */


class GalleryImageController extends AbstractController
{
    
    function index()
    {
        $peer = new GalleryImagePeer();
        ActiveRecordUtils::updateFilters($peer);
        $result = $peer->find();
    
        return ActiveRecordUtils::toArray($result);
    }
    /*
     * Aggiunge un'immagine alla gallery
     * */
    function add_to_gallery()
    {
        $gallery_peer = new GalleryPeer();
        $gallery = $gallery_peer->find_by_id(Params::get("id_gallery"));
        
        $collection_peer = new GalleryCollectionPeer();
        $gallery_collection = $collection_peer->find_by_id($gallery->id_gallery_collection);
        $full_folder_path = GalleryCollectionController::GALLERY_COLLECTION_ROOT_DIR.$gallery_collection->folder."/".$gallery->folder;
        
        if (Upload::isUploadSuccessful("file"))
        {
            $filename = Random::newHexString()."_".Upload::getRealFilename("file");
            
            $gallery_dir = new Dir($full_folder_path);
            $uploaded_img = Upload::saveTo("file",$gallery_dir,$filename);

            if (isset(Config::instance()->GALLERY_RESIZE_BY_WIDTH))
            {
                image_w($uploaded_img->getPath(),Config::instance()->GALLERY_RESIZE_BY_WIDTH);
            }
            else if (isset(Config::instance()->GALLERY_RESIZE_BY_HEIGHT))
            {
                image_h($uploaded_img->getPath(),Config::instance()->GALLERY_RESIZE_BY_HEIGHT);
            }
            
            $peer = new GalleryImagePeer();
            $do = $peer->new_do();
            $peer->setupByParams($do);
            $do->image_name = $filename;
            
            $peer->save($do);
            
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
    function delete_from_gallery()
    {
        $id_gallery_image = Params::get("id_gallery_image");
        
        $peer = new GalleryImagePeer();
        $gallery_image = $peer->find_by_id($id_gallery_image);
        
        $gallery_peer = new GalleryPeer();
        $gallery = $gallery_peer->find_by_id($gallery_image->id_gallery);
        
        $collection_peer = new GalleryCollectionPeer();
        $gallery_collection = $collection_peer->find_by_id($gallery->id_gallery_collection);
        
        $full_image_path = GalleryCollectionController::GALLERY_COLLECTION_ROOT_DIR.$gallery_collection->folder."/".$gallery->folder."/".$gallery_image->image_name;
        
        $f = new File($full_image_path);

        ImagePicker::delete_image_thumbnails($f);

        $f->delete();  
        $peer->delete($gallery_image);
      
        
        return Redirect::success();
    }
    
    function modify_image()
    {
        $peer = new GalleryImagePeer();
        
        $do = $peer->updateByParams();
    
        $peer->save($do);
        
        if (is_html())
            return Redirect::success();
        else
            return Redirect::failure();
    }
    
    function get_image()
    {
        $peer = new GalleryImagePeer();
        $gallery_image = $peer->find_by_id(Params::get("id_gallery_image"));
        
        return ActiveRecordUtils::toArray($gallery_image);
        
    }
}

?>