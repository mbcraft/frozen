<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

class Flash extends BasicObject
{
    const FLASH_CSS_PATH = "/framework/core/css/flash.css";
    
    const FLASH_FORM_PARAMS_KEY = "form_params";

    const FLASH_OK_MESSAGES_KEY = "ok_messages";
    const FLASH_WARNING_MESSAGES_KEY = "warning_messages";
    const FLASH_ERROR_MESSAGES_KEY = "error_messages";

    const SESSION_FLASH_KEY = "__flash_vars";
    

    private static $keep_messages = false;

    public static $current = null;
    public static $next = null;

    private $my_vars=array();

    public static function clean()
    {
        self::$current = new Flash();
        self::$next = new Flash();
    }
    /*
     * Carico le flash vars dalla sessione. Quelle che erano le 'next' diventano così le 'current'.
     */
    public static function __load_from_session()
    {
        $f = new Flash();
        if (Session::is_set(self::SESSION_FLASH_KEY))
            $f->my_vars = Session::get(self::SESSION_FLASH_KEY);

        self::$current = $f;

        self::$next = new Flash();
    }

  /*
     * Salvo le flash vars 'next' in sessione, che diventeranno le 'current' alla prossima richiesta.
     */
    public static function __save_to_session()
    {
        if (self::$keep_messages)
            $vars = self::$current->my_vars;
        else
            $vars = self::$next->my_vars;

        Session::set(self::SESSION_FLASH_KEY, $vars);
    }

    private static function push_key_value($section,$key,$value)
    {
        if (!isset(self::$current->my_vars[$section])) self::$current->my_vars[$section] = array();
        self::$current->my_vars[$section][$key] = $value;

        if (!isset(self::$next->my_vars[$section])) self::$next->my_vars[$section] = array();
        self::$next->my_vars[$section][$key] = $value;
    }

    private static function push_elem($section,$elem)
    {
        CSS::require_css(Flash::FLASH_CSS_PATH);
        
        if (!isset(self::$current->my_vars[$section])) self::$current->my_vars[$section] = array();
        self::$current->my_vars[$section][] = $elem;

        if (!isset(self::$next->my_vars[$section])) self::$next->my_vars[$section] = array();
        self::$next->my_vars[$section][] = $elem;
    }
    
    /*
     * Funzioni di scrittura
     */
    
    public static function ok($message)
    {
        self::push_elem(self::FLASH_OK_MESSAGES_KEY, $message);
    }
    
    public static function warning($message)
    {
        self::push_elem(self::FLASH_WARNING_MESSAGES_KEY, $message);
    }

    public static function error($message)
    {
        self::push_elem(self::FLASH_ERROR_MESSAGES_KEY, $message);
    }
    
    /*
     * Funzioni di controllo
     */
    
    public static function has_oks()
    {
        if (isset(self::$current->my_vars[self::FLASH_OK_MESSAGES_KEY]))
        {
            return count(self::$current->my_vars[self::FLASH_OK_MESSAGES_KEY])>0;
        }
        else
        {
            return false;
        } 
    }

    public static function has_warnings()
    {
        if (isset(self::$current->my_vars[self::FLASH_WARNING_MESSAGES_KEY]))
        {
            return count(self::$current->my_vars[self::FLASH_WARNING_MESSAGES_KEY])>0;
        }
        else
        {
            return false;
        } 
    }

    public static function has_errors()
    {
        if (isset(self::$current->my_vars[self::FLASH_ERROR_MESSAGES_KEY]))
        {
            return count(self::$current->my_vars[self::FLASH_ERROR_MESSAGES_KEY])>0;
        }
        else
        {
            return false;
        } 
    }

    public static function get_ok_messages()
    {
        if (isset(self::$current->my_vars[self::FLASH_OK_MESSAGES_KEY]))
            return self::$current->my_vars[self::FLASH_OK_MESSAGES_KEY];
        else
            return array();
    }
    
    public static function get_warning_messages()
    {
        if (isset(self::$current->my_vars[self::FLASH_WARNING_MESSAGES_KEY]))
            return self::$current->my_vars[self::FLASH_WARNING_MESSAGES_KEY];
        else
            return array();
    }
    
    public static function get_error_messages()
    {
        if (isset(self::$current->my_vars[self::FLASH_ERROR_MESSAGES_KEY]))
            return self::$current->my_vars[self::FLASH_ERROR_MESSAGES_KEY];
        else
            return array();
    }
    
    
    public static function write_ok_messages()
    {
        if (self::has_oks())
            include("include/messages/flash/ok_messages.php.inc");
    }
    
    public static function write_warning_messages()
    {
        if (self::has_warnings())
            include("include/messages/flash/warning_messages.php.inc");
    }
    
    public static function write_error_messages()
    {
        if (self::has_errors())
            include("include/messages/flash/error_messages.php.inc");
    }
    
    public static function write_all_messages()
    {
        self::write_ok_messages();
        self::write_warning_messages();
        self::write_error_messages();
    }

    public static function keep()
    {
        self::$keep_messages = true;
    }

    public static function updateFromResult($result)
    {
        if ($result instanceof Exception)
        {
            Flash::error($result);
            return;
        }
        if (isset($result["result"]))
        {
            if ($result["result"]=="warning")
                Flash::warning($result["warning"]);
            if ($result["result"]=="error")
                Flash::error($result["error"]);
        }
    }

    public static function last_form_params()
    {
        if (isset(self::$current->my_vars[self::FLASH_FORM_PARAMS_KEY]))
            return self::$current->my_vars[self::FLASH_FORM_PARAMS_KEY];
        else
            return array();
    }

    public static function keep_form_params()
    {
        $keys = Params::keys();
        foreach ($keys as $k)
            self::push_key_value(self::FLASH_FORM_PARAMS_KEY,$k,Params::get($k));
    }
}

?>