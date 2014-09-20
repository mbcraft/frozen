<?php


function tl($num_level)
{
    for ($i=0;$i<$num_level;$i++)
        echo "\t";
}




if (!isset($l))
    $l = 0;

function recursive_print_data($data,$l)
{
   if (!is_array($data))
       echo tl($l).htmlentities ($data)."\n";
   else
   {
       $width_attr = $l>0 ? "width='100%'" : "";
       echo tl($l)."<table border='1' ".$width_attr.">\n";
       foreach ($data as $key => $value)
       {
            echo tl($l+1)."<tr>\n";
            echo tl($l+2)."<td align='center'>\n";
            echo tl($l+3)."<b>".htmlentities($key)."</b>\n";
            echo tl($l+2)."</td>\n";
            echo tl($l+2)."<td align='center'>\n";
            recursive_print_data ($value, $l+3);
            echo tl($l+2)."</td>\n";
            echo tl($l+1)."</tr>\n";
       }
       echo tl($l)."</table>\n";        
   }
}

recursive_print_data($data, $l);

?>