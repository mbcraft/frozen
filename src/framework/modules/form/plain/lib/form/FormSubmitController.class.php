<?
/* This software is released under the BSD license. Full text at project root -> license.txt */

class FormSubmitController extends AbstractController
{
    function invia_prenotazione()
    {
        try
        {
            $nome_cognome = Params::get("nome_cognome");
            $subject = Params::get("subject");
            $email = Params::get("email");
            $telefono = Params::get("telefono");
            $richiesta = Params::get("richiesta");
            
            //$codice_hidden = Params::get("codice_hidden");
            //$codice = Params::get("codice");

            //if ($codice_hidden!=$codice)
            //    throw new InvalidParameterException("Il codice non e' impostato correttamente!!");

            if ($nome_cognome!=null && $subject!=null && $telefono!=null && $richiesta!=null /*&& $codice!=null*/ && isset(Config::instance()->EMAIL_BOOKING_RECEIVED))
            {
                $e = new EMail("no_reply@".Host::current_no_www(),Config::instance()->EMAIL_BOOKING_RECEIVED,"[Nuova prenotazione da : ".$nome_cognome."] - ".Host::current(),EMail::HTML_FORMAT);
                $e->render_and_send("include/messages/mail/alert/".Lang::current()."/nuova_prenotazione.php.inc",array("nome_cognome" => $nome_cognome,"telefono" => $telefono,"email" => $email,"subject" => $subject,"richiesta" => $richiesta));
                return Redirect::success();
            }
            else
            {
                if (!isset(Config::instance()->EMAIL_BOOKING_RECEIVED))
                    throw new InvalidDataException("Il parametri di configurazione EMAIL_BOOKING_RECEIVED non e' impostato correttamente!!");
                else
                    throw new InvalidDataException("I dati immessi nella form non sono validi!!");
            }
        }
        catch (Exception $ex)
        {
            Flash::error($ex->getMessage());
            return Redirect::failure();
        }
    }
    
    
    function invia_commento()
    {
        try
        {
            $nome = Params::get("nome");
            $subject = Params::get("subject");
            $email = Params::get("email");
            $testo = Params::get("testo");
            
            //$codice_hidden = Params::get("codice_hidden");
            //$codice = Params::get("codice");

            //if ($codice_hidden!=$codice)
            //    throw new InvalidParameterException("Il codice non e' impostato correttamente!!");

            if ($nome!=null && $subject!=null && $email!=null && $testo!=null /*&& $codice!=null*/ && isset(Config::instance()->EMAIL_COMMENT_RECEIVED))
            {
                $e = new EMail("no_reply@".Host::current_no_www(),Config::instance()->EMAIL_COMMENT_RECEIVED,"[Nuova commento da : ".$nome."] - ".Host::current(),EMail::HTML_FORMAT);
                $e->render_and_send("include/messages/mail/alert/".Lang::current()."/nuovo_commento.php.inc",array("nome" => $nome,"email" => $email,"subject" => $subject,"testo" => $testo));
                return Redirect::success();
            }
            else
            {
                if (!isset(Config::instance()->EMAIL_COMMENT_RECEIVED))
                    throw new InvalidDataException("Il parametri di configurazione EMAIL_COMMENT_RECEIVED non e' impostato correttamente!!");
                else
                    throw new InvalidDataException("I dati immessi nella form non sono validi!!");
            }
        }
        catch (Exception $ex)
        {
            Flash::error($ex->getMessage());
            return Redirect::failure();
        }
    }
    
    function is_booking_successfull()
    {
        return Params::get("success") == "true" ? true : false;
    }

    function is_comment_successfull()
    {
        return Params::get("success") == "true" ? true : false;
    }
}

?>