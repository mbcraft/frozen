Warnings : 

This framework has some vulnerabilities. Use at your own risk.
I'll fix it if i have time for.

Requirements :

LAMP stack.
PHP > 5.2.10
zlib is required for compressing/uncompressing modules.
zip is required for ZipArchive class.
gd is required for image resizing.
mcrypt is required for message digests.
session is required.

apache must have mod_rewrite enabled.


Features :

-- classloader : the classloader loads all classes that ends with .class.php and
.interface.php. It finds the class scanning some defined folders. It also
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
inside '/include/config/my_host_name/', and for example, for db configuration
it uses the file 'db.config.php'. Common configuration goes to '__common'
folder.

-- database support (model) : this framework has a builtin 2-level database access layer.
The first level is a raw query helper, the second is an ActiveRecord one.
This classes do not need any kind of mapping. Simply create a class
extending AbstractPeer and one extending AbstractDO and you're done.

-- io : some classes are implemented for helping working with files (File)
and directiories (Dir). There are also classes for zip archives, 
csv (work in progress), properties, and secure storage.

-- images : there are some helper classes for resizing images.

-- pdf : there is a class for pdf generation.

-- controller : this class has controllers and automatic output generation
with default formatters.

-- views : this framework has a system based on layouts+blocks+sections.

Basically, a layout is a template with holes.
A block is a piece of html.
A section is a definition of a variable. Variable are used inside layouts.

-- module support : This framework has an installable/uninstallable module system, similar to
Composer. Modules also have folders that are nested/removed from your project.
The main difference from Composer (but i'm not an expert, this framework
was created before Composer i think) is that in Composer all things goes
to '/vendor'. In Charme-Crabs, files and folders are added and removed from/to
the root project. All modules has a module.xml inside that defines its 
install/uninstall behaviour.

This framework also defines an xml format for modules. Syntax is validable 
against '/framework/core/modules/module.rnc'.

Also, an xml format for database updates was in development.
See '/framework/core/modules/data-updates.rnc'.

-- tree session : session has a tree structure.

-- collections : common DataHolder and Tree classes for working with data.

-- xml : xml build support classes.

-- utilities : helper classes for email, custom format for framework distributable archives, browser information and other.


Other parts are old || incomplete || untested.


Installation :

You need to create in the root folder a writable 'tmp' folder
 and also an 'include/storage/RANDOM_FOLDER_NAME' folder.

Also, the folder /framework/core/tests/ should be writable too.

You can check the unit tests pointing your browser to :

http://virtual_host_name/framework/core/tests/all_tests.php

Also various utilities are present in the framework/utilities folder.

Some sample modules are also provider.

Roadmap :


- remove dependency from BasicObject class and integrate a new logger class. 


-Marco Bagnaresi
