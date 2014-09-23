<?
/* This software is released under the BSD license. Full text at project root -> license.txt */

class DocumentiController extends AbstractKeyedFolderEntityController
{
    function __myPeer()
    {
        return new DocumentiPeer();
    }

    function __saveFolderPath()
    {
        return "/documenti/user/".Session::get("/session/username");
    }

    function __createMessage()
    {
        return "Documento caricato con successo!!";
    }

    function __modifyMessage()
    {
        return "Documento modificato con successo!!";
    }

    function __deleteMessage()
    {
        return "Documento eliminato con successo!!";
    }

    function __additionalCreateLogic($do)
    {
        $this->__saveAttachedFile($do);
    }

    function __additionalDeleteLogic($do)
    {
        $this->__deleteAttachedFile($do);
    }

    function __uploadMaxFilesize()
    {
        return 8388608*4;
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