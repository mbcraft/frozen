<?
if (!isset($cols))
    $cols = 5;
if (!isset($rows))
    $rows = (int)(ceil((double)(count($elenco_oggetti))/(double)($cols)));
?>
<table>
    <tbody>
    <?
    $i_col = 0;
    $i_row = 0;
    while ($i_col<$cols && $i_row<$rows)
    {
        if ($i_col==0) echo "<tr>";
        $real_index = $i_col+$i_row*$cols;
        if ($real_index<count($elenco_oggetti))
        {
            $obj = $elenco_oggetti[$real_index];
            echo "<td>";
            include_block($blocco_presentazione,$obj);
            echo "</td>";
        }
        else
        {
            ?>
        <td></td>
            <?
        }
        $i_col++;
        if ($i_col==$cols)
        {
            echo "</tr>";
            $i_col=0;
            $i_row++;
        }
    }
    ?>
    </tbody>
</table>