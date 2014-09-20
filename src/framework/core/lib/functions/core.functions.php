<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */
require_once("framework/core/lib/base/BasicObject.class.php");
require_once("framework/core/lib/utils/DataHolder.class.php");

/*
 * Funzione utilizzata per creare istanze con parametri nel costruttore (anche più di uno).
 */
function __flat_export($param)
{
    if ($param===null) return "";
    if (is_array($param))
    {
        $export = "";
        foreach ($param as $p)
            $export.= ",".var_export($p,true);
        return substr($export,1);
    }
    else
        return var_export($param,true);
}
/*
 * Funzione per creare istanze di una classe con relativi parametri. Supporta parametro singolo o array di parametri.
 * L'array viene reso piatto al primo livello (sottolivelli rimangono array).
 * OK funziona anche con array come sottoparametri.
 * call_user_func_array non funziona con i costruttori e fare un metodo statico factory mi sembra inutile. Meglio così.
 *
 * ES : __create_instance("MiaClasse",array("uno",2,3));
 */
function __create_instance($classname,$arguments=null)
{
    $export = __flat_export($arguments);
    $eval_string = "return new $classname($export);";
    return eval($eval_string);
}

/*
 * Crea una classe che eredita da una superclasse dinamicamente. La classe creata è vuota.
 *
 * ES : __define_class("SottoClasse","SuperClasse")
 *
 * definisce la classe SottoClasse che eredita da SuperClasse
 */
function __define_class($classname,$superclass)
{
    eval("class $classname extends $superclass {}");
}

function array_last($arr)
{
    if (count($arr)===0) return null;
    else return $arr[count($arr)-1];
}

function isset_or_empty($var)
{
    return isset($var) ? $var : "";
}
?>