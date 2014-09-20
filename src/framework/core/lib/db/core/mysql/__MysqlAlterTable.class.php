<?php

/* This software is released under the BSD license. Full text at project root -> license.txt */

class __MysqlAlterTable
{

    const FLUSH_TABLES_QUERY = "FLUSH TABLES;";

    protected $my_table;

    public function __construct($my_table)
    {
        $this->my_table = $my_table;
    }

    public function getFieldFactory()
    {
        return __MysqlTableFieldFactory::instance();
    }

    public function add_column($field_def,$after_col=null)
    {
        $sql = "ALTER TABLE ".$this->my_table." ADD ".$field_def->render().";";
        //echo "ADD COLUMN : ".$sql;
        $result = mysql_query($sql);
        mysql_query(self::FLUSH_TABLES_QUERY);

        return $result;
    }

    public function change_column($old_name,$field_def,$after_col=null)
    {
        $sql = "ALTER TABLE ".$this->my_table." CHANGE ".$old_name." ".$field_def->render().";";
        //echo "CHANGE COLUMN : ".$sql;
        $result = mysql_query($sql);
        mysql_query(self::FLUSH_TABLES_QUERY);

        return $result;
    }

    public function drop_column($column_name)
    {
        $sql = "ALTER TABLE ".$this->my_table." DROP COLUMN ".$column_name.";";
        $result = mysql_query($sql);
        mysql_query(self::FLUSH_TABLES_QUERY);

        return $result;
    }

    /*
     * Copia la tabella corrente in una nuova tabella (prende anche i dati??)
     * */
    public function copy_to($new_table)
    {
       $result = mysql_query("CREATE TABLE ".$new_table." LIKE ".$this->my_table.";");
       mysql_query(self::FLUSH_TABLES_QUERY);

       return $result;
    }
    /*
     * Rinomina la tabella
     * */
    public function rename($new_name)
    {
        $result = mysql_query("ALTER TABLE ".$this->my_table." RENAME ".$new_name.";");
        mysql_query(self::FLUSH_TABLES_QUERY);

        return $result;
    }

    /*
     * Sposta la tabella in un altro database
     * */
    public function move($new_db,$new_name=null)
    {
        if ($new_name==null)
            $new_name = $this->my_table;

        $result = mysql_query("RENAME TABLE ".$this->my_table." TO ".$new_db.".".$new_name.";");
        mysql_query(self::FLUSH_TABLES_QUERY);

        return $result;
    }

}

?>