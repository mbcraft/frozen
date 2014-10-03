<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

class Sitemap
{
    private $__entries = array();

    public function addEntry($entry)
    {
        $this->__entries[] = $entry;
    }

    public function render()
    {
        echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r\n";
        echo "<urlset xmlns=\"http://www.google.com/schemas/sitemap/0.84\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:schemaLocation=\"http://www.google.com/schemas/sitemap/0.84 http://www.google.com/schemas/sitemap/0.84/ sitemap.xsd\">\r\n";

        foreach ($this->__entries as $entry)
            $entry->render();

        echo "</urlset>\r\n";
    }
}

?>