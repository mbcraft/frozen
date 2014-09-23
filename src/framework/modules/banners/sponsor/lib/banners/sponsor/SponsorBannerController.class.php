<?
/* This software is released under the BSD license. Full text at project root -> license.txt */

class SponsorBannerController extends AbstractController
{
    /*
     * Elenco dei banner
     */
    function index_banner_group()
    {
        $peer = new BannerGroupPeer();
        $results = $peer->find_all();
        return ActiveRecordUtils::toArray($results);
        
    }
    
    function new_empty_banner_group()
    {
        $peer = new BannerGroupPeer();
        $do = $peer->new_do();
        $do->name = "";
        return ActiveRecordUtils::toArray($do);
    }
    
    /*
     * Nuovo gruppo di banner
     */
    function new_banner_group()
    {
        $peer = new BannerGroupPeer();
        $do = $peer->new_do();
        $peer->setupByParams($do);
        $peer->save($do);
        
        
        return Redirect::success();
        
    }
    
    function get_banner_group()
    {
        $peer = new BannerGroupPeer();
        $banner_group = $peer->find_by_id(Params::get("id_banner_group"));
        return ActiveRecordUtils::toArray($banner_group);
    }
    
    function get_banner_group_by_name()
    {
        $peer = new BannerGroupPeer();
        $peer->name__EQUAL(Params::get("name"));
        $banner_group = $peer->find_single_result();
        return ActiveRecordUtils::toArray($banner_group);
    }
    
    /*
     * Salva gruppo di banner
     */
    function save_banner_group()
    {
        $peer = new BannerGroupPeer();
        $do = $peer->updateByParams();
        $peer->save($do);
        
        return Redirect::success();
    }
    
    function delete_banner_group()
    {
        
        $peer = new BannerPeer();
        $peer->id_banner_group__EQUAL(Params::get("id_banner_group"));
        $all_banners = $peer->find();
        
        foreach ($all_banners as $banner)
        {
            call("sponsor_banner","delete_banner",array("id_banner" => $banner->id_banner));
        }

        $peer_group = new BannerGroupPeer();
        $peer_group->delete_by_id(Params::get("id_banner_group"));

        if (is_html())
        {
            Flash::ok("Contenuto testuale eliminato con successo!!");
            return Redirect::success();
        }
        else
            return Result::ok();
    }
    
    function index_banner()
    {
        $peer = new BannerPeer();
        ActiveRecordUtils::updateFilters($peer);
        $banners = $peer->find();
        return ActiveRecordUtils::toArray($banners);
    }
    
    function new_empty_banner()
    {
        $peer = new BannerPeer();
        $do = $peer->new_do();
        $peer->setupByParams($do);
        return ActiveRecordUtils::toArray($do);
    }
    
    function get_banner()
    {
        $peer = new BannerPeer();
        $banner = $peer->find_by_id(Params::get("id_banner"));
        return ActiveRecordUtils::toArray($banner);
    }
    
    function add_banner()
    {
        $peer = new BannerPeer();
        
        $banner = $peer->new_do();

        $params = Params::all();
        
        $immagine = call("immagini","add",$params);
        
        $peer->setupByParams($banner);
        $banner->id_immagine = $immagine["id"];
        
        $peer->save($banner);
        

        Flash::ok("Banner aggiunto con successo!!");
        return Redirect::success();

    }
    
    function delete_banner()
    {
        $peer = new BannerPeer();
        
        $banner = $peer->find_by_id(Params::get("id_banner"));

        call("immagini","delete",array("id" => $banner->id_immagine));
        $peer->delete_by_id($banner->id_banner);
        

        Flash::ok("Banner eliminato con successo!!");
        return Redirect::success();

    }
    
    function save_banner()
    {
        $peer = new BannerPeer();
        
        $banner = $peer->updateByParams();
        
        call("immagini","modify",Params::all());
        
        $peer->save($banner);
        
        return Redirect::success();
    }
}

?>