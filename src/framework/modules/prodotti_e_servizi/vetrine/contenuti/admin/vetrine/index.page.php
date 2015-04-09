<?
/*
 * Pagina con l'elenco delle vetrine
 *
 * */
preload("AdminController");
admin_page("Gestione vetrine");

$elenco_vetrine = call("vetrine","index");

start_admin_panel("/pannello_centrale","Elenco vetrine");
?>
<div class="azioni">
    <a href="/admin/vetrine/crea_vetrina.php">Crea nuova vetrina</a>
</div>
<?

include_block_if("vetrine/elenco_vetrine","vetrine/nessuna_vetrina",count($elenco_vetrine)>0,array("elenco_vetrine" => $elenco_vetrine));

end_admin_panel();
?>