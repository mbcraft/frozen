<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

/*
 * Classe per effettuare installazioni e disinstallazioni di file o cartelle.
 */
class ModulePlug implements InitializeAfterLoad
{
    static $dummy_mode = false;

    static function __set_dummy_mode($dummy=true)
    {
        self::$dummy_mode = $dummy;
    }
    
    static function __classLoaded($class_name) 
    {
        self::$root_dir = new Dir("/");
    }
    
    private static $root_dir = null;
    
    private $module_dir;
    

    static function setRootDir($new_root)
    {
        if ($new_root instanceof Dir)
            self::$root_dir = $new_root;
        else
            self::$root_dir = new Dir($new_root);
    }
    
    static function getRootDir()
    {
        return self::$root_dir;
    }
    
    function __construct($module_dir)
    {
        if ($module_dir instanceof Dir)
            $this->module_dir = $module_dir;
        else
            $this->module_dir = new Dir($module_dir);

    }
    
    function getModuleDir()
    {
        return $this->module_dir;
    }

    /*
     * Esegue una action. Prende come parametro il tag action.
     * */
    function execute($commands)
    {
        foreach ($commands->children() as $tag_name => $tag)
        {
            $attributes = $tag->attributes();

            switch ($tag_name)
            {
                case "add" : $this->add($attributes->relative_path.""); break;
                case "remove" : $this->remove($attributes->relative_path."",isset($attributes->force) && "".$attributes->force=="true" ? true : false); break;
                case "mkdir" : $this->mkdir($attributes->relative_path.""); break;
                case "rmdir" : $this->rmdir($attributes->relative_path."",isset($attributes->force) && "".$attributes->force=="true" ? true : false); break;
                case "extract" : $this->extract($attributes->relative_archive_path,$attributes->extract_to); break;
                case "sql" : $this->execute_sql_if_found($attributes->name); break;
                case "script" : $this->run_script_if_found($attributes->name); break;
                case "create_or_update_table_fields" : $this->create_or_update_table_fields($tag); break;
                case "drop_table_fields" : $this->drop_table_fields($tag); break;
                case "drop_table" : $this->drop_table($tag); break;
                case "rename_table" : $this->rename_table($tag); break;
                case "create_or_update_view_fields" : $this->create_or_update_view_fields($tag); break;
                case "drop_view" : $this->drop_view($tag); break;
                case "insert_row" : $this->insert_row($tag); break;
                case "delete_row" : $this->delete_row($tag); break;
                case "create_or_update_do" : $this->create_or_update_do($attributes); break;
                case "drop_do" : $this->drop_do($attributes); break;

            }
        }
    }

    /*
     * Aggiunge i file prendendoli dal modulo nella cartella relativa alla root del sito
     */
    function add($file_or_folder)
    {
        if (self::$dummy_mode)
        {
            echo "Adding : ".$file_or_folder."<br />";
            return;
        }

        $root_dir_path = self::$root_dir->getPath();

        $file_or_folder = str_replace("\\", "/", $file_or_folder);

        $file_list = array();

        //se finisce con lo slash è una directory
        if (substr($file_or_folder, strlen($file_or_folder)-1,1)=="/") //directory
        {
            //creo la cartella
            $target_dir = new Dir(DS.$root_dir_path.$file_or_folder);
            $target_dir->touch();
            
            $source_dir = new Dir($this->module_dir->getPath().$file_or_folder);
            foreach ($source_dir->listFiles() as $elem)
            {
                if ($elem->isDir())
                    $file_list = array_merge($file_list,$this->add($file_or_folder.$elem->getName().DS));
                else
                    $file_list = array_merge($file_list,$this->add($file_or_folder.$elem->getFilename()));
            }
        }//altrimenti è un file
        else
        {
            $source_file = new File($this->module_dir->getPath().$file_or_folder);
            $target_file = new File($root_dir_path.$file_or_folder);
            
            $target_dir = $target_file->getDirectory();
            $target_dir->touch();
            
            $source_file->copy($target_dir);
            $file_list [] = $target_dir->newFile($source_file->getFilename())->getPath();
        }

        return $file_list;
    }

    /*
     * Aggiorna i campi di una tabella presente nel database o ne crea una nuova
     * */
    function create_or_update_table_fields($definition)
    {

        $field_factory = __MysqlTableFieldFactory::instance();
        $field_list = array();
        $rename_list = array();

        foreach ($definition as $tag_name => $tag)
        {
            $attr = $tag->attributes();

            switch ($tag_name)
            {
                case "primary_key":
                case "unique":
                case "fulltext":
                case "index": $field = $field_factory->{"create_".$tag_name}($attr->name); break;
                case "autoincrement_id": $field = $field_factory->{"create_".$tag_name}($attr->name,(isset($attr->null) && $attr->null=="true") ? true : false,isset($attr->comment) ? $attr->comment : null,isset($attr->after_col_or_first) ? $attr->after_col_or_first : null,isset($attr->rename_from)); break;
                case "external_id":
                case "text_16":
                case "text_32":
                case "text_64":
                case "text_128":
                case "text_512":
                case "text_1024":
                case "text_65k":
                case "text_big":
                case "bool":
                case "unsigned_int_8":
                case "unsigned_int_32":
                case "signed_int_8":
                case "signed_int_32":
                case "double":
                case "numeric":
                case "date":
                case "time":
                case "datetime":
                case "timestamp":$field = $field_factory->{"create_".$tag_name}($attr->name,(isset($attr->null) && $attr->null=="true") ? true : false,isset($attr->comment) ? $attr->comment : null,isset($attr->after_col_or_first) ? $attr->after_col_or_first : null); break;
                default: throw new InvalidParameterException("Il tag : ".$tag_name." non e' supportato.");
            }

            if (isset($attr->rename_from))
            {
                $rename_list["".$attr->rename_from] = $field;
            }
            else
            {
                $field_list[] = $field;
            }
        }

        //Flash::warning(count($rename_list));

        $table_name = $definition->attributes()->table_name;
        $db_desc = DB::newDatabaseDescription();

        //if (count($rename_list)>0 && $db_desc->hasTable($table_name))
        //    throw new IllegalStateException("Non è possibile creare la tabella se ci sono dei rename da effettuare!!");

        //aggiungere controllo su campi già presenti nella tabella e spostarli come change



        if (!$db_desc->hasTable($table_name))
        {
            $create_table = DB::newCreateTable($table_name);
            foreach ($field_list as $i => $definition)
            {
                $create_table->add_column($definition);
            }
            $create_table->exec();
        }
        else
        {

            if (count($field_list)>0 || count($rename_list)>0)
            {
                $alter = DB::newAlterTable($table_name);

                foreach ($field_list as $ix => $definition)
                {
                    $alter->add_column($definition);
                }


                foreach ($rename_list as $old_name => $definition)
                {
                    $alter->change_column($old_name,$definition);
                }
            }
            else
                Flash::warning("No fields found in field list!!");

        }

    }

    /*
     * Rimuove dei campi da una tabella
     * */
    function drop_table_fields($definition)
    {
        $table_name = $definition->attributes()->table_name;

        $drop_fields = DB::newAlterTable($table_name);
        foreach ($definition as $tag_name => $tag)
        {
            $drop_fields->drop_column($tag->attributes()->name);
        }
    }

    /*
     * Droppa una tabella
     * */
    function drop_table($definition)
    {
        $table_name = $definition->attributes()->table_name;

        $drop_table = DB::newDropTable($table_name);
        $drop_table->exec();
    }

    /*
     * Rinomina una tabella
     * */
    function rename_table($definition)
    {
        $source = $definition->attributes()->from;
        $new_name = $definition->attributes()->to;

        $rename_table = DB::newAlterTable($source);
        $rename_table->rename($new_name);
    }

    private function __load_import_fields($edit_view,$tag)
    {
        $table_name = "".$tag->attributes()->table_name;

        foreach ($tag as $tag_name => $tag_data)
        {
            if ($tag_name=="field")
            {
                $attr = $tag_data->attributes();

                $from = isset($attr->from) ? "".$attr->from : "".$attr->name;

                $edit_view->addViewField($table_name,$from,"".$attr->name);
            }
            else throw new InvalidDataException("Il tag ".$tag_name." non e' supportato all'interno del tag import_fields.");
        }
    }

    private function __load_join($edit_view,$tag)
    {
        $attr = $tag->attributes();

        $to_field = isset($attr->to_field) ? "".$attr->to_field : "".$attr->from_field;

        $edit_view->addJoinFields("".$attr->from_table,"".$attr->from_field,"".$attr->to_table,$to_field);
    }

    /*
     * Crea o modifica una vista
     * */
    function create_or_update_view_fields($definition)
    {
        $view_name = $definition->attributes()->view_name;
        $db_desc = DB::newDatabaseDescription();

        if (!$db_desc->hasTable($view_name))
        {
            $edit_view = DB::newCreateView($view_name);
        }
        else
        {
            $edit_view = DB::newAlterView($view_name);
        }

        foreach ($definition as $tag_name => $tag)
        {
            switch ($tag_name)
            {
                case "join": $this->__load_join($edit_view,$tag);break;
                case "import_fields": $this->__load_import_fields($edit_view,$tag);break;

                default: throw new InvalidParameterException("Il tag : ".$tag_name." non e' supportato.");
            }
        }

        $edit_view->exec();
    }

    /*
     * Cancella una vista
     * */
    function drop_view($definition)
    {
        $view_name = $definition->attributes()->view_name;

        $drop_view = DB::newDropView($view_name);
        $drop_view->exec();
    }

    /*
     * Inserisce una riga in una tabella
     * */
    function insert_row($definition)
    {
        $table_name = $definition->attributes()->to;

        $create = DB::newInsert($table_name);
        foreach ($definition as $tag_name => $tag)
        {
            $create->add($tag->attributes()->name,"".$tag);
        }
        $create->exec();
    }

    /*
     * Elimina una riga da una tabella
     * */
    function delete_row($definition)
    {

        $table_name = $definition->attributes()->from;

        $table_desc = DB::newTableFieldsDescription($table_name);

        $pk_fields = $table_desc->getPrimaryKeyFields();

        $delete = DB::newDelete($table_name);
        $delete->addConditionEquals($pk_fields[0],$definition->attributes()->id);
        $delete->exec();
    }

    /*
     * Estrare un archivio fga nella rispettiva cartella
     * */
    function extract($archive_file_path,$to_folder)
    {

        if (self::$dummy_mode)
        {
            echo "Extracting : ".$archive_file_path." to ".$to_folder."<br />";
            return;
        }

        $real_archive_file_path = new File($this->module_dir.DS.$archive_file_path);
        
        $real_folder = new Dir(self::$root_dir.DS.$to_folder);
        
        FGArchive::extract($real_archive_file_path, $real_folder);
    }

    /*
     * Rimuove tutti i file presenti all'interno di un modulo dalla root del sito
     * */
    function remove($file_or_folder,$force=false)
    {
        if (self::$dummy_mode)
        {
            echo "Removing : ".$file_or_folder."<br />";
            return;
        }

        $root_dir_path = self::$root_dir->getPath();
        
        //se è una cartella elimino solo i file che sono anche nel modulo
        if (FileSystemUtils::isDir($this->module_dir->getPath().$file_or_folder))
        {        
            $source_dir = new Dir($this->module_dir->getPath().$file_or_folder);
            $target_dir = new Dir($root_dir_path.$file_or_folder);
            if (!$target_dir->exists()) return;
            
            $toremove_files = $source_dir->listFiles();
            foreach ($toremove_files as $elem)
            {
                if ($elem->isDir())
                    $this->remove($file_or_folder.$elem->getName().DS);
                else
                    $this->remove($file_or_folder.$elem->getFilename());
                    
            }
            
            if ($target_dir->isEmpty())
                $target_dir->delete(false);
        }
        else    //se è un file lo elimino
        {           
            $source_file = new File($this->module_dir->getPath().$file_or_folder);
            
            $target_file = new File($root_dir_path.$file_or_folder);
            if (!$force && !$source_file->exists()) return;    //se non esiste nel modulo non lo rimuovo
            $target_file->delete();
        }
    }

    /*
     * Crea una cartella
     * */
    public function mkdir($dir)
    {
        if (self::$dummy_mode)
        {
            echo "Mkdir : ".self::$root_dir->getPath().$dir."<br />";
            return;
        }

        $d = new Dir(self::$root_dir->getPath().$dir);
        $d->touch();
    }

    /*
     * Elimina una cartella
     * */
    public function rmdir($dir,$force=false)
    {
        if (self::$dummy_mode)
        {
            echo "Rmdir : ".self::$root_dir->getPath().$dir."<br />";
            return;
        }

        $d = new Dir(self::$root_dir->getPath().$dir);
        if ((!$d->isEmpty() && $force) || $d->isEmpty())
            $d->delete(true);
    }

    /*
     * Esegue un file php se trovato
     * */
    public function run_script_if_found($nome_script,$parameters=array())
    {
        if (self::$dummy_mode)
        {
            echo "Run script if found : ".$this->module_dir->getPath()."/script/".$nome_script.".php<br />";
            return;
        }


        extract($parameters);
        $f = new File($this->module_dir->getPath()."/script/".$nome_script.".php");
        if ($f->exists())
        {
            include ($f->getIncludePath());

            return true;
        }
        else return false;
    }

    /*
     * Esegue un file sql se trovato
     * */
    function execute_sql_if_found($nome_script)
    {
        if (self::$dummy_mode)
        {
            echo "Execute sql if found : ".$this->module_dir->getPath()."/sql/".$nome_script.".sql<br />";
            return;
        }

        $script_file = new File($this->module_dir->getPath()."/sql/".$nome_script.".sql");
        
        if ($script_file->exists())
        {
            $script_sql = $script_file->getContent();

            $direct_sql_query = DB::newDirectSql($script_sql);
            $direct_sql_query->exec();

            return true;
        }
        else
            return false;
    }

    /*
     * Crea o aggiorna DO e relativo Peer.
     * */
    function create_or_update_do($attributes)
    {
        $name = $attributes->name;
        $location = $attributes->location;
        $table_name = $attributes->table_name;

        $do_file_name = $name."DO.class.php";
        $peer_file_name = $name."Peer.class.php";

        $d = new Dir($location);
        $d->touch();

        $do_file = $d->newFile($do_file_name);
        $do_file->setContent("<?php
        class ".$name."DO extends AbstractDO {}
?>");
        $peer_file = $d->newFile($peer_file_name);
        $peer_file->setContent("<?php
        class ".$name."Peer extends AbstractPeer 
        {
            function __getMyTable()
            {
                return \"".$table_name."\";
            }
        }
?>");
    }

/*
 * Elimina un DO e relativo Peer
 * */
    function drop_do($attributes)
    {
        $name = $attributes->name;
        $location = $attributes->location;

        $do_file_name = $name."DO.class.php";
        $peer_file_name = $name."Peer.class.php";

        $d = new Dir($location);
        $do_file = $d->newFile($do_file_name);
        $do_file->delete();
        $peer_file = $d->newFile($peer_file_name);
        $peer_file->delete();
        $d->delete();
    }
}

?>