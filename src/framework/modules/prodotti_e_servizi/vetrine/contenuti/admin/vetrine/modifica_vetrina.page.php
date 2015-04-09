<?
/*
 * Pagina per modificare la vetrina
 *
 * */
preload("AdminController");
admin_page("Gestione vetrine");

$vetrina = call("vetrine","get_vetrina",array("id_vetrina" => $_GET["id_vetrina"]));

start_admin_panel("/pannello_centrale","Modifica parametri vetrina");

?>
<form name="form__modifica_vetrina" method="post" action="/actions/vetrine/modifica_vetrina.php">
    <? include_block("vetrine/__form_modifica_vetrina",$vetrina); ?>
    <br />
    <?
    include_block("vetrine/link_back_to_vetrine");
    ?>&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="submit" name="Salva modifiche" value="Salva modifiche" />
    <?
    Form::after("/admin/vetrine/");
    ?>
</form>
<?

end_admin_panel();
?>