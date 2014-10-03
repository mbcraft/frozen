<?php

/* This software is released under the BSD license. Full text at project root -> license.txt */

function validate($validator,$value,$param_description=null)
{
    $params = array();
    if (is_array($value))
        $params = $value;
    else
        $params[$validator] = $value;
    if ($param_description!==null)
        $params["nome_parametro"] = $param_description;
    $result = call("validation",$validator,$params);
    Flash::updateFromResult($result);
    return Result::is_ok($result);
}

class ValidationController extends AbstractController
{
    function ragione_sociale()
    {
        $ragione_sociale = Params::get("ragione_sociale");
        if (strlen($ragione_sociale)<5)
        {
            return Result::error("La ragione sociale deve essere lunga almeno 5 caratteri.");
        }
        return Result::ok();
    }

    function partita_iva()
    {
        $partita_iva = Params::get("partita_iva");
        
        if( strlen($partita_iva) != 11 )
        return Result::error("La lunghezza della partita IVA non &egrave; "
        ."corretta: la partita IVA dovrebbe essere lunga "
        ."esattamente 11 caratteri.");
        if( ! preg_match("/^[0-9]+$/", $partita_iva) )
            return Result::error("La partita IVA contiene dei caratteri non ammessi: "
        ."la partita IVA dovrebbe contenere solo cifre.");
        $s = 0;
        for( $i = 0; $i <= 9; $i += 2 )
        $s += ord($partita_iva[$i]) - ord('0');
        for( $i = 1; $i <= 9; $i += 2 ){
        $c = 2*( ord($partita_iva[$i]) - ord('0') );
        if( $c > 9 )  $c = $c - 9;
        $s += $c;
        }
        if( ( 10 - $s%10 )%10 != ord($partita_iva[10]) - ord('0') )
            return Result::error("La partita IVA non &egrave; valida: il codice di controllo non corrisponde.");
        return Result::ok();
    }

    function codice_fiscale()
    {
        $codice_fiscale = Params::get("codice_fiscale");
        if( strlen($codice_fiscale) != 16 )
            return Result::error("La lunghezza del codice fiscale non &egrave; "
            ."corretta: il codice fiscale dovrebbe essere lungo "
            ."esattamente 16 caratteri.");

        $codice_fiscale = strtoupper($codice_fiscale);
        if( ! preg_match("/^[A-Z0-9]+$/", $codice_fiscale) ){
        return Result::error("Il codice fiscale contiene dei caratteri non validi: "
        ."i soli caratteri validi sono le lettere e le cifre.");
        }
        $s = 0;

        for( $i = 1; $i <= 13; $i += 2 )
        {
            $c = $codice_fiscale[$i];
        if( '0' <= $c && $c <= '9' )
            $s += ord($c) - ord('0');
        else
            $s += ord($c) - ord('A');
        }
        for( $i = 0; $i <= 14; $i += 2 )
        {
            $c = $codice_fiscale[$i];
            switch( $c )
            {
                case '0':  $s += 1;  break;
                case '1':  $s += 0;  break;
                case '2':  $s += 5;  break;
                case '3':  $s += 7;  break;
                case '4':  $s += 9;  break;
                case '5':  $s += 13;  break;
                case '6':  $s += 15;  break;
                case '7':  $s += 17;  break;
                case '8':  $s += 19;  break;
                case '9':  $s += 21;  break;
                case 'A':  $s += 1;  break;
                case 'B':  $s += 0;  break;
                case 'C':  $s += 5;  break;
                case 'D':  $s += 7;  break;
                case 'E':  $s += 9;  break;
                case 'F':  $s += 13;  break;
                case 'G':  $s += 15;  break;
                case 'H':  $s += 17;  break;
                case 'I':  $s += 19;  break;
                case 'J':  $s += 21;  break;
                case 'K':  $s += 2;  break;
                case 'L':  $s += 4;  break;
                case 'M':  $s += 18;  break;
                case 'N':  $s += 20;  break;
                case 'O':  $s += 11;  break;
                case 'P':  $s += 3;  break;
                case 'Q':  $s += 6;  break;
                case 'R':  $s += 8;  break;
                case 'S':  $s += 12;  break;
                case 'T':  $s += 14;  break;
                case 'U':  $s += 16;  break;
                case 'V':  $s += 10;  break;
                case 'W':  $s += 22;  break;
                case 'X':  $s += 25;  break;
                case 'Y':  $s += 24;  break;
                case 'Z':  $s += 23;  break;
            }
        }
        if( chr($s%26 + ord('A')) != $codice_fiscale[15] )
            return Result::error("Il codice fiscale non &egrave; corretto: il codice di controllo non corrisponde.");
        return Result::ok();
    }

    function nome()
    {
        $nome = Params::get("nome");
        if (strlen($nome)<2)
        {
          return Result::error("Il nome deve essere lungo almeno 2 caratteri.");
        }
        return Result::ok();
    }

    function cognome()
    {
        $cognome = Params::get("cognome");
        if (strlen($cognome)<2)
        {
            return Result::error("Il cognome deve essere lungo almeno 2 caratteri.");
        }
        return Result::ok();
    }

    function data()
    {
        $data = Params::get("data");
        $nome_parametro = Params::get("nome_parametro");

        if (!preg_match("/\d\d[-\/]\d\d[-\/]\d\d\d\d/",$data))
        {
            return Result::error("La ".$nome_parametro." non &egrave; nel formato gg-mm-aaaa.");
        }
        return Result::ok();
    }

    function citta()
    {
        $citta = Params::get("citta");
        $nome_parametro = Params::is_set("nome_parametro") ? Params::get("nome_parametro") : "citt&agrave;";
        if (strlen($citta)<2)
        {
            return Result::error("La ".$nome_parametro." inserita deve essere lunga almeno 2 caratteri.");
        }
        return Result::ok();
    }

    function indirizzo()
    {
        $indirizzo = Params::get("indirizzo");
        $nome_parametro = Params::is_set("nome_parametro") ? Params::get("nome_parametro") : "indirizzo";
        if (strlen($indirizzo)<2)
        {
            return Result::error("L'".$nome_parametro." deve essere lungo almeno 2 caratteri.");
        }
        return Result::ok();
    }

    function email()
    {
        $email = Params::get("email");
        if (EMail::is_valid($email))
        {
            $peer = new AccountPeer();
            $accounts = $peer->find_all_by_email($email);
            if (count($accounts)>0)
                return Result::error("La mail specificata (".$email.") &egrave; gi&agrave; in uso!! Utilizza un altro indirizzo email!!");
            return Result::ok();
        }
        else
            return Result::error("La mail inserita non &egrave; valida!!");
    }

    function conferma_email()
    {
        $email = Params::get("email");
        $conferma_email = Params::get("conferma_email");
        if ($email!==$conferma_email)
            return Result::error("Le mail inserite non coincidono!!");
        else
            return Result::ok();
    }

    function username()
    {
        $username = Params::get("username");
        if (strlen($username)<6 || strlen($username)>32)
        {
            return Result::error("Lo username deve essere compreso tra 6 e 32 caratteri!!");
        }
        $peer = new AccountPeer();
        $peer->username__EQUALS($username);
        $num_found = $peer->count("*");
        if ($num_found>0)
            return Result::error("Siamo spiacenti, lo username scelto &egrave; gi&agrave; in uso!!");
        else
            return Result::ok();
    }

    function password()
    {
        $password = Params::get("password");
        if (strlen($password)<8 || strlen($password)>36)
            return Result::error("La password deve essere compresa tra 8 e 36 caratteri!!");
        else
            return Result::ok();
    }

    function conferma_password()
    {
        $password = Params::get("password");
        $conferma_password = Params::get("conferma_password");
        if ($password!=$conferma_password)
            return Result::error("Le password inserite non coincidono!!");
        else
            return Result::ok();
            
    }

    function fax()
    {
        $fax = Params::get("fax");
        if (strlen($fax)>0 && strlen($fax)<6)
        {
            return Result::error("Il numero di fax non &egrave; valido. Inserire un numero valido o lasciare vuoto.");
        }
        return Result::ok();
    }

    function cap()
    {
        $cap = Params::get("cap");
        $nome_parametro = Params::is_set("nome_parametro") ? Params::get("nome_parametro") : "cap";
        $result = preg_match("/^[0-9][0-9][0-9][0-9][0-9]$/", $cap);
        if (strlen($cap)!=5 || !$result)
        {
            return Result::error("Il ".$nome_parametro." inserito non &egrave; valido. Deve essere un numero di 5 cifre.");
        }
        return Result::ok();
    }

    function telefono()
    {
        $telefono = Params::get("telefono");
        $nome_parametro = Params::is_set("nome_parametro") ? Params::get("nome_parametro") : "recapito telefonico";
        if (strlen($telefono)<6)
        {
            return Result::error("Il ".$nome_parametro." deve essere lungo almeno 6 caratteri.");
        }
        return Result::ok();
    }

    function accept()
    {
        $accepted = Params::get("accept");
        $nome_parametro = Params::is_set("nome_parametro") ? Params::get("nome_parametro") : "[IMPOSTA IL NOME DELLA CHECKBOX OBBLIGATORIA]";

        if ($accepted!=="accept")
        {
            return Result::error("&Egrave; necessario accettare ".$nome_parametro.".");
        }
        return Result::ok();
    }

    function captcha()
    {
        $c = new Captcha();
        if ($c->isValid())
            return Result::ok();
        else
            return Result::error("Il codice captcha inserito non &egrave; valido.");
    }

    function min_max()
    {
        $min = Params::get("min");
        $max = Params::get("max");

        $value = Params::get("value");

        $nome_parametro = Params::get("nome_parametro");
        if ($value < $min || $value >= $max)
        {
            return Result::error($nome_parametro." deve essere compreso tra ".$min."");
        }
    }

}

?>