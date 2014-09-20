<?php

/* This software is released under the BSD license. Full text at project root -> license.txt */

interface MysqlFieldSpec
{
    const UNIQUE = "UNIQUE KEY *unique_field_name* (*field_name*)";

    const FULLTEXT = "FULLTEXT KEY *fulltext_field_name* (*field_name*)";

    const INDEX = "KEY *index_field_name* (*field_name*)";

    const AUTOINCREMENT_ID = "*field_name* bigint(20) unsigned *null* AUTO_INCREMENT PRIMARY KEY *comment* *position*";

    const AUTOINCREMENT_ID_NO_PK = "*field_name* bigint(20) unsigned *null* AUTO_INCREMENT *comment* *position*";

    const EXTERNAL_ID = "*field_name* bigint(20) unsigned *null* *comment* *position*";

    const TEXT_16 = "*field_name* varchar(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci *null* *comment* *position*";

    const TEXT_32 = "*field_name* varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci *null* *comment* *position*";

    const TEXT_64 = "*field_name* varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci *null* *comment* *position*";

    const KEY = "`key` varchar(64) CHARACTER SET utf8 COLLAGE utf8_unicode_ci NOT NULL COMMENT 'User key for entry' *position*";
    
    const TEXT_128 = "*field_name* varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci *null* *comment* *position*";

    const TEXT_512 = "*field_name* varchar(512) CHARACTER SET utf8 COLLATE utf8_unicode_ci *null* *comment* *position*";

    const TEXT_1024 = "*field_name* varchar(1024) CHARACTER SET utf8 COLLATE utf8_unicode_ci *null* *comment* *position*";

    const TEXT_65K = "*field_name* text CHARACTER SET utf8 COLLATE utf8_unicode_ci *null* *comment* *position*";

    const TEXT_BIG = "*field_name* mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci *null* *comment* *position*";

    const BOOL = "*field_name* tinyint(1) *null* *comment* *position*";

    const UNSIGNED_INT_8 = "*field_name* tinyint unsigned *null* *comment* *position*";

    const UNSIGNED_INT_32 = "*field_name* mediumint unsigned *null* *comment* *position*";

    const SIGNED_INT_8 = "*field_name* tinyint signed *null* *comment* *position*";

    const SIGNED_INT_32 = "*field_name* mediumint signed *null* *comment* *position*";

    const DOUBLE = "*field_name* double *null* *comment* *position*";

    const NUMERIC = "*field_name* numeric *null* *comment* *position*";

    const DATE = "*field_name* date *null* *comment* *position*";

    const TIME = "*field_name* time *null* *comment* *position*";

    const DATETIME = "*field_name* datetime *null* *comment* *position*";

    const TIMESTAMP = "*field_name* timestamp *null* *comment* *position*";

}

?>