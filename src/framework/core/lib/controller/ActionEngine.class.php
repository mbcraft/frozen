<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

class ActionEngine implements IEngine
{
    function __construct()
    {
        RouteMap::def("/actions/*word*/*word*.*word*",1,2,3);
    }

    public function acceptRequest()
    {
        if (strpos(Request::getRequestPart(),"/actions/")===0)
        {
            return true;
        }
        else return false;
    }

    private function initializeDatabase()
    {
        $db_name = Config::instance()->{IDBConfigKeys::DEFAULT_DB_NAME};
        $db_hostname = Config::instance()->{IDBConfigKeys::DEFAULT_DB_HOSTNAME};
        $db_username = Config::instance()->{IDBConfigKeys::DEFAULT_DB_USERNAME};
        $db_password = Config::instance()->{IDBConfigKeys::DEFAULT_DB_PASSWORD};
        $db_persistent_connection = Config::instance()->{IDBConfigKeys::DEFAULT_DB_PERSISTENT_CONNECTION};

        DB::openConnection($db_name,$db_hostname,$db_username,$db_password,$db_persistent_connection);
    }

    private function disposeDatabase()
    {
        DB::closeConnection();
    }

    public function executeRequest()
    {
        $this->initializeDatabase();
        
        Session::init();
        Flash::__load_from_session();

        RouteMap::init();
        RouteMap::dispatch();

        Flash::__save_to_session();
        Session::save();

        $this->disposeDatabase();
    }
    
}

?>