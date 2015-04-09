<?php

preload("AdminController");
admin_page("Gestione contenuti");

start_admin_panel("/pannello_centrale","Importa/esporta contenuti");
?>
<? Flash::write_error_messages() ?>
    <div class="importa">
        <form name="form_importa_contenuti" action="/actions/testi/import.php" method="POST">
            <textarea name="import_data" rows="10" cols="10"></textarea>
            <button type="submit" onclick="return window.confirm('Sei sicuro di voler importare il contenuto specificato?');">
                Importa
            </button>
            <? Form::on_success("/admin/contenuti/testi/") ?>
            <? Form::on_failure("/admin/contenuti/testi/importa_testi.php"); ?>
        </form>
    </div>
<?
end_admin_panel();
?>