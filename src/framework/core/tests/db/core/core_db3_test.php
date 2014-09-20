<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */


//tabella destinatari
/*
--
-- Struttura della tabella `destinatari`
--

CREATE TABLE IF NOT EXISTS `destinatari` (
`id_destinatario` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
`nome` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
`cognome` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
UNIQUE KEY `id_destinatario` (`id_destinatario`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dump dei dati per la tabella `destinatari`
--

INSERT INTO `destinatari` (`id_destinatario`, `nome`, `cognome`) VALUES
(1, 'Marco', 'Bagnaresi'),
(2, 'Michele', 'Rispoli');


*/

//tabella prodotti
/*
--
-- Struttura della tabella `prodotto`
--

CREATE TABLE IF NOT EXISTS `prodotto` (
  `id_prodotto` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nome_prodotto` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `descrizione` text COLLATE utf8_unicode_ci NOT NULL,
  `prezzo` float NOT NULL,
  UNIQUE KEY `id_prodotto` (`id_prodotto`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dump dei dati per la tabella `prodotto`
--

INSERT INTO `prodotto` (`id_prodotto`, `nome_prodotto`, `descrizione`, `prezzo`) VALUES
(1, 'Riso', 'riso scotti', 12.5),
(2, 'Pasta', 'Pasta rigata', 4.5);
*/

//tabella vendita
/*
--
-- Struttura della tabella `vendita`
--

CREATE TABLE IF NOT EXISTS `vendita` (
  `id_vendita` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `quantita` int(11) NOT NULL,
  `id_prodotto` bigint(20) NOT NULL,
  `id_destinatario` bigint(20) NOT NULL,
  UNIQUE KEY `id_vendita` (`id_vendita`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dump dei dati per la tabella `vendita`
--

INSERT INTO `vendita` (`id_vendita`, `quantita`, `id_prodotto`, `id_destinatario`) VALUES
(1, 4, 1, 2),
(2, 3, 2, 2),
(3, 3, 2, 1),
(4, 7, 2, 1);

*/


/*
Creazione della vista :

CREATE ALGORITHM=MERGE VIEW `vendite_full` AS select `vendita`.`id_vendita` AS `id_vendita`,`vendita`.`quantita` AS `quantita`,`destinatari`.`nome` AS `nome`,`destinatari`.`cognome` AS `cognome`,`prodotto`.`nome_prodotto` AS `nome_prodotto`,`prodotto`.`descrizione` AS `descrizione`,`prodotto`.`prezzo` AS `prezzo` from ((`vendita` join `prodotto`) join `destinatari`) where ((`vendita`.`id_destinatario` = `destinatari`.`id_destinatario`) and (`vendita`.`id_prodotto` = `prodotto`.`id_prodotto`));

*/

class TestCoreDb3 extends UnitTestCase
{

    private $setup_sql = "
    CREATE TABLE IF NOT EXISTS `destinatari` (
`id_destinatario` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
`nome` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
`cognome` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
UNIQUE KEY `id_destinatario` (`id_destinatario`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;
INSERT INTO `destinatari` (`id_destinatario`, `nome`, `cognome`) VALUES
(1, 'Marco', 'Bagnaresi'),
(2, 'Michele', 'Rispoli');

CREATE TABLE IF NOT EXISTS `prodotti` (
  `id_prodotto` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nome_prodotto` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `descrizione` text COLLATE utf8_unicode_ci NOT NULL,
  `prezzo` float NOT NULL,
  UNIQUE KEY `id_prodotto` (`id_prodotto`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;
INSERT INTO `prodotti` (`id_prodotto`, `nome_prodotto`, `descrizione`, `prezzo`) VALUES
(1, 'Riso', 'riso scotti', 12.5),
(2, 'Pasta', 'Pasta rigata', 4.5);

CREATE TABLE IF NOT EXISTS `vendite` (
  `id_vendita` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `quantita` int(11) NOT NULL,
  `id_prodotto` bigint(20) NOT NULL,
  `id_destinatario` bigint(20) NOT NULL,
  UNIQUE KEY `id_vendita` (`id_vendita`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;
INSERT INTO `vendite` (`id_vendita`, `quantita`, `id_prodotto`, `id_destinatario`) VALUES
(1, 4, 1, 2),
(2, 3, 2, 2),
(3, 3, 2, 1),
(4, 7, 2, 1);
    ";

    private $teardown_sql = "
    DROP TABLE `vendite`;
    DROP TABLE `destinatari`;
    DROP TABLE `prodotti`;
    ";

    function setUp()
    {
        DB::openConnection(Config::instance()->TEST_DB_NAME, "localhost", Config::instance()->TEST_DB_USERNAME, Config::instance()->TEST_DB_PASSWORD, false);

        DB::newDirectSql($this->setup_sql)->exec();
    }

    function tearDown()
    {
        DB::newDirectSql($this->teardown_sql)->exec();

        DB::closeConnection();
    }

    function testCreateView()
    {
        $create_view = new __MysqlCreateView("vendite_full");
        $t1 = "destinatari";
        $t2 = "vendite";
        $t3 = "prodotti";
        $create_view->addViewField($t1,"nome");
        $create_view->addViewField($t1,"cognome");

        $create_view->addViewField($t2,"id_vendita");
        $create_view->addViewField($t2,"quantita");

        $create_view->addViewField($t3,"nome_prodotto");
        $create_view->addViewField($t3,"descrizione");
        $create_view->addViewField($t3,"prezzo");

        $create_view->addJoinFields("vendite","id_destinatario","destinatari","id_destinatario");
        $create_view->addJoinFields("vendite","id_prodotto","prodotti","id_prodotto");

        $create_view->exec();


        $sel = new __MysqlSelect("vendite_full");
        $sel->add("*");

        $all_results = $sel->exec_fetch_assoc_all();

        $this->assertEqual(count($all_results),4,"Il numero di risultati nella query non corrisponde!!");
        $this->assertEqual(count($all_results[0]),7,"Il numero di campi trovati non corrisponde!!");

        $drop = new __MysqlDropView("vendite_full");
        $drop->exec();

    }

    function testAlterView()
    {
        $create_view = new __MysqlCreateView("vendite_full");
        $t1 = "destinatari";
        $t2 = "vendite";
        $t3 = "prodotti";
        $create_view->addViewField($t1,"nome");
        $create_view->addViewField($t1,"cognome");

        $create_view->addViewField($t2,"id_vendita");
        $create_view->addViewField($t2,"quantita");

        $create_view->addViewField($t3,"nome_prodotto");
        $create_view->addViewField($t3,"descrizione");
        $create_view->addViewField($t3,"prezzo");

        $create_view->addJoinFields("vendite","id_destinatario","destinatari","id_destinatario");
        $create_view->addJoinFields("vendite","id_prodotto","prodotti","id_prodotto");

        $create_view->exec();


        $alter_view = new __MysqlAlterView("vendite_full");
        $t1 = "destinatari";
        $t2 = "vendite";
        $t3 = "prodotti";
        $alter_view->addViewField($t1,"nome");
        $alter_view->addViewField($t1,"cognome");

        $alter_view->addViewField($t2,"id_vendita");
        $alter_view->addViewField($t2,"quantita");

        $alter_view->addViewField($t3,"nome_prodotto");

        $alter_view->addJoinFields("vendite","id_destinatario","destinatari","id_destinatario");
        $alter_view->addJoinFields("vendite","id_prodotto","prodotti","id_prodotto");

        $alter_view->exec();

        $sel = new __MysqlSelect("vendite_full");
        $sel->add("*");

        $all_results = $sel->exec_fetch_assoc_all();

        $this->assertEqual(count($all_results),4,"Il numero di risultati nella query non corrisponde!!");
        $this->assertEqual(count($all_results[0]),5,"Il numero di campi trovati non corrisponde!!");

        $drop = new __MysqlDropView("vendite_full");
        $drop->exec();
    }


    function testEditViewCheckParams1()
    {
        $edit_view = new __MysqlCreateView("pinco");
        $this->expectException("InvalidParameterException");
        $edit_view->addJoinFields("tab_a",null,"tab_b",null);
    }

    function testEditViewCheckParams2()
    {
        $edit_view = new __MysqlCreateView("pinco");
        $this->expectException("InvalidParameterException");
        $edit_view->addJoinFields("",null,"tab_b",null);
    }

    function testEditViewCheckParams3()
    {
        $edit_view = new __MysqlCreateView("pinco");
        $this->expectException("InvalidParameterException");
        $edit_view->addJoinFields(null,null,"tab_b",null);
    }

    function testEditViewCheckParams4()
    {
        $edit_view = new __MysqlCreateView("pinco");
        $this->expectException("InvalidParameterException");
        $edit_view->addViewField(null,null,null);
    }
}



?>