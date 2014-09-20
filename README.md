Warnings : 

This framework has some vulnerabilities. Use at your own risk.
I'll fix it if i have time for.

Requirements :

LAMP stack.
PHP > 5.2.10
Some common modules. gd for image resizing.

Features :

This framework has an installable/uninstallable module system, similar to
Composer. Modules also have folders that are nested/removed from your project.
The main difference from Composer (but i'm not an expert, this framework
was created before Composer i think) is that in Composer all things goes
to '/vendor'. In Charme-Crabs, files and folders are added and removed from/to
the root project.

This framework also defines an xml format for modules. Syntax is validable 
against '/framework/core/modules.rnc'.

Installation :

You need to create in the root folder a writable 'tmp' folder
 and also an 'include/storage/RANDOM_FOLDER_NAME' folder.

You can check the unit tests pointing your browser to :

http://virtual_host_name/framework/core/tests/all_tests.php

Also various utilities are present in the framework/utilities folder.

Some sample modules are also provider.

Roadmap :

- remove dependency from BasicObject class.
- integrate a new logger class. 


-Marco Bagnaresi
