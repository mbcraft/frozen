<?
/* This software is released under the BSD license. Full text at project root -> license.txt */

class ImmaginiController extends AbstractKeyedFolderEntityController
{
    function __myPeer()
    {
        return new ImmaginiPeer();
    }

    function __saveFolderPath()
    {
        return "/immagini/user/".Session::get("/session/username");
    }

    function __createMessage()
    {
        return "Immagine caricata con successo!!";
    }

    function __modifyMessage()
    {
        return "Immagine modificata con successo!!";
    }

    function __deleteMessage()
    {
        return "Immagine eliminata con successo!!";
    }

    function __additionalCreateLogic($do)
    {
        $this->__saveAttachedFile($do);
    }

    function __additionalDeleteLogic($do)
    {
        $this->__deleteAttachedFile($do);
    }

    function __createErrors()
    {
        if (Upload::isUploadSuccessful("my_file"))
            return null;
        else
            return Upload::getUploadError("my_file");

    }
}

?>