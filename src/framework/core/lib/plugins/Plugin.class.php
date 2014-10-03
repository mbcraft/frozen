<?php

/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

class Plugin
{
    const DEFAULT_EXTENSION = ".php.inc";
    const DEFAULT_DIR = "/include/plugins/";

    static function define($plugin_path)
    {
       $plugin_dir = new Dir("/include/plugins/".$plugin_path);
       $plugin_dir->touch();
    }

    static function get_single_file($full_plugin_path)
    {
       $f = new File(self::DEFAULT_DIR.$full_plugin_path.self::DEFAULT_EXTENSION);
       if (!$f->exists())
           throw new IOException("Il plugin ".$full_plugin_path." non e' stato trovato.");

        return $f->getIncludePath();

    }

    static function list_files($plugin_path)
    {
        $plugin_dir = new Dir(self::DEFAULT_DIR.$plugin_path);
        $final_result = array();

        if ($plugin_dir->exists())
        {
            $all_files = $plugin_dir->findFilesEndingWith(self::DEFAULT_EXTENSION);

            foreach ($all_files as $f)
                $final_result[] = $f->getIncludePath();
        }

        return $final_result;
    }

}
 
?>