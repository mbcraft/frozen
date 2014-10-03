<?php

/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

class DecorationPattern implements IActiveRecordPattern
{
    private $entity_type_field_name;
    private $entity_id_field_name;
    
    function __construct($entity_type_field_name,$entity_id_field_name)
    {
        $this->entity_type_field_name = $entity_type_field_name;
        $this->entity_id_field_name = $entity_id_field_name;
    }
    
    function needs_apply($peer,$object)
    {
        if (isset($object[$this->entity_type_field_name]) && $object[$this->entity_type_field_name]!=null && isset($object[$this->entity_id_field_name]) && $object[$this->entity_id_field_name]!=null && !isset($object[$object[$this->entity_type_field_name]]))
            return true;
        else
            return false;
    }
    
    function apply($peer,$object)
    {
        $type = $object[$this->entity_type_field_name];
        $id = $object[$this->entity_id_field_name];
        $decoration_peer = __create_instance(StringUtils::underscored_to_camel_case($type."_peer"));
        $decoration = ActiveRecordUtils::toArray($decoration_peer->find_by_id($id));
        $object[$this->entity_type_field_name] = $decoration;
        
        return array($peer,$object);
    }
    
    function get_pointcut()
    {
        return ActiveRecordPatterns::AFTER_SELECT_POINTCUT;
    }
}

?>