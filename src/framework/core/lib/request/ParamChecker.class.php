<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */
class ParamChecker
{
    const NOT_NULL = 0x01;
    const NOT_ZERO = 0x02;
    const NOT_EMPTY = 0x04;
    const VALID_ID = 0x08;

    public static function checkWithFlags($var,$name,$flags,&$result = array())
    {       
        if (($flags&self::NOT_NULL)!=0)
            self::checkNotNull ($var, $name,$result);
        
        
        if (($flags&self::NOT_ZERO)!=0)
            self::checkNotZero ($var, $name ,$result);
        
        
        if (($flags&self::NOT_EMPTY)!=0)
            self::checkNotEmpty ($var, $name ,$result);
        

        if (($flags&self::VALID_ID)!=0)
            self::checkValidId ($var, $name ,$result);
        
    }

    public static function checkNotNull($var,$name,&$result=array())
    {
        if ($var===null)
            $result[] = "Il valore ".$name." è nullo!";
    }

    public static function checkNotZero($var,$name,&$result=array())
    {
        if ($var===0)
            $result[] = "Il valore ".$name." è zero!";
    }

    public static function checkNotEmpty($var,$name,&$result = array())
    {
        if (empty($var))
            $result[] = "Il valore ".$name." è vuoto!";
    }

    public static function checkValidId($var,$name,&$result = array())
    {
        if ($var<=0)
            $result[] = "Il valore ".$name." non è un id valido!";
    }
    
    public static function checkValidEmail($var,$name,&$result = array())
    {
        if (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email))
            $result[] = "L'indirizzo mail $name inserito non è valido!";
    }
    
    /*
     * 
    static function value_get_post(&$var,$name,$flags=0)
    {
        if ($var!=null)
        {
            self::checkWithFlags($var, $name, $flags);
            return;
        }

        if (isset($_GET[$name]))
        {
            $var = $_GET[$name];
            self::checkWithFlags($var, $name, $flags);
            return;
        }

        if (isset($_POST[$name]))
        {
            $var = $_POST[$name];
            self::checkWithFlags($var, $name, $flags);
            return;
        }
    }

    static function value_post(&$var,$name,$flags=0)
    {
        if ($var!=null)
        {
            self::checkWithFlags($var, $name, $flags);
            return;
        }

        if (isset($_POST[$name]))
        {
            $var = $_POST[$name];
            self::checkWithFlags($var, $name, $flags);
            return;
        }
    }
    * 
    */
 
}
?>