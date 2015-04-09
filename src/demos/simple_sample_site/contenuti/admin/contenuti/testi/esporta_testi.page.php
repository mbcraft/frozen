<?php

preload("AdminController");
admin_page("Gestione contenuti");

$export_contenuti = call("testi","export");

start_admin_panel("/pannello_centrale","Importa/esporta contenuti");
?>
    <div class="importa">
        <form name="form_esporta_contenuti">
            <textarea id="textarea_export" rows="10" cols="10"><?=htmlentities($export_contenuti) ?></textarea>
        </form>
        <script type="text/javascript">
            function selectText(element) {
                var doc = document;
                var text = doc.getElementById(element);
                if (doc.body.createTextRange) { // ms
                    var range = doc.body.createTextRange();
                    range.moveToElementText(text);
                    range.select();
                } else if (window.getSelection) {
                    var selection = window.getSelection();
                    if (selection.setBaseAndExtent) { // webkit
                        selection.setBaseAndExtent(text, 0, text, 1);
                    } else { // moz, opera
                        var range = doc.createRange();
                        range.selectNodeContents(text);
                        selection.removeAllRanges();
                        selection.addRange(range);
                    }
                }
            }
            selectText('textarea_export');
        </script>
    </div>
<?
end_admin_panel();
?>