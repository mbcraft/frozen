<?php

/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

class BrowserInfo
{
    const SESSION_BROWSER_VARS_FETCHED = "/__protected_vars/browser/fetched";
    const SESSION_BROWSER_SCREEN_WIDTH = "/__protected_vars/browser/screen/width";
    const SESSION_BROWSER_SCREEN_HEIGHT = "/__protected_vars/browser/screen/height";

    public static function fetch()
    {
        if (!self::is_fetched())
        {
            JS::require_jquery();
            JS::require_script("/".FRAMEWORK_CORE_PATH."js/jquery/screen_resolution.js");
        }
    }

    public static function set_as_fetched()
    {
        Session::set(self::SESSION_BROWSER_VARS_FETCHED,true);
    }

    public static function is_fetched()
    {
        return Session::is_set(self::SESSION_BROWSER_VARS_FETCHED) && Session::get(self::SESSION_BROWSER_VARS_FETCHED);
    }

    public static function set_screen_width($screen_width)
    {
        Session::set(self::SESSION_BROWSER_SCREEN_WIDTH,$screen_width);
    }

    public static function set_screen_height($screen_height)
    {
        Session::set(self::SESSION_BROWSER_SCREEN_HEIGHT,$screen_height);
    }

    public static function get_screen_width()
    {
        return Session::get(self::SESSION_BROWSER_SCREEN_WIDTH);
    }

    public static function get_screen_height()
    {
        return Session::get(self::SESSION_BROWSER_SCREEN_HEIGHT);
    }
}



?>