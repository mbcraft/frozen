<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */


/*
 * Aggiungere il supporto per l'upload di file multiplo.
 * */
class Upload
{
    static function isUpload($form_field_name)
    {
        return isset($_FILES[$form_field_name]);
    }

    static function getUploadedTmpPath($form_field_name)
    {
        return $_FILES[$form_field_name]['tmp_name'];
    }

    static function getRealFilename($form_field_name)
    {
        return $_FILES[$form_field_name]['name'];
    }

    static function isUploadSuccessful($form_field_name)
    {
        return $_FILES[$form_field_name]["error"]===UPLOAD_ERR_OK;
    }

    static function getUploadError($form_field_name)
    {
        $error_code = $_FILES[$form_field_name]["error"];

        switch ($error_code) {
        case UPLOAD_ERR_INI_SIZE:
                return 'La dimensione del file supera quella consentita dalla configurazione nel php.ini.';
            case UPLOAD_ERR_FORM_SIZE:
                return 'La dimensione del file supera quella consentita dalla form html (MAX_FILE_SIZE).';
            case UPLOAD_ERR_PARTIAL:
                return 'Il file &egrave; stato solo parzialmente caricato.';
            case UPLOAD_ERR_NO_FILE:
                return 'Nessun file caricato.';
            case UPLOAD_ERR_NO_TMP_DIR:
                return 'Directory temporanea per il salvataggio dei file non presente.';
            case UPLOAD_ERR_CANT_WRITE:
                return 'Impossibile scrivere su disco. Controllare i permessi delle cartelle e lo spazio disponibile.';
            case UPLOAD_ERR_EXTENSION:
                return 'Upload bloccato da un\'estensione php.';
            default:
                return 'Errore di upload sconosciuto.';
        }
    }

    static function saveTo($form_field_name,$dir,$filename=null)
    {
        if ($dir instanceof Dir)
            $final_dir = $dir;
        else
            $final_dir = new Dir($dir);
        
        $tmp_path = self::getUploadedTmpPath($form_field_name);
        if ($filename==null)
            $real_filename = self::getRealFilename($form_field_name);
        else
            $real_filename = $filename;

        $final_file = $final_dir->newFile($real_filename);

        $result = move_uploaded_file($tmp_path, $final_file->getFullPath());

        if ($result==true)
            return $final_file;
        else
            return null;
    }

    static function getUploadedTmpFile($form_field_name)
    {
        return new File(self::getUploadedTmpPath($form_field_name));
    }

    static function deleteUploadedTmpFile($form_field_name)
    {
        $f = new File(self::getUploadedTmpPath($form_field_name));
        return $f->delete();
    }

}

?>