<?php
/*
 * Con questa modalità di gestione delle cartelle, ci sono alcune cose più facili e altre più difficili :
 *
 * facili : query ( non ho bisogno di sapere l'id, mi basta il path )
 * difficili : rename, refactoring ( devo fare il rename di tutte le sotto cartelle, idem il move, mentre il move di un singolo file è MOLTO più semplice)
 *
 * Con la modalità a id e parent_folder invece
 *
 * facili : refactoring, rename : avviene automaticamente
 * difficili : query
 *
 * Funzionamento delle folders
 *
 * path
 * level
 * nome
 *
 * esempi di path :
 *
 * FINAL PATH = path + nome + /
 *
 * / => level=0 (numero delle cartelle sopra)
 * /immagini/ => level=1
 * /immagini/test/prova/ => level=3
 *
 * */
class FoldersController extends AbstractController
{
    function get()
    {
       $peer = new FolderPeer();

        if (Params::is_set("id"))
        {
            $result = ActiveRecordUtils::toArray($peer->find_by_id(Params::get("id")));

            return $result;
        }
        else
        {
            ActiveRecordUtils::updateFilters($peer);

            $results = $peer->find();

            if (count($results)==0)
                return null;
            else
                return ActiveRecordUtils::toArray($results[0]);
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

        return ActiveRecordUtils::toArray($all_results);
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
        $do->path = "";
        $do->nome = "";
        $do->ordine = 1;
        $do->level = 0;

        $peer->save($do);

        if (is_html())
            return Result::ok();
        else
            return ActiveRecordUtils::toArray($do);
                   
    }

    /*
     * Elimino una cartella : ed eliminazione di tutti i sotto_contenuti
     * */
    function delete()
    {
        $peer = new FolderPeer();
        $result = $peer->find_by_id(Params::get("id"));

        $path = $result["path"];
        $nome = $result["nome"];
        $full_path = $path . $nome . "/";

        $tipo = $result["tipo"];
        $tipo_tokens = explode("_",$tipo);
        $controller_name = $tipo_tokens[1];

        call($controller_name,"delete_by_path",array("path" => $full_path));

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