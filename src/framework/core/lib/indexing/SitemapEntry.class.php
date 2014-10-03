<?

/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

define ("CRLF","\r\n");
define ("T","\t");
define ("FULL_HTTP_HOST","http://".$_SERVER["HTTP_HOST"]);

class SitemapEntry
{
    private $loc;
    private $changefreq;
    private $lastmod;
    private $priority;

    const CHANGEFREQ_ALWAYS = "always";
    const CHANGEFREQ_HOURLY = "hourly";
    const CHANGEFREQ_DAILY = "daily";
    const CHANGEFREQ_WEEKLY = "weekly";
    const CHANGEFREQ_MONTHLY = "monthly";
    const CHANGEFREQ_YEARLY = "yearly";
    const CHANGEFREQ_NEVER = "never";


    public function setLoc($loc)
    {
        $this->loc = $loc;
    }

    public function setChangeFreq($changefreq)
    {
        $this->changefreq = $changefreq;
    }

    public function setLastMod($lastmod)
    {
        $this->lastmod = $lastmod;
    }

    public function setPriority($priority)
    {
        $this->priority = $priority;
    }

    function render()
    {
        echo T."<url>".CRLF;
        echo T.T."<loc>".FULL_HTTP_HOST.$this->loc."</loc>".CRLF;
        echo T.T."<lastmod>".$this->lastmod."</lastmod>".CRLF;
        echo T.T."<changefreq>".$this->changefreq."</changefreq>".CRLF;
        echo T.T."<priority>".$this->priority."</priority>".CRLF;
        echo T."</url>".CRLF;
    }
}

?>