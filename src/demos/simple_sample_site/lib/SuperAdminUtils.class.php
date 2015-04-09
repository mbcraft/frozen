<?php

    class SuperAdminUtils {
  
        static function is_logged() {
            return Session::is_set("/SUPERADMIN") && Session::get("/SUPERADMIN")=="logged";
        }
        
        static function check_login() {
            return Params::is_set("code") && Params::get("code")=="frzadmin";
        }
        
        static function set_logged() {
            Session::set("/SUPERADMIN","logged");
        }
    
    }
    
    
?>