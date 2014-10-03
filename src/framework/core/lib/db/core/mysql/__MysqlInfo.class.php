<?php

/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

class __MysqlInfo
{
    private $engines;
    private $privileges;

    function __construct()
    {
        $this->__loadAvailableEngines();
        $this->__loadPrivileges();
    }

    function __loadPrivileges()
    {
        $result = mysql_query("SHOW PRIVILEGES;");

        $privileges = array();

        while ($row = mysql_fetch_assoc($result))
        {
            $privilege_name = $row["Privilege"];
            unset($row["Privilege"]);

            $privileges[$privilege_name] = $row;

        }

        mysql_free_result($result);

        $this->privileges = $privileges;
    }

    function __loadAvailableEngines()
    {
        $result = mysql_query("SHOW ENGINES;");

        $engines = array();

        while ($row = mysql_fetch_assoc($result))
        {
            $engine_name = $row["Engine"];
            unset($row["Engine"]);
            if ($row["Support"]!=="NO")
            {
                unset($row["Support"]);
                $engines[$engine_name] = $row;
            }
        }

        mysql_free_result($result);

        $this->engines = $engines;
    }

    function getAvailableEngines()
    {
        return $this->engines;
    }

    function getAvailablePrivileges()
    {
        return $this->privileges;
    }
}

?>