<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

/*
 *
 * Una definizione di routing è composta nel modo seguente :
 * spec + controller_def + action_def + params_ref
 *
 * La spec definisce l'url, gli altri elementi definiscono come vengono composti o determinati controller, action, format e params.
 */
class RouteDefinition
{
    const MATCH_OPTIONAL_SLASH = "*opt_slash*";
    const MATCH_OPTIONAL_SLASH_REGEXP = "([\/]?)";

    const MATCH_ANY_CHAR = "***";
    const MATCH_ANY_CHAR_REGEXP = "([^\/]+?)";

    const MATCH_NO_DOTS = "*no_dot*";
    const MATCH_NO_DOTS_REGEXP = "([^\/\.]+?)";

    const MATCH_INTEGER = "*num*";
    const MATCH_INTEGER_REGEXP = "(\d+?)";
    
    const MATCH_WORD = "*word*";
    const MATCH_WORD_REGEXP = "(\w+?)";

    private static $match_replace = array( self::MATCH_OPTIONAL_SLASH => self::MATCH_OPTIONAL_SLASH_REGEXP,
                                           self::MATCH_NO_DOTS => self::MATCH_NO_DOTS_REGEXP,
                                           self::MATCH_ANY_CHAR => self::MATCH_ANY_CHAR_REGEXP,
                                           self::MATCH_INTEGER => self::MATCH_INTEGER_REGEXP,
                                           self::MATCH_WORD => self::MATCH_WORD_REGEXP);

    private $is_def;
    private $definition;

    const DEFAULT_CONTROLLER_DEF="***";
    private $controller_def;

    const DEFAULT_ACTION_DEF = "***";
    private $action_def;

    const DEFAULT_FORMAT_DEF = "***";
    private $format_def;
    
    private $final_pattern; //contiene il pattern finale col quale controllare l'url

    public function __construct($definition_or_pattern,$is_def,$controller_def=self::DEFAULT_CONTROLLER_DEF,$action_def=self::DEFAULT_ACTION_DEF,$format_def=self::DEFAULT_FORMAT_DEF)
    {
        $this->is_def = $is_def;
        if ($is_def)
        {
            $this->definition = $definition_or_pattern;
            $this->__setup_with_magic_pattern();
        }
        else
            $this->final_pattern = $definition_or_pattern;

        $this->controller_def = $controller_def;
        $this->action_def = $action_def;
        $this->format_def = $format_def;        
    }

    private function __setup_with_magic_pattern()
    {
        $definition = $this->definition;

        //rimpiazzo i caratteri speciali che sono . + e /
        $definition = str_replace(".","\.",$definition);
        $definition = str_replace("+","\+",$definition);
        $definition = str_replace("/","\/",$definition);

        //rimpiazzo i valori speciali per il match
        foreach (self::$match_replace as $key => $value)
            $definition = str_replace ($key, $value, $definition);

        //creo il pattern specificando che il match deve essere fatto su TUTTO L'URL.
        $definition = "/^".$definition."$/";

        //ho il pattern definitivo
        $this->final_pattern .= $definition;
    }

    function getMatch($request_uri)
    {
        if ($this->matches($request_uri))
        {
            $parts = explode("?",$request_uri);

            $url = $parts[0];
            
            $result = preg_match_all($this->final_pattern,$url,$matches,PREG_SET_ORDER);

            if (is_numeric($this->controller_def))
                $controller = $matches[0][(int)$this->controller_def];
            else
                $controller = $this->controller_def;

            if (is_numeric($this->action_def))
                $action = $matches[0][(int)$this->action_def];
            else
                $action = $this->action_def;

            if (is_numeric($this->format_def))
                $format = $matches[0][(int)$this->format_def];
            else
                $format = $this->format_def;

            /*
            $params = array();
            foreach ($this->params_def as $k => $v)
            {
                if (is_int($v))
                    $params[$k] = $matches[0][$v-1];
                else
                    $params[$k] = $v;
            }
             */

            return new RouteMatch($controller, $action, $format);

        }
        else $this->__error("getMatch","Errore nella funzione di match della definizione.");
    }

    function matches($request_uri)
    {
        $parts = explode("?",$request_uri);

        $url = $parts[0];

        return preg_match($this->final_pattern, $url)!=0;
    }

    public function dump()
    {
        if ($this->is_def)
            return $this->definition." -> ".$this->final_pattern;
        else
            return "PATTERN ONLY -> ".$this->final_pattern;
    }

    public function getMatchingPattern()
    {
        return $this->final_pattern;
    }

}


?>