<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

/*
 * Questa funzione effettua il parsing di stringhe per il formato ini.
 * Accetta righe con commenti ( ; ) e testi all'interno di virgolette ( " ) e apici ( ' ).
 * Le entries devono essere separate da newline ( \n ).
 * */



function my_parse_ini_string( $string, $process_sections )
{
    $array = array();

    $lines = explode("\n", $string );

    $current_section = null;

    foreach( $lines as $line )
    {

        if ($process_sections)
        {
            $section_line = preg_match("/\[(?P<section>[\w\s\d\'\"-\.]+)\]/",$line,$match);

            if ($section_line)
            {
                $current_section = $match['section'];
                $array[$current_section] = array();
            }
        }

        $statement = false;

        if ($process_sections && !$section_line || !$process_sections)
        {
            $statement = preg_match("/\A(?!;)(?P<key>[\w+\.\-]+?)\s*=\s*(?P<value>.+?)\s*\Z/", $line, $match );

            if( $statement )
            {
                $key = $match['key'];
                $value = $match['value'];

                # Remove quote
                if( preg_match( "/\A\".+\"\Z/", $value ) || preg_match( "/\A'.+'\Z/", $value ) ) {
                    $value = mb_substr( $value, 1, mb_strlen( $value ) - 2 );
                }

                if ($current_section==null)
                    $array[ $key ] = $value;
                else
                    $array[$current_section][$key] = $value;
            }
        }
    }
    return $array;
}


/*
 * Consente l'accesso ai file di properties.
 * Tutti i metodi, se il file non è presente, lo creano.
 */
class PropertiesUtils
{
    /*
     * Aggiunge una entry su file. Se il file non esiste viene creato.
     */
    static function addEntry($file,$has_sections,$key,$entry_or_value)
    {
        $properties = PropertiesUtils::readFromFile($file, $has_sections);
        $properties[$key] = $entry_or_value;
        PropertiesUtils::saveToFile($file, $properties, $has_sections);
    }
    
    /*
     * Rimuove una entry da file. Se non ci sono entries non viene creato alcun file.
     */
    static function removeEntry($file,$has_sections,$key)
    {
        $properties = PropertiesUtils::readFromFile($file, $has_sections);
        unset($properties[$key]);
        PropertiesUtils::saveToFile($file, $properties, $has_sections);
    }

    static function readFromString($string, $process_sections)
    {
        return my_parse_ini_string($string,$process_sections);
    }

    /*
     * Legge tutte le entries da file. Se il file non esiste ritorna un array vuoto. 
     */
    static function readFromFile($file,$process_sections)
    {
        if ($file->exists())
            return parse_ini_file($file->getFullPath(), $process_sections);
        else return array();
    }


    static function saveToString($properties, $process_sections)
    {
        if ($properties===null) throw new InvalidDataException("Le properties sono nulle!");

        $tmp = '';
        if ($process_sections)
        {
            foreach($properties as $section => $values){
                $tmp .= "[$section]\n";
                foreach($values as $key => $val){
                    if(is_array($val)){
                        foreach($val as $k =>$v){
                            $tmp .= "{$key}[$k] = \"$v\"\n";
                        }
                    }
                    else
                        $tmp .= "$key = \"$val\"\n";
                }
                $tmp .= "\n";
            }
        }
        else
        {
            foreach ($properties as $key => $val)
            {
                $tmp .= "$key = \"$val\"\n";
            }
        }
        return $tmp;
    }
    /*
     * Salva tutte le entries su file. Se il file non esiste viene creato.
     */
    static function saveToFile($file,$properties,$process_sections)
    {
        $prop_string = self::saveToString($properties,$process_sections);
        if (!$file->exists()) $file->touch();
        $file->setContent($prop_string);
    }

}
?>