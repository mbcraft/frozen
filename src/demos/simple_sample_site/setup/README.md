Instructions :

To setup the demo, create a database named 'simple_sample_site', and load the dump inside it.
Then fix the username and password of database access you can find in the
'/demos/simple_sample_site/include/frozen_sss/db.config.php' file. 

Create a new configuration for apache, named 'frozen_sss', pointing to the dir
'/demos/simple_sample_site' with an absolute path.

Add a new host named 'frozen_sss' to your '/etc/hosts' file.

A link pointing to '../../framework' named 'framework' must be setup in the
'/demos/simple_sample_site' dir (if not already present) with the command :
'ln -s ../../framework framework'.

Add the configured website to the active website with the command :
sudo a2ensite frozen_sss

All files inside the 'Frozen' project must be readable, directory should have execution (access)
permission. The directory '/demos/simple_sample_site/tmp/ should also have write permission
for apache process user. You can use the command :

'chmod -R 775 *' and 'chmod -R 777 demos/simple_sample_site/tmp/'

from the root of the 'Frozen' folder to fix files permissions.

Then point your browser to :

http://frozen_sss/

you should see the website.

All web site is localized in english only.

Admin is currently in Italian only.

To access admin page, visit

http://frozen_sss/admin/

User : simplesamplesite
Pass : demo

(they are saved inside '/demos/include/config/__common/admin.config.php')


To access the module install/uninstall pages, point your browser to :

http://frozen_sss/frozen/

The secret code is 'frzadmin'.

A code is requested, and behaviour is set in class SuperAdminUtils which must be implemented and saved in lib folder or subfolder as 'SuperAdminUtils.class.php'.
It has three methods : 
is_logged - checks session if user is logged, returning true or false
check_login - checks login code and returns true if correct, false otherwise 
set_logged - changes session in order to let 'is_logged' return true on the next calls.

Modules can be installed/uninstalled. They are saved in '/framework/modules'
with a <category>/<subcategory> naming scheme mapped as folders.

Each module has a module.xml containing instruction for installing and uninstalling the module, eg :
folders to copy
tables to create
ecc ...

Modules always has 'install' and 'uninstall' commands, but can also have custom commands, eg. for creating tables or do other tasks as requested.

Module specification is in /framework/modules/module.rnc .

**********************************************
