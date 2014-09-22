<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

class ControllerCall
{
    private $controller = null;
    private $action = null;
    private $format = null;
    private $params = null;

    function get_controller()
    {
        return $this->controller;
    }

    function get_action()
    {
        return $this->action;
    }

    function get_format()
    {
        return $this->format;
    }

    function get_params()
    {
        return $this->params;
    }

    private $format_helper = null;

    private $action_result_was_null = false;
    private $execute_action = true;
    private $action_result = null;
    private $is_error = false;

    protected function __before_dispatch_action() {}

    protected function __after_dispatch_action() {}

    protected function __before_action() {}

    /*
     * Metodo per azione non trovata : di default restituisce la pagina.
    */
    protected function __action_not_found()
    {
        Log::warn("__action_not_found", "Azione non trovata nel controller ".get_class()." : ".$this->action);
    }

    protected function __action_result_null()
    {
        Log::warn("__action_result_null", "L'azione ha ritornato null");
        return null;
    }

    protected function __after_action() {}

    /*
     * Utilizzato per saltare la action e fornire un risultato immediatamente.
     */
    protected final function __skip_action($alternative_result)
    {
        $this->execute_action = false;
        $this->action_result = $alternative_result;
    }

    private function __check_reserved_action($action)
    {
        if (strpos($action, "__")===0) {
            Log::error(__METHOD__, "Tentativo di invocare una action con un nome riservato ($action).Formato : ".$this->format);
        }
    }

    private function __check_protected_action($action,$format)
    {
        if (strpos($action, "__")!==0 && strpos($action, "_")===0) {
            Log::error(__METHOD__, "Tentativo di invocare una action protetta ($action).Formato : ".$format);
        }
    }

    function __construct($controller_name,$action,$format,$params)
    {
        //vecchio setup, e' stata aggiunta la creazione del controller
        $this->controller = ControllerFactory::create($controller_name);
        //hack per supportare i vecchi mapping con "php".
        //$format = DataFormatManager::getFormatString($format);

        $this->__check_reserved_action($action);
        if ($format!=="raw")
            $this->__check_protected_action($action,$format);

        DataFormatManager::checkFormatSupported($format);

        $this->action = $action;
        $this->format = $format;
        $this->params = $params;

        $this->format_helper = DataFormatManager::getFormat($format);

        $this->execute_action = true;
        $this->action_result = null;
    }

    function execute()
    {
        Params::push();
        //callback a cui è possibile linkarsi
        $this->__before_dispatch_action();   //posso agire su action, format e params ...

        $this->__execute_action();

        //trasformo i dati ...
        if ($this->is_error)
                $final_result = $this->format_helper->formatError($this->action_result);
            else
                $final_result = $this->format_helper->formatOutputData($this->action_result);

        //callback a cui è possibile linkarsi
        $this->__after_dispatch_action();   //da vederne ancora l'utilizzo, eventualmente concatenare altre azioni??

        Params::pop();
        //tolgo i parametri dalla pila

        if ($final_result instanceof IActionCommand)
        {
            $final_result->execute();
            return null;
        }
        else
            return $final_result;
    }

    function __execute_action()
    {
        //chiamo prima della action sul controller
        //prima cosa, preparo i parametri

        $this->format_helper->loadInputData($this->params);
        //ok

        //callback a cui è possibile linkarsi
        $this->__before_action(); // agisco sui Params

        if ($this->execute_action)
        {
            //invoco il metodo. Non esiste? Sara' invocato __action_not_found
            $this->action_result_was_null = false;

            try
            {
                //eseguo la call
                $tmp_result = $this->controller->{$this->action}();

                //la action non ha dato risultati? invoco il metodo __action_result_null()
                if ($tmp_result===null)
                {
                    $this->__warn("__dispatch_action", "The action result was null ...");
                    $this->action_result_was_null = true;
                    $tmp_result = $this->__action_result_null();
                }

                $this->action_result = $tmp_result;
                $this->is_error = false;
            }
            catch (Exception $ex)
            {
                $this->action_result = $ex;
                $this->is_error = true;
            }

            //callback a cui è possibile linkarsi
            $this->__after_action(); //agisco sui dati dopo l'azione, i parametri sono ancora al loro posto ...

        }
    }

    function __action_result()
    {
        return $this->action_result;
    }

}

?>