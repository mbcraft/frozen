[ITALIANO]

Questa cartella contiene i layout. Essi sono file con estensione ".layout.php".
Essi sono template con sezioni customizzabili all'interno. I contenuti customizzabili sono
segnati con dei marcatori che utilizzano la notazione ##percorso##, ad es. ##/intestazione/sinistra## dentro
l'html della pagina e sono definiti nella pagina utilizzando le funzioni "start_content($path)"
ed "end_content()".
Per esempio, per definire il contenuto del segnaposto "##/intestazione/sinistra## all'interno
della pagina, la funzione da chiamare è : start_content("/intestazione/sinistra"); .
Una volta terminato il contenuto lo sviluppatore deve chiamare la funzione "end_content();".

[ENGLISH]

This folder contains layouts. They are files with extension ".layout.php". They are
templates with custom sections inside. Custom content placeholders is expressed
with the notation ##path##, eg. ##/header/left## and set inside the page
with the function "start_content($path)" and "end_content()".
For example, for setting the content with of placeholder ##/header/left## inside the
page file the function call is : start_content("/header/left"); .
When content of the section is finished developer should call function "end_content();".
