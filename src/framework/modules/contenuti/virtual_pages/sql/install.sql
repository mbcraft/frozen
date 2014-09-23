/*
Cartelle.
Rappresentano le cartelle utilizzate per archiviare le pagine

id : id dell'entità
tipo : rappresenta il tipo di cartella.

0 : non definito
1 : testi
2 : immagini
3 : documenti
4 : news
5 : eventi

ordine : rappresenta l'ordine di visualizzazione
path : la cartella dell'entità
nome : il nome dell'entità.
path + nome : percorso completo dell'entità
level : livello a cui si trova l'entità (dato da : numero elementi del path + 1 )

params : contiene un'insieme di parametri che vengono utilizzati, ad esempio, per impostare uno stile
nel rendering della cartella.
Per le gallery viene utilizzato per definire il tipo di transizione
descrizione : una descrizione sommaria della cartella
properties : contiene parametri relativi alla cartella, che variano da tipo a tipo e sono variabili.
Per le cartelle delle pagine può contenere ad esempio lo stile di rendering per i menù, per le gallery il tipo di transizione, ecc ...
*/

 CREATE TABLE IF NOT EXISTS `tab_folders` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `tipo` ENUM('f_testi','f_pagine','f_documenti','f_immagini','f_news','f_eventi'),
  `ordine` INT UNSIGNED NOT NULL,
  `path` VARCHAR(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `level` INT UNSIGNED NOT NULL,
  `nome` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `nome_visualizzazione` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `descrizione` VARCHAR(512) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `properties` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci,

  /*
  `keywords` VARCHAR(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  */
  PRIMARY KEY (`id`)
 ) ENGINE = MYISAM DEFAULT CHARSET=utf8;

/*
Rappresenta le pagine che si possono creare

id : id dell'entità
path + level : il percorso completo dell'entità e il suo livello
ordine : rappresenta il numero per l'ordinamento all'interno dei menù
layout : il layout che viene utilizzato per la pagina
nome : Il nome utilizzato dalla pagina. Il percorso completo è dato da path+nome
ES :
path = /it/disco/
nome = feste_e_serate

L'estensione viene eventualmente aggiunta in automatico.

chiave : la chiave che rappresenta la pagina
codice_lingua : il codice lingua che identifica la pagina

se la pagina è inserita nel menù per chiave, nel caso sia presente la versione in inglese viene agganciata la versione in inglese
(per siti in cui si vuole mantenere la stessa struttura).

Se invece si vuole utilizzare una struttura differente, si può specificare nella config che il codice lingua è mutuato dal primo elemento
del path
ES :
/en/philosophy/writings.php -> codice_lingua : en

page_title + page_description : titolo e descrizione della pagina, inseriti nelle properties

Le keywords al momento si lasciano per evitare future modifiche alla tabella.
*/
CREATE TABLE IF NOT EXISTS `tab_pagine` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `path` VARCHAR(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `level` INT UNSIGNED NOT NULL,
  `ordine` INT UNSIGNED NOT NULL,
  `layout` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `nome` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `chiave` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `codice_lingua` VARCHAR(6) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `properties` TINYTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `dataora_creazione` DATETIME NOT NULL,
  `dataora_ultima_modifica` DATETIME NOT NULL,
  `keywords` VARCHAR(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE = MYISAM DEFAULT CHARSET=utf8;

/*
L'ordine non è importante per i settori, è il path che conta.

id : id dell'entità
id_pagina : l'id della pagina a cui si fa riferimento
path_settore : il percorso del settore definito
categoria : la tipologia di riempitivo utilizzato
sotto_categoria : il sottotipo di riempitivo utilizzato
specifica : la specifica del riempitivo utilizzato, viene passato come parametro al metodo che fa il rendering del settore.
*/

CREATE TABLE IF NOT EXISTS `tab_elementi_pagina` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_pagina` BIGINT UNSIGNED NOT NULL,
  `path_settore` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `categoria` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `sotto_categoria` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `specifica` TINYTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,

  PRIMARY KEY (`id`)
) ENGINE = MYISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `tab_testi` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `path` VARCHAR(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `level` INT UNSIGNED NOT NULL,
  `tipo` VARCHAR(5) NOT NULL,
  `nome` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `testo` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `codice_lingua` VARCHAR(6) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `keywords` VARCHAR(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `chiave` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `dataora_creazione` DATETIME NOT NULL,
  `dataora_ultima_modifica` DATETIME NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = MYISAM DEFAULT CHARSET=utf8;
/*
id : id dell'evento
id_testo : l'id del contenuto che descrive la news

*/
CREATE TABLE IF NOT EXISTS `tab_eventi` (
`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
`id_testo` BIGINT UNSIGNED NOT NULL,
`stato_evento` ENUM('creato','in_corso','terminato'),
`dataora_inizio` DATETIME NOT NULL,
`dataora_fine` DATETIME NOT NULL,
`luogo` VARCHAR( 256 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`indirizzo` VARCHAR( 256 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`cap` VARCHAR( 6 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`citta` VARCHAR( 128 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`provincia` VARCHAR( 256 ) NOT NULL,
`stato` VARCHAR( 256 ) NOT NULL,
`dataora_creazione` DATETIME NOT NULL,
`dataora_ultima_modifica` DATETIME NOT NULL,
PRIMARY KEY (`id`)
) ENGINE = MYISAM DEFAULT CHARSET=utf8;

/*
id : l'id della news
id_testo : l'id del contenuto

Lo stato della news può essere :
0 : creata
1 : pubblicata
2 : archiviata

stato_news + date varie : rappresentano lo stato della news
*/

CREATE TABLE IF NOT EXISTS `tab_news` (
`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
`id_testo` BIGINT UNSIGNED NOT NULL,
`stato_news` ENUM('creata','pubblicata','archiviata'),
`dataora_creazione` DATETIME NOT NULL,
`dataora_pubblicazione` DATETIME,
`dataora_archiviazione` DATETIME,
`dataora_ultima_modifica` DATETIME NOT NULL,
PRIMARY KEY (`id`)
) ENGINE = MYISAM DEFAULT CHARSET=utf8;


/*
Tabella per le immagini, contiene nome, descrizione e keywords.
path + level + real_name la identificano all'interno delle cartelle.

Il salvataggio del file fisico avviene in un'unica cartella con hashing del nome :
save_folder + hash_name identificano il percorso fisico del file.

Real_name è il nome originale del file. Deve essere utilizzato in caso di download.
*/
 CREATE TABLE IF NOT EXISTS `tab_immagini` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `path` VARCHAR(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `level` INT UNSIGNED NOT NULL,
  `nome` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `save_folder` VARCHAR(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `hash_name` VARCHAR(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `real_name` VARCHAR(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `descrizione` VARCHAR(512) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `properties` TINYTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `keywords` VARCHAR(512) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `dataora_ultima_modifica` DATETIME NOT NULL, 
  PRIMARY KEY (`id`)
) ENGINE = MYISAM DEFAULT CHARSET=utf8;

/*
Tabella per documenti.
Contiene il nome, la descrizione, chiave e codice_lingua sono per la localizzazione dei documeti
path + level + real_name li identificano all'interno delle cartelle.

Il salvataggio del file fisico avviene in un'unica cartella con hashing del nome :
save_folder + hash_name identificano il percorso fisico del file.

Real_name è il nome originale del file. Deve essere utilizzato in fase di download.
*/
CREATE TABLE IF NOT EXISTS `tab_documenti` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `path` VARCHAR(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `level` INT UNSIGNED NOT NULL,
  `save_folder` VARCHAR(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `hash_name` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `real_name` VARCHAR(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `nome` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `properties` TINYTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `descrizione` VARCHAR(512) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `codice_lingua` VARCHAR(6) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `keywords` VARCHAR(512) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `chiave` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `dataora_ultima_modifica` DATETIME NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = MYISAM DEFAULT CHARSET=utf8;

FLUSH TABLES;

