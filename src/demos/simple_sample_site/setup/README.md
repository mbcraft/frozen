# ITALIANO

### Istruzioni :

Per configurare la demo, creare un database chiamato 'simple_sample_site', e caricare il dump
dentro di esso utilizzando il comando `mysql -u USERNAME_QUI -p simple_sample_site <dump_db.sql`.
Quindi modificare lo username e la password utilizzati per accedere al database in
base all'account presente, modificando il file presente in
'/demos/simple_sample_site/include/frozen_sss/db.config.php'.

Creare una nuova configurazione per apache, chiamata 'frozen_sss', che punta alla directory
'/demos/simple_sample_site' con un percorso assoluto.

Aggiungere un nuovo nome host chiamato 'frozen_sss' al file '/etc/hosts.

Creare un link che punta a '../../framework' chiamato 'framework' dentro la cartella
'/demos/simple_sample_site' se non è già presente, utilizzando il comando :
`ln -s ../../framework framework`.

Aggiungere il sito web configurato alla lista dei siti web attivi col comando :
`sudo a2ensite frozen_sss`.

Tutti i file del progetto 'Frozen' devono essere leggibili, le directory devono avere il permesso di esecuzione (accesso).
La directory '/demos/simple_sample_site/tmp/' inoltre deve avere i permessi di scrittura
per l'utente del processo di apache (o del web server utilizzato). È possibile usare il comando :

`chmod -R 775 *' and 'chmod -R 777 demos/simple_sample_site/tmp/`

dalla cartella 'src' in 'Frozen' per sistemare i permessi.

Poi puntare il browser su :

[SIMPLE_SAMPLE_SITE](http://frozen_sss/)

Tutto il sito web è in lingua inglese.

L'Admin al momento è solo in lingua italiana.

Per accedere al pannello di admin visitare la pagina :

[SIMPLE_SAMPLE_SITE ADMIN](http://frozen_sss/admin/)

Utente : simplesamplesite
Password : demo

(sono quelle salvate nel file '/demos/include/config/__common/admin.config.php')

Per accedere al pannello di installazione/disinstallazione dei moduli puntare il browser su:

[SIMPLE_SAMPLE_SITE FRAMEWORK ADMIN](http://frozen_sss/frozen/)

Il codice segreto è 'frzadmin'.

Un codice è richiesto qui, e il comportamento è definito dalla classe SuperAdminUtils che deve
essere implementata obbligatoriamente (quindi salvata col nome di 'SuperAdminUtils.class.php' 
e salvata ad esempio nella cartella 'lib') ed implementare i metodi :

* is_logged : controlla la sessione per sapere se l'utente è loggato, ritorna vero o false
* check_login : controlla il codice di login e ritorna vero se il codice è corretto, falso altrimenti
* set_logged : modifica la sessione in modo che la chiamata a is_logged ritorni vero alla prossima chiamata.

I moduli possono essere installati/disinstallati. Essi sono salvati nella cartella '/framework/modules'
in cartelle <categoria>/<sottocategoria> che li identificano.

Ogni modulo ha un file 'module.xml' al suo interno che contiene le azioni da intraprendere
durante le fasi di installazione/disinstallazione dei moduli, per esempio :

* copia queste cartelle
* crea queste tabelle
* ecc...

Le azioni 'install' e 'uninstall' sono sempre presenti nei moduli. Altre azioni possono essere definite, per esempio per rigenerare le tabelle o eseguire task occasionali.

Le specifiche dei moduli sono definite dal file '/framework/modules/module.rnc' .

# ENGLISH

### Instructions :

To setup the demo, create a database named 'simple_sample_site', and load the dump inside it using the 
`mysql -u USERNAME_HERE -p simple_sample_site <dump_db.sql` command.
Then fix the username and password of database access you can find in the
'/demos/simple_sample_site/include/frozen_sss/db.config.php' file. 

Create a new configuration for apache, named 'frozen_sss', pointing to the dir
'/demos/simple_sample_site' with an absolute path.

Add a new host named 'frozen_sss' to your '/etc/hosts' file.

A link pointing to '../../framework' named 'framework' must be setup in the
'/demos/simple_sample_site' dir (if not already present) with the command :
`ln -s ../../framework framework`.

Add the configured website to the active website with the command :
`sudo a2ensite frozen_sss`.

All files inside the 'Frozen' project must be readable, directory should have execution (access)
permission. The directory '/demos/simple_sample_site/tmp/' should also have write permissions
for apache process user. You can use the command :

`chmod -R 775 *' and 'chmod -R 777 demos/simple_sample_site/tmp/`

from the 'src' folder of the 'Frozen' folder to fix files permissions.

Then point your browser to :

[SIMPLE_SAMPLE_SITE](http://frozen_sss/)

you should see the website.

All web site is localized in english only.

Admin is currently in Italian only.

To access admin page, visit

[SIMPLE_SAMPLE_SITE ADMIN](http://frozen_sss/admin/)

User : simplesamplesite
Pass : demo

(they are saved inside '/demos/include/config/__common/admin.config.php')


To access the install/uninstall modules panel, point your browser to :

[SIMPLE_SAMPLE_SITE FRAMEWORK ADMIN](http://frozen_sss/frozen/)

The secret code is 'frzadmin'.

A code is requested, and behaviour is set in class SuperAdminUtils which must be implemented and saved in lib folder or subfolder as 'SuperAdminUtils.class.php'.
It has three methods : 

* is_logged - checks session if user is logged, returning true or false
* check_login - checks login code and returns true if correct, false otherwise 
* set_logged - changes session in order to let 'is_logged' return true on the next calls.

Modules can be installed/uninstalled. They are saved in '/framework/modules'
with a <category>/<subcategory> naming scheme mapped as folders.

Each module has a 'module.xml' containing actions executed when installing and uninstalling the module, eg :

* copy some folders
* create some tables
* ecc ...

Modules always has 'install' and 'uninstall' commands, but can also have custom commands, eg. for creating tables or do other tasks as requested.

Module specification is in '/framework/modules/module.rnc' .

**********************************************
