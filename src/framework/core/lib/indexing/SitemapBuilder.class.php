<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

class SitemapBuilder
{

    public static function generate_from_pages($folders)
    {
        $sitemap = new Sitemap();
        
        foreach ($folders as $folder)
        {
            $menu_entries = MenuBuilder::get_menu_entries($folder);

            self::add_menu_entry($sitemap,$menu_entries);            
        }
        
        return $sitemap;
    }
    
    private static function add_menu_entry($sitemap,$entry)
    {
        if (isset($entry["link"]) && isset($entry["key"]))
        {
            $sitemap_entry = new SitemapEntry();
            $sitemap_entry->setLoc($entry["link"]);
            $sitemap_entry->setPriority(1);
            $sitemap_entry->setChangeFreq(SitemapEntry::CHANGEFREQ_MONTHLY);
            
            $page_path = str_replace(".php", ".page.php", $entry["link"]);
            $f = new File("/contenuti".$page_path);
            $mod_time = date("Y-m-d",$f->getModificationTime());
            
            $sitemap_entry->setLastMod($mod_time);
            
            $sitemap->addEntry($sitemap_entry);
        }

        if (isset($entry["childs"]))
        {
            $all_childs = $entry["childs"];

            foreach ($all_childs as $child)
                self::add_menu_entry ($sitemap, $child);
        }
    }
}


?>