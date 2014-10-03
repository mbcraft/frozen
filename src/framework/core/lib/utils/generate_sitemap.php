<?
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */
require_once("../../../init.php");

if (isset(Config::instance()->SITEMAP_MODE) && Config::instance()->SITEMAP_MODE=="static")
{
    $sitemap_dirs = Config::instance()->SITEMAP_DIRS;

    $sitemap = SitemapBuilder::generate_from_pages($sitemap_dirs);
    $sitemap->render();
}
?>