<?

class SectorRendererRegistry
{
    static $renderers = array();

    static function registerRenderer($categoria)
    {
        self::$renderers[$categoria] = array();
    }

    static function hasRenderer($categoria)
    {
        return isset(self::$renderers[$categoria]);
    }

    static function createRenderer($categoria)
    {
        if (isset(self::$renderers[$categoria])) $renderer_name = $categoria;

        $renderer_class_name = StringUtils::underscored_to_camel_case($renderer_name."_sector_renderer");

        return __create_instance($renderer_class_name);
    }
}

?>