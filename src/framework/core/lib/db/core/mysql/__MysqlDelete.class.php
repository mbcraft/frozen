<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

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