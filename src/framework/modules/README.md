# Italiano

Questa cartella contiene le varie categorie dei moduli. I moduli sono definiti secondo lo schema
"categoria/nome" che rispecchia le cartelle presenti. All'interno di ogni modulo è presente
un file 'module.xml' che contiene le definizioni delle azioni da intraprendere quando un
modulo viene installato e disinstallato, ma anche di altre azioni personalizzate. Al momento
sono disponibili le seguenti operazioni :

* add : aggiunge la cartella specificata dal parametro alla root.
* remove : rimuove i file presenti nella cartella specificata dal parametro dalla root.I file non presenti nel modulo non vengono eliminati. 
* mkdir : crea una directory nella root.
* rmdir : cancella una directory dalla root.
* extract : estrare un archivio del framework nel percorso specificato.
* script : esegue uno script php.
* sql : esegue l'sql nel database del sito.
* create_or_update_table_fields : crea o aggiorna dei campi di una tabella.
* drop_table : elimina una tabella.
* create_or_update_view_fields : crea o aggiorna i campi di una vista.
* drop_view : elimina una vista.
* rename_table : rinomina una tabella.
* drop_table_fields : rimuove delle colonne da una tabella.
* insert_row : aggiunge una riga ad una specifica tabella.
* delete_row : elimina una riga da una specifica tabella.
* create_or_update_do : crea o aggiorna un data object.
* delete_do : elimina un data object.

Vedere il file 'module.rnc' per ulteriori dettagli.

Il file di specifica 'data-updates.rnc' non è ancora completo.

# English

This folder contains various subfolders. Modules are defined following the naming
scheme "category/name" that maps the folders. Within each module there is a
 'module.xml' file that contains the action definitions to execute when a module is
installed or uninstalled, but also other customizable actions. Now the following
operations are available :

* add : copy files from a to the root specified by the provided parameter.
* remove : removes files from the root that are also present inside the specified folder inside the module. 
* mkdir : creates a directory relative to the root.
* rmdir : removes a directory relative to the root.
* extract : extracts a framework archive inside the specified path.
* script : executes a php script.
* sql : executes an sql inside the web site database.
* create_or_update_table_fields : creates or updates fields inside a table.
* drop_table : deletes a table.
* create_or_update_view_fields : creates or updates a view.
* drop_view : deletes a view.
* rename_table : renames a table.
* drop_table_fields : removes fields from a table.
* insert_row : inserts a row inside a table.
* delete_row : deletes a row from a table.
* create_or_update_do : creates or updates a data object.
* delete_do : deletes a data object.

See 'module.rnc' for further details.

The 'data-updates.rnc' specification is not yet complete.