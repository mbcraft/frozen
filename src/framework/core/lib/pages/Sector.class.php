<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

/*
 * Rappresenta la sezione. Questa classe implementa la funzionalita' di storing dei contenuti all'interno
 * dell'albero dei risultati in diverse modalita'.
 */

class Sector implements InitializeAfterLoad
{
    public static function __classLoaded($class_name) {
        Sector::reset();
    }
    
    const STORE_MODE_OVERWRITE = "overwrite";
    const STORE_MODE_ERROR_ON_OVERWRITE = "error_on_overwrite";
    const STORE_MODE_PREPEND = "prepend";
    const STORE_MODE_APPEND = "append";
    
    private static $sector_opened = false;
    private static $sector_path = null;
    private static $store_mode = null;
    
    public static function reset()
    {
        if (self::$sector_opened)
        {
            ob_end_clean();

        }
        
        self::$sector_opened = false;
        self::$sector_path = null;
        self::$store_mode = null;
    }
    
    public static function is_opened()
    {
        return self::$sector_opened;
    }

    public static function start($sector_path,$store_mode = self::STORE_MODE_ERROR_ON_OVERWRITE)
    {
        $r = RenderingStack::peek();
        
        if ($sector_path==null)
            throw new InvalidParameterException ("Il valore di sector_path non e' valido!!");
        
        self::$store_mode = $store_mode;
        
        if (self::$sector_opened)
            throw new IllegalStateException("Non e' possibile aprire piu' di un settore per volta.");
        
        if ($r->is_set($sector_path) && $store_mode === self::STORE_MODE_ERROR_ON_OVERWRITE)
                throw new IllegalStateException("Non e' consentito sovrascrivere un settore in modalita' ERROR_ON_OVERWRITE");
                
        self::$sector_opened = true;
        self::$sector_path = $sector_path;
        
        ob_start();
    }

    public static function is_set($path)
    {
        $r = RenderingStack::peek();

        return $r->is_set($path);
    }
    
    public static function end()
    {
        $content = gzuncompress(gzcompress(ob_get_contents()));
        ob_end_clean();
        
        $r = RenderingStack::peek();      
        
        if (self::$store_mode == self::STORE_MODE_OVERWRITE || self::$store_mode == self::STORE_MODE_ERROR_ON_OVERWRITE)
            $r->set(self::$sector_path,$content);
        
        if (self::$store_mode == self::STORE_MODE_APPEND)
        {
            if ($r->is_set(self::$sector_path))
            {
                $old_content = $r->get(self::$sector_path);
                $r->set(self::$sector_path,$old_content.$content);
            }
            else
                $r->set(self::$sector_path,$content);
        }
        
        if (self::$store_mode == self::STORE_MODE_PREPEND)
        {
            if ($r->is_set(self::$sector_path))
            {
                $old_content = $r->get(self::$sector_path);
                $r->set(self::$sector_path,$content.$old_content);
            }
            else
                $r->set(self::$sector_path,$content);
        }
        
        self::$sector_opened = false;
        self::$store_mode = null;
        self::$sector_path = null;
    }
    
    public static function get($sector_path)
    {
        $r = RenderingStack::peek();
        
        if ($r->is_set($sector_path))
        {
            return $r->get($sector_path);
        }
        else
            throw new IllegalStateException("Il settore ".$sector_path." non e' stata definita.");
    }
}

?>