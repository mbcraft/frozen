<?
JS::require_jquery();
?>
<center>
    <div align="center" style="z-index:10;margin-left:60px;" class="bgmenu">
<? if ($this->has_childs()) { ?>
        <ul id="cssdropdown">
<? $this->write_all_childs() ?>
        </ul>
<? } ?>
        
        <script language="text/javascript">
            $(document).ready(function() {
                $('#cssdropdown li.headlink').hover(
                function() { $('ul', this).css('display', 'block'); },
                function() { $('ul', this).css('display', 'none'); });
            });
        </script>

    </div>
</center>
