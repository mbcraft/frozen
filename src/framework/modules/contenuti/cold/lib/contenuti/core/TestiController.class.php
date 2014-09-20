<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

/*
 * Per le gallery serve, oltre a una descrizione, una descrizione sommaria nelle foto.
 * Per ovviare a questo inconveniente si può adottare questa soluzione :
 *
 * A monte, una gestione di file e cartelle fatta col classico "files & folders", nella quale è possibile la gestione
 * dei file.
 *
 * A valle, una gestione delle gallery tramite database per inserire effetti, descrizioni e quant'altro.
 * Ovviamente in futuro la gestione delle cartelle terrà conto dei permessi.
 * E' inoltre possibile visualizzare una gallery anche senza mapping sul db, con dei ragionevoli default.
 * */

class TestiController extends AbstractController
{
    function delete()
    {
        $peer = new TestiPeer();
        
        $peer->delete_by_id(Params::get("id"));

        if (is_html())
        {
            Flash::ok("Contenuto testuale eliminato con successo!!");
            return Redirect::success();
        }
        else
            return Result::ok();
    }

    function modify()
    {
        $peer = new TestiPeer();
        
        $do = $peer->updateByParams();
        
        $peer->save($do);

        return Redirect::success();
    }
    
    function create()
    {
        $peer = new TestiPeer();
        
        $do = $peer->new_do();
        
        $peer->setupByParams($do);

        $peer->save($do);

        if (is_html())
            return Redirect::success();
        else
            return Result::ok();
    }

    function by_chiave()
    {
        $chiave = Params::get("chiave");

        $peer = new TestiPeer();

        $peer->chiave__EQUALS($chiave);
        $results = $peer->find();
            if (count($results)>0)
                $do = $results[0];
            else
                $do = null;

        return ActiveRecordUtils::toArray($do);

    }

    function get()
    {
        $peer = new TestiPeer();

        if (Params::is_set("id"))
        {
            $do = $peer->find_by_id(Params::get("id"));
        }
        else
        {
            ActiveRecordUtils::updateFilters($peer);
            $results = $peer->find();
            if (count($results)>0)
                $do = $results[0];
            else
                $do = null;
        }
        
        return ActiveRecordUtils::toArray($do);
    }
    
    function count()
    {
        $peer = new TestiPeer();

        ActiveRecordUtils::updateFilters($peer);
        $num_contents = $peer->count("*");
        
        return array("count" => $num_contents);
    }
        
    function index()
    {        
        $peer = new TestiPeer();
        
        ActiveRecordUtils::updateFilters($peer);
        $all_results = $peer->find();
        
        return ActiveRecordUtils::toArray($all_results);
    }

    function export()
    {
        $peer = new TestiPeer();
        $import_export = DB::newTableDataImportExport();
        $export_data = $import_export->export_data($peer->__getMyTable());
        return $export_data;
    }

    function import()
    {
        $data = Params::get("import_data");

        $peer = new TestiPeer();
        $import_export = DB::newTableDataImportExport();
        $import_export->import_data($data);

        if (is_html())
        {
            return Redirect::success();
        }
        else
            return Result::ok();
    }

    function new_empty()
    {
        $peer = new TestiPeer();
        return ActiveRecordUtils::toArray($peer->new_do());
    }
}
?>