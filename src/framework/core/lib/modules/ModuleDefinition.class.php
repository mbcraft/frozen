<?php

/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

class ModuleDefinition
{
    private $nome_categoria;
    private $nome_modulo;

    private $data;
    private $my_path;

    function __construct($nome_categoria,$nome_modulo,$data)
    {
        $this->nome_categoria = $nome_categoria;
        $this->nome_modulo = $nome_modulo;

        $this->data = $data;
    }

    function get_data()
    {
        return $this->data;
    }

    function get_category_name()
    {
        return $this->nome_categoria;
    }

    function get_module_name()
    {
        return $this->nome_modulo;
    }

    function get_path()
    {
        return $this->my_path;
    }
    
    function get_show()
    {
        if  (isset($this->data->attributes()->show))
            return $this->data->attributes()->show=="true";
        else 
            return true;
    }

    function get_current_version()
    {
        $a = $this->data->attributes();
        return array("major_version" => $a->major,"minor_version" => $a->minor , "revision" => $a->rev);
    }

    function get_description()
    {
        return $this->data->description;
    }

    function get_provided_services()
    {
        if (isset($this->data->{"provided-services"}))
        {
            $result = array();
            foreach ($this->data->{"provided-services"}->service as $key => $node)
            {
                $result[] = "".$node->attributes()->name;
            }
            return $result;
        } else return array();
    }

    function get_required_services()
    {
        if (isset($this->data->{"required-services"}))
        {
            $result = array();
            foreach ($this->data->{"required-services"}->service as $key => $node)
            {
                $result[] = "".$node->attributes()->name;
            }
            return $result;
        } else return array();
    }

    function get_required_modules()
    {
        if (isset($this->data->{"required-modules"}))
        {
            $result = array();
            foreach ($this->data->{"required-modules"}->module as $key => $node)
            {
                $result[] = "".$node->attributes()->name;
            }
            return $result;
        } else
        {
            return array();
        }
    }

    function get_missing_required_modules($all_installed_modules)
    {
        return array_diff($this->get_required_modules(),$all_installed_modules);
    }

    function get_missing_required_services($all_provided_services)
    {
        return array_diff($this->get_provided_services(),$all_provided_services);
    }

    function get_action_data($action_name)
    {
        $xpath = "/module-declaration/actions/action[@name=\"".$action_name."\"]";

        $result = $this->data->xpath($xpath);

        return $result[0];
    }

    function get_available_actions()
    {
        $result = array();

        $actions = $this->data->xpath("/module-declaration/actions");

        if ($actions!=null)
        {
            $real_actions = $actions[0];

            foreach ($real_actions->action as $tag_name => $data)
            {
                $result[] = "".$data->attributes()->name;
            }

        }

        return $result;
    }
}

?>