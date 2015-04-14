# ITALIANO

Questa cartella contiene i file di configurazione relativi al dominio. Essi sono eseguiti
prima dell'esecuzione del routing.
La cartella "__common" è speciale : i file di configurazione al suo interno sono sempre caricati.
I file presenti nelle altre cartelle sono caricati ed eseguiti solo se il nome host combacia col nome della cartella.
es: i file di configurazione dentro "frozen_sss" sono caricati (eseguiti) solo se il nome host è "frozen_sss".
Questo è utile quando ci sono vari ambienti di esecuzione (locale e remoto) e non si vogliono modificare i file del progetto in remoto.
Per esempio è possibile creare la cartella col nome "www.miosito.com" e i file al suo interno sono eseguiti solo
se il nome host è "www.miosito.com" (solo il nome host viene considerato).

# ENGLISH

This folder contains domain related config files. They are executed before routing is executed.
The "__common" folder is a special one : config files inside are executed in every domain,
while config files in other folders are executed only if the domain matches the domain name.
Eg : config files inside "frozen_sss" are loaded (executed) only if the hostname is "frozen_sss".
This is useful if you have different running environments (local and remote) and you don't want to alter files remotely.
For example you can set a folder with name "www.mysite.com" and files inside are run only
if the url matches "www.mysite.com" (only hostname is used for evaluation).