<?php

class FoldersController extends AbstractController
{
    function set_current()
    {
        $folder = $this->get();
        Session::set("/admin/current_folder/",$folder);

        if (is_html())
            return Redirect::success();
        else
            return Result::ok();
    }

    function get_current()
    {
        return Session::get("/admin/current_folder/");
    }
    
    /*
     * Ritorna una singola cartella in base ai parametri passati
     */

    static function load_attributes($result)
    {
        $folder_attribs_peer = new FolderAttribsPeer();
        $folder_attribs_peer->id_folder__EQUALS($result["id"]);
        $attribs = $folder_attribs_peer->find();

        $result["attributes"] = array();
        foreach ($attribs as $attr)
        {
            $attribute_peer = __create_instance(StringUtils::underscored_to_camel_case($attr->attrib_name."_peer"));
            $attribute_ob = $attribute_peer->find_by_id($attr->attrib_pk);

            if (!isset($result["attributes"][$attr->attrib_name]))
                $result["attributes"][$attr->attrib_name] = array();

            $result["attributes"][$attr->attrib_name][] = ActiveRecordUtils::toArray($attribute_ob);

        }

        return $result;
    }

    static function delete_attributes($result)
    {
        $folder_attribs_peer = new FolderAttribsPeer();
        $folder_attribs_peer->id_folder__EQUALS($result["id"]);
        $attribs = $folder_attribs_peer->find();
        foreach ($attribs as $attr)
            $folder_attribs_peer->delete($attr);
    }

    function get()
    {
       $peer = new FolderPeer();

        if (Params::is_set("id"))
        {
            $result = ActiveRecordUtils::toArray($peer->find_by_id(Params::get("id")));

            return self::load_attributes($result);
        }
        else
        {
            ActiveRecordUtils::updateFilters($peer);

            $results = $peer->find();

            if (count($results)==0)
                return null;
            else
                return self::load_attributes(ActiveRecordUtils::toArray($results[0]));
        }
    }

    /*
     * Elenca tutte le cartelle utilizzando i filtri specificati.
     */
    
    function index()
    {
        $peer = new FolderPeer();

        ActiveRecordUtils::updateFilters($peer);
        $all_results = $peer->find();

        $all_results_array = ActiveRecordUtils::toArray($all_results);
        $final_result = array();
        foreach ($all_results_array as $res)
        {
            $final_result[] = self::load_attributes($res);
        }
        return $final_result;
    }

    /*
     * Modifica il nome della cartella.
     */
    
    function modify()
    {
        $peer = new FolderPeer();

        $do = $peer->updateByParams();

        $peer->save($do);
        
        if (is_html())
        {
            Flash::ok("Cartella modificata con successo.");
            return Redirect::success();
        }
    }

    /*
     * Creo una nuova cartella
     */
    
    function create()
    {
        $peer = new FolderPeer();

        $do = $peer->new_do();

        $peer->setupByParams($do);

        $peer->save($do);

        if (is_html())
        {
            Flash::ok("Cartella creata con successo.");
            return Redirect::success();
        }
        else
            return ActiveRecordUtils::toArray($do);

    }

    function create_root()
    {
        $peer = new FolderPeer();

        $do = $peer->new_do();

        $peer->setupByParams($do);
        $do->id_parent_folder = null;

        $peer->save($do);

        if (is_html())
            return Result::ok();
        else
            return ActiveRecordUtils::toArray($do);
                   
    }

    /*
     * Elimino una cartella : da aggiungere la possibilita' di eliminare tutto il contenuto della cartella e le sottocartelle
     * ed eventualmente anche i contenuti associati.
     * */
    function delete()
    {
        $peer = new FolderPeer();
        $result = $peer->find_by_id(Params::get("id"));
        self::delete_attributes($result);
        $peer->delete($result);

        if (is_html())
        {
            Flash::ok("Cartella eliminata con successo.");
            return Redirect::success();
        }
        else
        {
            return Result::ok();
        }
    }

}

?>