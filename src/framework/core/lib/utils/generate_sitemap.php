<?
/* This software is released under the BSD license. Full text at project root -> license.txt */
require_once("../../../init.php");

if (isset(Config::instance()->SITEMAP_MODE) && Config::instance()->SITEMAP_MODE=="static")
{
    $sitemap_dirs = Config::instance()->SITEMAP_DIRS;

    $sitemap = SitemapBuilder::generate_from_pages($sitemap_dirs);
    $sitemap->render();
}
?>