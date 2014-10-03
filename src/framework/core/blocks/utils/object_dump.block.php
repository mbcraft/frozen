<?php



foreach ($data as $key => $value)
{
    if (is_array($value))
        $num_row_span = count($value);
    else
        $num_row_span = 1;
    
    echo "<table border='1'>";
    echo "<tr>";
    echo "<td rowspan='$num_row_span'>";
    echo $key;
    echo "</td>";
    echo "<td>";
    if ($num_row_span==1)
        echo $value;
    else
        include_block ("utils/data_dump",$value);
    echo "</td>";
    echo "</tr>";
    echo "</table>";
}

?>