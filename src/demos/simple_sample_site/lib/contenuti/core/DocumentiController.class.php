<?

class DocumentiController extends AbstractController
{
    function load_root_as_current()
    {
        $folder = Session::get("/admin/root_folder_documenti");
        call("folders","set_current",$folder);

        if (is_html())
            return Redirect::success();
        else
            return Result::ok();
    }
    
    function get()
    {
        $peer = new DocumentiPeer();

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
        $peer = new DocumentiPeer();

        ActiveRecordUtils::updateFilters($peer);
        $num_elements = $peer->count("*");

        return array("count" => $num_elements);
    }

    function new_empty()
    {
        $peer = new DocumentiPeer();
        return ActiveRecordUtils::toArray($peer->new_do());
    }

    function add()
    {
        ini_set('upload_max_filesize', 8388608*4);
        if (Upload::isUploadSuccessful("my_file"))
        {
            $peer = new DocumentiPeer();

            $do = $peer->new_do();

            $peer->setupByParams($do);
            $d = new Dir("/documenti/user/".Session::get("/session/username")."/contenuti/");
            if (!$d->exists()) $d->touch();
            $do->save_folder = $d->getPath();
            $do->real_name = Upload::getRealFilename("my_file");
            $tokens = explode(".",Upload::getRealFilename("my_file"));

            $extension = $tokens[count($tokens)-1];

            $do->hash_name = md5(uniqid()).".".strtolower($extension);
            Upload::saveTo("my_file",$do->save_folder,$do->hash_name);

            $peer->save($do);

            Flash::ok("Documento aggiunto con successo.");
            return Redirect::success();
        }
        else
            return Redirect::failure(Upload::getUploadError("my_file"));
    }

    function modify()
    {
        $peer = new DocumentiPeer();

        $do = $peer->updateByParams();

        $peer->save($do);

        Flash::ok("Documento modificato con successo.");
        
        return Redirect::success();
    }

    function delete()
    {
        $peer = new DocumentiPeer();

        $do = $peer->find_by_id(Params::get("id"));

        $final_path = $do->save_folder.$do->hash_name;
        $f = new File($final_path);
        $f->delete();

        $peer->delete($do);

        if (is_html())
        {
            Flash::ok("Documento eliminato con successo.");
            return Redirect::success();
        }
        else
            return Result::ok();
    }

    function index()
    {
        $peer = new DocumentiPeer();

        ActiveRecordUtils::updateFilters($peer);

        return ActiveRecordUtils::toArray($peer->find());
    }
}

?>