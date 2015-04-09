<center>
    <div align="center" style="z-index:10;margin-left:60px;" class="bgmenu">
<? if ($this->has_childs()) {
    $column_count = $this->get_max_childs()/2;
    ?>
        <table>
            <tr>
                <td>
                   <ul class="cssdropdown">
            <?
            for ($i=0;i<$column_count;$i++)
            {
                $this->write_child();
            }
            ?>
                    </ul>
                </td>
                <td>
                    <ul class="cssdropdown">
            <?
            while ($this->has_more_childs())
            {
                $this->write_child();

            }
            ?>
                    </ul>
                </td>
            </tr>
        </table>


<? } ?>
        
        <script language="JavaScript">
            $(document).ready(function(){
                $('.cssdropdown li.headlink').hover(
                function() { $('ul', this).css('display', 'block'); },
                function() { $('ul', this).css('display', 'none'); });
            });
        </script>

    </div>
</center>
