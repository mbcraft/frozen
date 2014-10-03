<?php

/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

class __MysqlTableDataImportExport extends BasicObject
{

    function import_data($data)
    {
        $xml_reader = new SimpleXMLElement($data);

        $table_attribs = $xml_reader->attributes();

        $table_name = $table_attribs["name"];

        if ($xml_reader->getName()=="table")
        {
            foreach ($xml_reader->row as $row)
            {
                $ii = new __MysqlInsert($table_name);

                foreach ($row->field as $field)
                {
                    $ii->add($field["name"],"".$field);
                }

                $ii->exec();
            }
        }
        else
            throw new IOException("Tabella da importare non compatibile col file");
    }

    function import_data_from_file($filename_or_file)
    {
        if ($filename_or_file instanceof File)
            $f = $filename_or_file;
        else
            $f = new File($filename_or_file);

        $this->import_data($f->getContent());
    }

    public function export_data($table)
    {
        if (!$table) throw new InvalidParameterException("Il nome della tabella è nullo!");

        $table_desc = new __MysqlTableFieldsDescription($table);
        $all_fields = $table_desc->getAllFields();

        $ss = new __MysqlSelect($table);
        $all_rows = $ss->exec_fetch_assoc_all();
        
        $xml_builder = new XMLBuilder();

        $xml_builder->element("table");
        $xml_builder->attribute("name",$table);
        $xml_builder->forward();

        foreach ($all_rows as $row)
        {
            $xml_builder->element("row");
            $xml_builder->forward();

            foreach ($all_fields as $k => $v)
            {
                $xml_builder->element("field",$row[$k],true);
                $xml_builder->attribute("name",$k);
            }

            $xml_builder->back();
        }

        return $xml_builder->getXML();
    }

    public function export_data_to_file($table,$filename_or_file)
    {
        if ($filename_or_file instanceof File)
            $f = $filename_or_file;
        else
            $f = new File($filename_or_file);

        $f->setContent($this->export_data($table));
    }
}


?>