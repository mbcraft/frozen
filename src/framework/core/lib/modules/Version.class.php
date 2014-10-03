<?

/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

class Version
{
    const MAJOR_KEY = "major";
    const MINOR_KEY = "minor";
    const REVISION_KEY = "rev";

    private $props;

    function __construct($major,$minor,$rev)
    {
        $this->props = array();

        $this->props[self::MAJOR_KEY] = $major;
        $this->props[self::MINOR_KEY] = $minor;
        $this->props[self::REVISION_KEY] = $rev;
    }

    function getMajor()
    {
        return $this->props[self::MAJOR_KEY];
    }

    function getMinor()
    {
        return $this->props[self::MINOR_KEY];
    }

    function getRevision()
    {
        return $this->props[self::REVISION_KEY];
    }

    function is_compatible_with($version)
    {
        $v_a = $this->props;

        if ($version==null)
            $v_b = array();
        else
            $v_b = $version->props;

        $keys = array(self::MAJOR_KEY,self::MINOR_KEY,self::REVISION_KEY);

        foreach ($keys as $k)
        {
            if (!isset($v_a[$k])) return true;
            if (!isset($v_b[$k])) return false;
            if ($v_a[$k]<$v_b[$k]) return false;
            if ($v_a[$k]>$v_b[$k]) return true;
        }
        return true;
    }
}

?>