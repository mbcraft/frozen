<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

class __MysqlDelete extends __AbstractMysql
{

    function sql()
    {
        $this->sql ="DELETE FROM `".$this->my_table."` ";

        $this->__sql_conditions();

        $this->__sql_end();

        return $this->sql;
    }

    function exec()
    {
        if (!DB::isConnectionOpen()) $this->__error(__METHOD__, "La connessione al database non e' aperta prima della query con MysqlDelete");

        return mysql_query($this->sql());
    }

}

?>