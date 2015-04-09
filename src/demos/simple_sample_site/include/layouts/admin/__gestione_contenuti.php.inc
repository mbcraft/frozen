<?

call("contenuti","init_roots");

start_admin_panel("/pannello_sinistra/gestione_contenuti","Gestione contenuti pagine");
?>

<form method="POST" action="/actions/testi/load_root_as_current.php">
    <? Form::on_success("/admin/contenuti/testi/");?>
    <button type="submit">
        <span>Gestione contenuti</span>
    </button>
</form>

<form method="POST" action="/actions/immagini/load_root_as_current.php">
    <? Form::on_success("/admin/contenuti/immagini/");?>
    <button type="submit">
        <span>Gestione immagini</span>
    </button>
</form>

<?
end_admin_panel();
?>