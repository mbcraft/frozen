[ITALIANO] *********************************************************************************

** 'Frozen' php framework - precedentemente conosciuto come 'Charme-Crabs' **

Versione corrente : 3.3.4

Attenzione :

Questo framework ha alcune vulnerabilità. Usalo a tuo rischio e pericolo.
Le sistemerò quando avrò tempo per farlo.

Requisiti :

Stack LAMP.
PHP > 5.2.10
zlib è richiesta per la compressione/decompressione degli archivi fga.
zip è richiesta dalla classe ZipArchive.
gd è richiesta per il ridimensionamento delle immagini.
mcrypt è utilizzata per vari digest.
session è richiesta per l'utilizzo delle sessioni.

Funzionalità :

-- classloader : il classloader carica tutte le classi che terminano con estensione .class.php e .interface.php, ma solo quando
utilizzate dall'utente. Esso cerca la classi scansionando alcune cartelle predefinite. Esso inoltre modifica i percorsi
dell'include_path includendo la root del progetto.

-- file tipizzati. Questo framework utilizza alcune convenzioni per identificare i vari tipi di file in base a delle estensioni predefinite.

- .block.php
- .layout.php
- .config.php
- .class.php
- .interface.php

Alcuni di essi sono cercati solo in specifiche cartelle.

-- configurazione per host : la configurazione si basa sul nome dell'host ed è salvata all'interno
di '/include/config/mio_nome_host' (ad esempio i parametri per l'accesso al database che sono salvati dentro db.config.php).
I file di configurazione comuni a tutti gli host sono salvati nella cartella speciale '__common'.

-- supporto al database : questo framework offre 2 livelli di supporto per l'accesso al database. Il primo
è un insieme di classi helper per la creazione delle query, il secondo è un layer ActiveRecord.
Le classi ActiveRecord non hanno bisogno di alcun tipo di mapping. È sufficiente creare 2 classi, una che estende AbstractPeer e una
che estende AbstractDO, utilizzando una particolare convenzione di nomi e il tutto funziona automaticamente.
Al momento solo il database MySql è supportato, ma altri layer possono essere implementati.

-- gestione di file e cartelle : sono presenti alcune classi per aiutare nella gestione dei files (File) e
cartelle (Dir). Sono inoltre presenti classi per aiutare nella gestione di archivi zip, file csv (lavori in corso), 
file di properties, archivi del framework e storage sicuro.

-- immagini : sono presenti alcune classi che aiutano a gestire il ridimensionamento delle immagini.

-- pdf : è presente una classe che aiuta nella generazione dei pdf.

-- controller : È presente il supporto ai controller. Crea classi che estendono la classe AbstractController, aggiungi metodi
che sono automaticamente collegati a degli eventi ed essi saranno invocati quando il browser caricherà gli indirizzi nella forma
'/actions/<nome_controller>/<nome_azione>.<estensione>'. Non è richiesta alcuna configurazione per fare il mapping.
Sono presenti alcuni helper che aiutano nella formattazione dell'output per le estensioni più comuni.

-- viste : il framework ha un supporto per le viste basato su layout+sezioni+blocchi.

Praticamente ogni layout è un template, con all'interno alcune sezioni che variano da pagina a pagina. Un blocco è un pezzo di html, 
ma potrebbe essere anche un pezzo di php. Le sezioni sono specificate con dei segnaposto all'interno dei layout e poi definite all'interno
delle pagine utilizzando le funzioni 'start_section' e 'end_section'. Esse sono un po' come delle variabili all'interno dei layout renderizzate in un punto ben preciso.

-- supporto ai moduli : il framework supporta la presenza di moduli in modo molto simile a quello di composer. In pratica un modulo
è un insieme di file che possono essere agganciati/sganciati (installati e disinstallati) dalla root del progetto. La differenza principale rispetto a Composer è che in composer i file vengono copiati nella cartella '/vendor', mentre in Frozen, i file sono installati/disinstallati direttamente nella root. Il comportamento adottato in fase di installazione/disinstallazione è definito nel file 'module.xml' obbligatoriamente presente all'interno del modulo.

Il framework inoltre definisce un formato da utilizzare per specificare i moduli. La sintassi dei file xml è validabile in
base al file '/framework/modules/module.rnc'.

Inoltre un formato xml per gli aggiornamenti al database era in fase di sviluppo. La specifica è presente nel file
'/framework/modules/data-updates.rnc'.

-- sessione ad albero : la sessione ha una struttura ad albero, e tutti i dati salvati al suo interno hanno una struttura ad albero.

-- collezioni : sono presenti alcune classi helper per la gestione dei dati come DataHolder e Tree.

-- xml : sono presenti alcune classi che aiutano nella generazione di xml.

-- utilities : sono presenti alcune classi di aiuto per l'invio delle email.

Alcune parti sono vecchie || incomplete || non testate.


Installazione del framework : 

È necessario creare nella cartella in cui è presente la cartella 'framework' una cartella 'tmp' coi permessi di scrittura, e una cartella
'/include/storage/NOME_CASUALE' con i permessi di scrittura. Il file '.htaccess' deve essere presente nella root del progetto.

Inoltre la cartella '/framework/core/tests' deve avere i permessi di scrittura.

Unit test : 

I test sono implementati utilizzando il framework simpletest, incluso all'interno del framework.
È possibile lanciare i test puntando il browser all'indiritto :

http://virtual_host_name/framework/core/tests/all_tests.php

Alcuni test non sono abilitati se alcuni parametri non sono configurati (test col database).

Si possono abilitare seguendo queste istruzioni :

- creare un file .config.php in una directory col nome dell'host virtuale nella cartella 'include/config/',
per esempio è possibile chiamarlo db_tests.config.php, e definire alcune configurazioni al suo interno :

Config::instance()->TEST_DB_NAME = 'test_db_name'; //put your own
Config::instance()->TEST_DB_HOST = 'test_db_hostname'; //put your own
Config::instance()->TEST_DB_USERNAME = 'test_db_username'; //put your own
Config::instance()->TEST_DB_PASSWORD = 'test_db_password'; //put your own

Il database deve esistere prima di lanciare i test.

Inoltre alcune utilities sono presenti nella cartella '/framework/utilities/'.

Alcuni moduli sono inclusi nella distribuzione del framework.


Demo :

C'è una demo funzionante presente nella cartella 'demos'.
È possibile trovare le istruzioni per la configurazione della demo nella cartella 'setup' della demo, con il dump
del database necessario a farla funzionare. È un sito web che utilizza alcuni moduli per la visualizzazione dei prodotti
(le immagini reali sono state sostituite) e che utilizza alcuni layout. La parte di SuperAdmin è inoltre funzionante.

Roadmap (ordine sparso) :


- rimuovere dipendenze dalla classe BasicObject (fatto)
- integrare una nuova classe Logger (work in progress) 
- valutare lo sviluppo di classi per velocizzare lo sviluppo di siti web
- implementare chiamate di metodo data-driven utilizzando istanze delle classi DataHolder e Tree
- rinominare alcune cartelle come 'contenuti' e 'immagini' utilizzando nomi inglesi.
- aggiungere classi di supporto alle immagini e alla grafica
- effettuare test di vulnerabilità e tappare le falle di sicurezza
- rinominare la classe che gestisce gli archivi del framework e tutte le occorrenze (fatto - 14/Apr/2015)
- migliorare la documentazione aggiungendo le traduzioni in italiano (fatto - 14/Apr/2015)

Contatti :

web : http://www.mbcraft.it

mail : info [ at ] mbcraft [ dot ] it


-Marco Bagnaresi

[ENGLISH] *********************************************************************************

** 'Frozen' php framework - previously known as 'Charme-Crabs' **

Current version : 3.3.4

Warnings : 

This framework has some vulnerabilities. Use at your own risk.
I'll fix it if i have time for.

Requirements :

LAMP stack.
PHP > 5.2.10
zlib is required for compressing/uncompressing fga archives.
zip is required for ZipArchive class.
gd is required for image resizing.
mcrypt is required for message digests.
session is required for sessions.

apache must have mod_rewrite enabled.


Features :

-- classloader : the classloader loads all classes that ends with .class.php and
.interface.php, but only when used. It finds the class scanning some defined folders. It also
fixes the include_path adding the project root.

-- typed files. This framework uses by convention files with defined extension
in order to identify them:
- .block.php
- .layout.php
- .config.php
- .class.php
- .interface.php

Some of them are scanned only in defined folders.

-- host based configuration : configuration is based on hostname and placed
inside '/include/config/my_host_name/'  (for example, for db configuration
it uses the file 'db.config.php'). Common configuration goes to special '__common'
folder.

-- database support (model) : this framework has a builtin 2-level database access layer.
The first level is a raw query helper, the second is an ActiveRecord one.
This classes do not need any kind of mapping. Simply create a class
extending AbstractPeer and one extending AbstractDO, using a special naming scheme, and you're done. It works automatically.
Only MySql database is supported by now, but other db layers can be developed if needed.

-- file/folder management : some classes are implemented for helping working with files (File)
and directiories (Dir). There are also classes for zip archives, 
csv (work in progress), properties, framework archives and secure storage.

-- images : there are some helper classes for resizing images.

-- pdf : there is a class for pdf generation.

-- controller : framework has support for controllers. Extend the 'AbstractController', create methods that are linked to actions
and called when the user points to '/actions/<controller_name>/<action_name>.<extension>'. No mapping configuration is required. Automatic output generation
with default formatters is included.

-- views : this framework has a system based on layouts+blocks+sections.

Basically, a layout is a template with sections that are defined differently on each page.
A block is a piece of html, but it can also be a piece of php.
A section is defined using placeholders inside the layout, and specified in pages with the 'start_section' and 'end_section' functions. They are like variables inside layouts rendered in a specific place.

-- module support : This framework has an installable/uninstallable module system, similar to
Composer. Modules also have folders that are copied/removed from your project root.
The main difference from Composer (as far as i know) is that in Composer all files goes
to '/vendor'. In Frozen (previously Charme-Crabs), files and folders are added and removed from/to
the root project. All modules has a module.xml inside that defines its 
install/uninstall behaviour.

This framework also defines an xml format for modules. Syntax is validable 
against '/framework/modules/module.rnc'.

Also, an xml format for database updates was in development.
See '/framework/modules/data-updates.rnc'.

-- tree session : session has a tree structure.

-- collections : common DataHolder and Tree classes for working with data.

-- xml : xml build support classes.

-- utilities : helper classes for email, custom format for framework distributable archives, browser information and other.


Other parts are old || incomplete || untested.


Framework installation :

You need to create in the root folder a writable 'tmp' folder
 and also an 'include/storage/RANDOM_FOLDER_NAME' folder. The '.htaccess' file must be present in the project root.

Also, the folder /framework/core/tests/ should be writable too.

Unit tests :

Tests are implemented using simpletest framework, included with this 
framework.
You can run/check the unit tests pointing your browser to :

http://virtual_host_name/framework/core/tests/all_tests.php

Some tests are not enabled if some additional things are not set up (db tests).

If you want to enable them you should :

- create a .config.php file in a directory named as your virtual host in 'include/config/', 
you can call it eg. db_tests.config.php, and define some configs inside :

Config::instance()->TEST_DB_NAME = 'test_db_name'; //put your own
Config::instance()->TEST_DB_HOST = 'test_db_hostname'; //put your own
Config::instance()->TEST_DB_USERNAME = 'test_db_username'; //put your own
Config::instance()->TEST_DB_PASSWORD = 'test_db_password'; //put your own

The db must exist prior test running.

Also various utilities are present in the framework/utilities folder.

Some sample modules are also provider.

Roadmap (sparse order) :


- remove dependency from BasicObject class (done)
- integrate a new logger class. (work in progress) 
- evaluate development of classes to speedup accessible website development
- implement data driven method call with Tree and DataHolder objects.
- rename folders 'contenuti' and 'immagini' to with english names.
- do security checks and close some security related issues.
- rename the class of the framework archives and all the occurrencies (done - 14/Apr/2015)
- improve the documentation adding italian translations (done - 14/Apr/2015)

Contacts :

web : http://www.mbcraft.it

mail : info [ at ] mbcraft [ dot ] it


-Marco Bagnaresi
