<?
/* This software is released under the BSD license. Full text at project root -> license.txt */

abstract class AbstractKeyedFolderEntityController extends AbstractEntityController
{
    abstract function __saveFolderPath();
    function __uploadMaxFilesize() { return null; }

    function __saveAttachedFile($do)
    {
        if ($this->__uploadMaxFilesize()!=null)
            ini_set('upload_max_filesize', $this->__uploadMaxFilesize());
        $d = new Dir($this->__saveFolderPath());
        if (!$d->exists()) $d->touch();
        $do->save_folder = $d->getPath();
        $do->real_name = Upload::getRealFilename("my_file");

        $tokens = explode(".",Upload::getRealFilename("my_file"));

        $extension = $tokens[count($tokens)-1];

        $do->hash_name = md5(uniqid()).".".strtolower($extension);
        Upload::saveTo("my_file",$do->save_folder,$do->hash_name);
    }

    function __deleteAttachedFile($do)
    {
        $final_path = $do->save_folder.$do->hash_name;
        $f = new File($final_path);
        $f->delete();
    }

    function delete_by_path()
    {
        $path = Params::get("path");

        $peer = $this->__myPeer();
        $peer->path__EQUAL($path);
        $all_elems = $peer->find();

        foreach ($all_elems as $elem)
            $peer->delete($elem);
    }

    function by_chiave()
    {
        $chiave = Params::get("chiave");

        $peer = $this->__myPeer();

        $peer->chiave__EQUAL($chiave);
        $results = $peer->find();
            if (count($results)>0)
                $do = $results[0];
            else
                $do = null;

        return ActiveRecordUtils::toArray($do);
    }

}


?>