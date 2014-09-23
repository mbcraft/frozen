<?
/* This software is released under the BSD license. Full text at project root -> license.txt */

class ImmaginiController extends AbstractController
{
    function get()
    {
        $peer = new ImmaginiPeer();

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
        $num_elements = $peer->count("*");

        return array("count" => $num_elements);
    }

    function new_empty()
    {
        $peer = new ImmaginiPeer();
        return ActiveRecordUtils::toArray($peer->new_do());
    }

    function add()
    {
        if (Upload::isUploadSuccessful("my_file"))
        {
            $peer = new ImmaginiPeer();

            $do = $peer->new_do();

            $peer->setupByParams($do);
            $d = new Dir("/immagini/user/".Session::get("/session/username").Params::get("folder"));
            if (!$d->exists()) $d->touch();
            $do->save_folder = $d->getPath();
            $do->real_name = Upload::getRealFilename("my_file");
            $do->folder = Params::get("folder");

            $tokens = explode(".",Upload::getRealFilename("my_file"));

            $extension = $tokens[count($tokens)-1];

            $do->hash_name = md5(uniqid()).".".strtolower($extension);
            Upload::saveTo("my_file",$do->save_folder,$do->hash_name);

            $peer->save($do);
            
            if (is_html())
            {
            
                Flash::ok("Immagine aggiunta con successo.");
                return Redirect::success();
            } else
            {
                return ActiveRecordUtils::toArray($do);
            }
        }
        else
        {
            Flash::error(Upload::getUploadError("my_file"));
            return Redirect::failure();
        }
    }

    function modify()
    {
        $peer = new ImmaginiPeer();

        $do = $peer->find_by_id(Params::get("image_id"));

        $peer->setupByParams($do);

        $peer->save($do);

        Flash::ok("Immagine modificata con successo.");
        return Redirect::success();
    }

    function delete()
    {
        $peer = new ImmaginiPeer();

        $do = $peer->find_by_id(Params::get("id"));

        $final_path = $do->save_folder.$do->hash_name;
        $f = new File($final_path);
        $f->delete();

        $peer->delete($do);
        if (is_html())
        {
            Flash::ok("Immagine eliminata con successo.");
            return Redirect::success();
        }
        else
            return Result::ok();
    }

    function index()
    {
        $peer = new ImmaginiPeer();

        ActiveRecordUtils::updateFilters($peer);
        
        return ActiveRecordUtils::toArray($peer->find());
    }

}

?>