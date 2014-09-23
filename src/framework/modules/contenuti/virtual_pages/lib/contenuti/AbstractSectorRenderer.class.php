<?

/*
 * Interfaccia implementata da tutti quelli che vogliono renderizzare dei settori.
 * E' necessario in un qualche modo
 * */

abstract class AbstractSectorRenderer implements InitializeAfterLoad
{
    abstract function getName();

    abstract function getDescription();

    static function __classLoaded($class_name)
    {
        $lower_case_name_with_suffix = StringUtils::camel_case_split($class_name);
        $lower_case_name = substr($lower_case_name_with_suffix,strlen($lower_case_name_with_suffix)-strlen("_sector_renderer"));

        SectorRendererRegistry::registerRenderer($lower_case_name);
    }
}

?>