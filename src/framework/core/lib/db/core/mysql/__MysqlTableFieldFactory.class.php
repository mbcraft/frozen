<?php

/* This software is released under the BSD license. Full text at project root -> license.txt */

class __MysqlTableFieldFactory
{
    private static $instance = null;

    public static function instance()
    {
        if (self::$instance===null)
            self::$instance = new __MysqlTableFieldFactory();
        return self::$instance;
    }

    public function create_unique($name)
    {
        return new __MysqlTableField($name,false,MysqlFieldSpec::UNIQUE,"");
    }

    public function create_index($name)
    {
        return new __MysqlTableField($name,false,MysqlFieldSpec::INDEX,"");
    }

    public function create_fulltext($name)
    {
        return new __MysqlTableField($name,false,MysqlFieldSpec::FULLTEXT,"");
    }

    public function create_autoincrement_id($name,$optional,$comment=null,$position=null,$from_rename=false)
    {
        if ($from_rename)
            return new __MysqlTableField($name,$optional,MysqlFieldSpec::AUTOINCREMENT_ID_NO_PK,$comment,$position);
        else
            return new __MysqlTableField($name,$optional,MysqlFieldSpec::AUTOINCREMENT_ID,$comment,$position);
    }

    public function create_external_id($name,$optional,$comment=null,$position=null)
    {
        return new __MysqlTableField($name,$optional,MysqlFieldSpec::EXTERNAL_ID,$comment,$position);
    }

    public function create_text_16($name,$optional,$comment=null,$position=null)
    {
        return new __MysqlTableField($name,$optional,MysqlFieldSpec::TEXT_16,$comment,$position);
    }

    public function create_text_32($name,$optional,$comment=null,$position=null)
    {
        return new __MysqlTableField($name,$optional,MysqlFieldSpec::TEXT_32,$comment,$position);
    }

    public function create_text_64($name,$optional,$comment=null,$position=null)
    {
        return new __MysqlTableField($name,$optional,MysqlFieldSpec::TEXT_64,$comment,$position);
    }
    
    public function create_key($position=null)
    {
        return new __MysqlTableField("",false,MysqlFieldSpec::KEY,"",$position);
    }

    public function create_text_128($name,$optional,$comment=null,$position=null)
    {
        return new __MysqlTableField($name,$optional,MysqlFieldSpec::TEXT_128,$comment,$position);
    }

    public function create_text_512($name,$optional,$comment=null,$position=null)
    {
        return new __MysqlTableField($name,$optional,MysqlFieldSpec::TEXT_512,$comment,$position);
    }

    public function create_text_1024($name,$optional,$comment=null,$position=null)
    {
        return new __MysqlTableField($name,$optional,MysqlFieldSpec::TEXT_1024,$comment,$position);
    }

    public function create_text_65k($name,$optional,$comment=null,$position=null)
    {
        return new __MysqlTableField($name,$optional,MysqlFieldSpec::TEXT_65K,$comment,$position);
    }

    public function create_text_big($name,$optional,$comment=null,$position=null)
    {
        return new __MysqlTableField($name,$optional,MysqlFieldSpec::TEXT_BIG,$comment,$position);
    }

    public function create_unsigned_int_8($name,$optional,$comment=null,$position=null)
    {
        return new __MysqlTableField($name,$optional,MysqlFieldSpec::UNSIGNED_INT_8,$comment,$position);
    }

    public function create_signed_int_8($name,$optional,$comment=null,$position=null)
    {
        return new __MysqlTableField($name,$optional,MysqlFieldSpec::SIGNED_INT_8,$comment,$position);
    }

    public function create_unsigned_int_32($name,$optional,$comment=null,$position=null)
    {
        return new __MysqlTableField($name,$optional,MysqlFieldSpec::UNSIGNED_INT_32,$comment,$position);
    }

    public function create_signed_int_32($name,$optional,$comment=null,$position=null)
    {
        return new __MysqlTableField($name,$optional,MysqlFieldSpec::SIGNED_INT_32,$comment,$position);
    }

    public function create_double($name,$optional,$comment=null,$position=null)
    {
        return new __MysqlTableField($name,$optional,MysqlFieldSpec::DOUBLE,$comment,$position);
    }

    public function create_numeric($name,$optional,$comment=null,$position=null)
    {
        return new __MysqlTableField($name,$optional,MysqlFieldSpec::NUMERIC,$comment,$position);
    }

    public function create_date($name,$optional,$comment=null,$position=null)
    {
        return new __MysqlTableField($name,$optional,MysqlFieldSpec::DATE,$comment,$position);
    }

    public function create_bool($name,$optional,$comment=null,$position=null)
    {
        return new __MysqlTableField($name,$optional,MysqlFieldSpec::BOOL,$comment,$position);
    }

    public function create_time($name,$optional,$comment=null,$position=null)
    {
        return new __MysqlTableField($name,$optional,MysqlFieldSpec::TIME,$comment,$position);
    }

    public function create_datetime($name,$optional,$comment=null,$position=null)
    {
        return new __MysqlTableField($name,$optional,MysqlFieldSpec::DATETIME,$comment,$position);
    }

    public function create_timestamp($name,$optional,$comment=null,$position=null)
    {
        return new __MysqlTableField($name,$optional,MysqlFieldSpec::TIMESTAMP,$comment,$position);
    }
    
}


?>