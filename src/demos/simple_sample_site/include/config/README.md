This folder contains config files. They are executed before routing is executed.
The "__common" folder is a special one : config files inside are executed in every domain,
while config files in other folders are executed only if the domain matches the domain name.
Eg : config files inside "frozen_sss" are loaded (executed) only if the hostname is "frozen_sss".
This is useful if you have different running environments (offline and online).
For example you can set a folder with name "www.mysite.com" and files inside are run only
if the url matches "www.mysite.com" (only hostname).