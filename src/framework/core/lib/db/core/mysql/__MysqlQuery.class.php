<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */
class __MysqlQuery
{
    private $sql;
    private $result;

    function __construct($sql)
    {
        $this->sql = $sql;
    }

    function exec()
    {
        if (!DB::isConnectionOpen()) Log::error(__METHOD__, "La connessione al database non e' aperta prima della query con MysqlQuery");

        $pieces = explode(";",$this->sql);
        foreach ($pieces as $pq)
        {
            if (trim($pq)!="")
            {
                $result = mysql_query($pq.";");
            }
        }

    }

    function free()
    {
        if ($this->result!=false) mysql_free_result($this->result);
        $this->result = null;
    }

}

?>