<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

class ProfileMap
{
    private static $profile_map = array();

    private static function check_registered_profile($profile_id)
    {
        if (!array_key_exists($profile_id, self::$profile_map)) Log::error("registerProfile", "Profilo gia' registrato : ".$profile_id." : ".$profile_description);
    }

    public static function registerProfile($profile_id,$peer_class_name,$profile_description)
    {
        $value = array();
        $value["peer_class_name"] = $peer_class_name;
        $value["profile_description"] = $profile_description;

        self::$profile_map[$profile_id] = $value;
    }

    public static function getProfilePeerInstance($profile_id)
    {
        self::check_registered_profile($profile_id);

        return __create_instance(self::$profile_map[$profile_id]["peer_class_name"]);
    }

    public static function getProfileDescription($profile_id)
    {
        self::check_registered_profile($profile_id);

        return self::$profile_map[$profile_id]["profile_description"];
    }
}

?>