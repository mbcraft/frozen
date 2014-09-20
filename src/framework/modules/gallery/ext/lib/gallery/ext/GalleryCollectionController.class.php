<?
/* This software is released under the BSD license. Full text at project root -> license.txt */


class GalleryCollectionController extends AbstractController
{
    const GALLERY_COLLECTION_ROOT_DIR = "/immagini/gallery/";
    
    function index()
    {
        $peer = new GalleryCollectionPeer();
        return ActiveRecordUtils::toArray($peer->find());
    }
    
    function create_collection()
    {
        $peer = new GalleryCollectionPeer();
        $do = $peer->new_do();
        
        $peer->setupByParams($do);
        $do->folder = Random::newHexString();
        $d = new Dir(self::GALLERY_COLLECTION_ROOT_DIR.$do->folder);
        $d->touch();
        
        $peer->save($do);
        
        if (is_html())
            return Redirect::success();
        else
            return Result::ok();
    }
    
    function is_collection_empty()
    {
        $all_galleries = call("gallery","index",array("id_gallery_collection" => Params::get("id_gallery_collection")));
    
        return count($all_galleries)==0;
    }
    
    function delete_collection()
    {
        $peer = new GalleryCollectionPeer();
        $collection = $peer->find_by_id(Params::get("id_gallery_collection"));
        
        $all_galleries = call("gallery","index",array("id_gallery_collection" => Params::get("id_gallery_collection")));
    
        foreach ($all_galleries as $gallery)
            call("gallery","delete_gallery",array("id_gallery" => $gallery->id_gallery));
        
        $d = new Dir(GalleryCollectionController::GALLERY_COLLECTION_ROOT_DIR.$collection->folder);
        $d->delete();
        
        $peer->delete($collection);
        
        if (is_html())
            return Redirect::success();
        else
            return Result::ok();
    }
    
    function modify_collection()
    {
        $peer = new GalleryCollectionPeer();
        $do = $peer->updateByParams();
        $peer->save($do);
        
        if (is_html())
            return Redirect::success();
        else
            return Result::ok();
    }
    
    function get_collection_by_key()
    {
        $peer = new GalleryCollectionPeer();
        $peer->key__EQUAL(Params::get("key"));

        $collection = $peer->find_single_result();
        
        return ActiveRecordUtils::toArray($collection);
    }
    
    function get_collection()
    {
        $peer = new GalleryCollectionPeer();
        $collection = $peer->find_by_id(Params::get("id_gallery_collection"));
        
        return ActiveRecordUtils::toArray($collection);
    }
}

?>