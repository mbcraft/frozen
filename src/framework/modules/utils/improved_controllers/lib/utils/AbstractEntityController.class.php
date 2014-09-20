<?
/* This software is released under the BSD license. Full text at project root -> license.txt */

abstract class AbstractEntityController extends AbstractController
{
    abstract function __myPeer();
    
    abstract function __createMessage();
    abstract function __modifyMessage();
    abstract function __deleteMessage();

    function __additionalCreateLogic($do) {}
    function __additionalModifyLogic($do) {}
    function __additionalDeleteLogic($do) {}

    function __createErrors() { return null; }
    function __modifyErrors() { return null; }
    function __deleteErrors() { return null; }

    protected function __dump_enabled()
    {
        return false;
    }

    function new_empty()
    {
        $peer = $this->__myPeer();
        return ActiveRecordUtils::toArray($peer->new_do());
    }

    function index()
    {
        $peer = $this->__myPeer();

        if ($this->__dump_enabled())
            $peer->__dump_sql();

        ActiveRecordUtils::updateFilters($peer);
        $all_results = $peer->find();

        return ActiveRecordUtils::toArray($all_results);
    }

    function count()
    {
        $peer = $this->__myPeer();

        if ($this->__dump_enabled())
            $peer->__dump_sql();

        ActiveRecordUtils::updateFilters($peer);
        $num_contents = $peer->count("*");

        return array("count" => $num_contents);
    }

    function get()
    {
        $peer = $this->__myPeer();

        if ($this->__dump_enabled())
            $peer->__dump_sql();

        $pk_fields = $peer->__getPrimaryKeyFields();

        if (Params::is_set($pk_fields[0]))
        {
            $do = $peer->find_by_id(Params::get($pk_fields[0]));
        }
        else
        {
            ActiveRecordUtils::updateFilters($peer);
            $results = $peer->find();
            if (count($results)>0)
                $do = $results[0];
            else
                $do = null;
        }

        return ActiveRecordUtils::toArray($do);
    }

    function create()
    {
        $error_messages = $this->__createErrors();

        if (!$error_messages)
        {
            $peer = $this->__myPeer();

            if ($this->__dump_enabled())
                $peer->__dump_sql();

            $do = $peer->new_do();

            $peer->setupByParams($do);
            $this->__additionalCreateLogic($do);

            $peer->save($do);
        }
        
        return $this->__defaultReturn($this->__createMessage(),$error_messages);
    }

    function modify()
    {
        $error_messages = $this->__modifyErrors();

        if (!$error_messages)
        {
            $peer = $this->__myPeer();

            if ($this->__dump_enabled())
                $peer->__dump_sql();

            $do = $peer->updateByParams();
            $this->__additionalModifyLogic($do);
            $peer->save($do);
        }

        return $this->__defaultReturn($this->__modifyMessage(),$error_messages);
    }

    function delete()
    {
        $peer = $this->__myPeer();

        if ($this->__dump_enabled())
            $peer->__dump_sql();

        $error_messages = $this->__deleteErrors();

        $primary_key_fields = $peer->__getPrimaryKeyFields();

        if (!$error_messages)
        {

            $do = $peer->find_by_id(Params::get($primary_key_fields[0]));
            $this->__additionalDeleteLogic($do);
            $peer->delete($do);
        }
        return $this->__defaultReturn($this->__deleteMessage(),$error_messages);
    }

    function __defaultReturn($success_message, $error_messages)
    {
        if (is_html())
        {
            if (!$error_messages)
            {
                Flash::ok($success_message);
                return Redirect::success();
            }
            else
            {
                foreach ($error_messages as $error_msg)
                    Flash::error($error_msg);
                return Redirect::failure();
            }
        }
        else
        {
            if (!$error_messages)
                return Result::ok();
            else
                return Result::error($error_messages);
        }
    }

}


?>