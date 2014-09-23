<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

require_once("include/constants/sessione.php.inc");


function fg_log_intrusion_blocked()
{
    //al momento non faccio nessun log
}

function fg_write_intrusion_blocked()
{
    echo ":)";
}


function fg_is_logged_in()
{
    if (   isset($_SESSION[FG_SESSION_LOGGED__KEY])
        && $_SESSION[FG_SESSION_LOGGED__KEY]=="true"
        && isset($_SESSION[FG_SESSION_USERNAME])
        && isset($_SESSION[FG_SESSION_SESSION_TYPE])
        )
        return true;
    else
        return false;
}

function fg_is_logged_in_admin()
{
    if (fg_is_logged_in())
    {
        $type = $_SESSION[FG_SESSION_SESSION_TYPE];
        if ($type==FG_SESSION_TYPE_ADMIN)
            return true;
    }
    return false;
}

function fg_is_logged_in_registered()
{
    if (fg_is_logged_in())
    {
        $type = $_SESSION[FG_SESSION_SESSION_TYPE];
        if ($type==FG_SESSION_TYPE_REGISTERED)
            return true;
    }
    return false;
}

function fg_is_logged_in_customer()
{
    if (fg_is_logged_in())
    {

        $type = $_SESSION[FG_SESSION_SESSION_TYPE];
        if ($type==FG_SESSION_TYPE_CUSTOMER)
            return true;
    }
    return false;
}

function fg_is_guest()
{
    if (!fg_is_logged_in()) return true;
    return false;
}

function fg_session_get_session_type_from_tipo_profilo($tipo_profilo)
{
    fg_ex_param_defined_not_empty($tipo_profilo, "Il tipo del profilo deve essere specificato.");

    switch ($tipo_profilo)
    {
        case FG_TIPO_PROFILO_ADMIN : return FG_SESSION_TYPE_ADMIN;
        case FG_TIPO_PROFILO_ESHOP : return FG_SESSION_TYPE_CUSTOMER;
        default : throw new Exception("Tipo di profilo non previsto per la sessione : ".$tipo_profilo);
    }

}

function fg_session_create($id_account,$username,$tipo_sessione)
{
    fg_ex_param_defined_not_empty_all("Errore nella creazione della sessione.",$id_account,$username,$tipo_sessione);

    //logged in, dato che la session di php e' usata anche per altre cose.
    $_SESSION[FG_SESSION_LOGGED__KEY] = "true";

    //tempo dell'ultima request, per la scadenza della sessione
    $_SESSION[FG_SESSION_LAST_REQUEST_TIME]=time();

    //id_account
    $_SESSION[FG_SESSION_ID_ACCOUNT] = $id_account;
    
    //username
    $_SESSION[FG_SESSION_USERNAME] = $username;

    //tipologia della sessione
    $_SESSION[FG_SESSION_SESSION_TYPE] = $tipo_sessione;

}

function fg_session_check_expiration()
{
    if (fg_is_logged_in())
    {
        $last_request = $_SESSION[FG_SESSION_LAST_REQUEST_TIME];

        if (time()-$last_request>FG_SESSION_EXPIRE_TIME_SECONDS)
        {
            global $fg_session_expired;
            $fg_session_expired = "true";
            fg_session_destroy();
        }
        else
        {
            $_SESSION[FG_SESSION_LAST_REQUEST_TIME]=time();
        }
    }
}

function fg_session_is_valid_or_write_expired()
{
    global $fg_session_expired;
    if ($fg_session_expired=="true")
    {
        include("include/errori/sessione_scaduta.php.inc");
        return false;
    }
    else
    {
        return true;
    }

}

function fg_session_destroy()
{
    session_unset();
    //session_destroy();
}

function fg_page_protect_registered()
{
    if (fg_session_is_valid_or_write_expired())
    {
        if (fg_is_logged_in_registered() || fg_is_logged_in_customer() || fg_is_logged_in_admin())
            return true;
        else
        {
            include("include/errori/pagina_protetta_registered.php.inc");
        }
    }
}

function fg_page_protect_customer()
{
    if (fg_session_is_valid_or_write_expired())
    {
        if (fg_is_logged_in_customer())
            return true;
        else
        {
            include("include/errori/pagina_protetta_customer.php.inc");
        }
    }
}

function fg_page_protect_admin()
{
    if (fg_session_is_valid_or_write_expired())
    {
        if (fg_is_logged_in_admin())
            return true;
        else
        {
            include("include/errori/pagina_protetta_admin.php.inc");
        }
    }
}

function fg_page_protect_logged_in()
{
    if (fg_session_is_valid_or_write_expired())
    {
        if (fg_is_logged_in())
            return true;
        else
        {
            include("include/errori/pagina_protetta.php.inc");
        }
    }
}



?>