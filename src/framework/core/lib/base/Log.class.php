<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

/**
 * Classe per effettuare i log all'interno dell'applicazione.
 *
 * @author frostlabgate
 */
class Log
{
    const DEBUG = "DEBUG";
    const INFO = "INFO";
    const WARNING = "WARNING";
    const ERROR = "ERROR";

    public static $debug = false;
    public static $info = true;
    public static $warning = true;
    public static $error = true;

    private static $__log_handler;
    
    private static function __classLoaded($class_name)
    {
        self::setLogHandler(new MemoryLogHandler());
    }
    
    private static function class_method_name($instance,$method)
    {
        if ($instance!==null)
        {
            return str_replace("::", "#", $method);
        }
        else
        {
            return $method;
        }
    }
    
    private static function __non_null_handler()
    {
        if (self::$__log_handler==null) 
        {
            debug_print_backtrace();
            throw new IllegalStateException("Log non inizializzato : handler nullo.");
        }
    }

    public static function error($method,$message,$instance=null)
    {
        self::__non_null_handler();
        
        $final_message = self::class_method_name($instance, $method)." : ".$message;
        
        self::$__log_handler->error($final_message);       
    }

    public static function warn($method,$message,$instance=null)
    {
        self::__non_null_handler();
       
        $final_message = self::class_method_name($instance, $method)." : ".$message;

        self::$__log_handler->warn($final_message);
    }

    public static function info($method,$message,$instance=null)
    {
        self::__non_null_handler();
        
        $final_message = self::class_method_name($instance, $method)." : ".$message;

        self::$__log_handler->info($final_message);

    }

    public static function debug($method,$message,$instance=null)
    {
        self::__non_null_handler();
        
        $final_message = self::class_method_name($instance, $method)." : ".$message;

        self::$__log_handler->debug($final_message);
    }
    
    public static function setLogHandler($handler)
    {
        if ($handler instanceof ILogHandler && $handler!=null)
            self::$__log_handler = $handler;
        else
            throw new InvalidParameterException("Il parametro non e' un handler valido!!");
    }
    
    public static function getLogHandler()
    {
        return self::$__log_handler;
    }
}

interface ILogHandler 
{
    function debug($message);
    function error($message);
    function info($message);
    function warn($message);
}

class MemoryLogHandler implements ILogHandler
{
    
    private $__debug_array = array();
    private $__info_array = array();
    private $__warning_array = array();
    private $__error_array = array();

    private $__log_array = array();
    
    public function debug($message) 
    {
        $this->__debug_array[] = $message;
        $this->__log_array[] = array(Log::DEBUG,$message);
    }
    
    public function error($message) 
    {
        $this->__error_array[] = $message;
        $this->__log_array[] = array(Log::ERROR,$message);
        
        throw new Exception($message);
    }
    
    public function info($message) 
    {
        $this->__info_array[] = $message;
        $this->__log_array[] = array(Log::INFO,$message);
    }
    
    public function warn($message) 
    {
        $this->__warning_array[] = $message;
        $this->__log_array[] = array(Log::WARNING,$message);
    }
}

Log::setLogHandler(new MemoryLogHandler());

?>