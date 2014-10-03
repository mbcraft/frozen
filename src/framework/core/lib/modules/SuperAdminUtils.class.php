<?

class SuperAdminUtils
{
    public static function check_login()
    {
        if (Params::is_set("code") && Params::get("code")=="adminm2")
            self::set_logged ();
    }
    
    public static function set_logged()
    {
        Session::set ("/admin_fg", true);
    }
    
    public static function is_logged()
    {
        return Session::is_set("/admin_fg") && Session::get("/admin_fg")==true;
    }
}

?>