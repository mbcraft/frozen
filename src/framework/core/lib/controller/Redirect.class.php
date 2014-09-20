<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

class Redirect extends BasicObject implements IActionCommand
{
    private static $redirects = array();

    const REDIRECT_NOT_FOUND = "REDIRECT_NOT_FOUND";

    private $url;

    function __construct($url)
    {
        $this->url = $url;
    }

    function doRedirect()
    {
        header("Location: ".$this->url);
    }

    public function execute()
    {
        $this->doRedirect();
    }

    function getUrl()
    {
        return $this->url;
    }

    /*
     * Ritorna un redirect
     */
    static function get_by_key($key)
    {
        if (isset(self::$redirects[$key]))
        {
            return self::$redirects[$key];
        }
        else
        {
            if (!isset(self::$redirects[self::REDIRECT_NOT_FOUND]))
                Log::error ("Redirects::get", "REDIRECT_NOT_FOUND not initialized!!!");
            else
                return self::$redirects[self::REDIRECT_NOT_FOUND];
        }
    }

    /*
     * Imposta un redirect
     */
    static function set_with_key($key,$value)
    {
        self::$redirects[$key] = new Redirect($value);
    }

    static function success()
    {
        return new Redirect(Params::get("__on_success"));
    }

    static function failure()
    {
        return new Redirect(Params::get("__on_failure"));
    }
}

?>