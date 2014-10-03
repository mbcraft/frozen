<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

class CurrencyUtils
{
    
    static $currency_symbols = array(MoneyValue::CURRENCY_EUR => "€",MoneyValue::CURRENCY_USD => "$");
    
    static function round($price)
    {
        if ($price<0) throw new Exception("L'arrotondamento non supporta prezzi negativi.");
        if ($price==0) return 0.0;
        return round($price-0.005,2);
    }

    static function format($price)
    {      
        $round_amound = round($price, 2);

        return str_replace(".", ",", $round_amound)." &euro; ";
    }
    
    static function currency_to_symbol($currency)
    {
        if (ArrayUtils::contains_key($currency, self::$currency_symbols))
            return self::$currency_symbols[$currency];
        else throw new InvalidParameterException("Valuta non supportata!!");
    }
    
}

?>