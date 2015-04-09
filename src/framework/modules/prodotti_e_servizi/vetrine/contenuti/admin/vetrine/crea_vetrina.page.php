<?

preload("AdminController");
admin_page("Gestione prodotti/servizi");

start_admin_panel("/pannello_centrale","Crea vetrina");

?>
<form name="form__crea_vetrina" method="post" action="/actions/vetrine/crea_vetrina.php">
    <? include_block("vetrine/__form_modifica_vetrina"); ?>
    <br />
    <?
    include_block("vetrine/link_back_to_vetrine");
    ?>&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="submit" name="Crea" value="Crea" />
    <?
    Form::after("/admin/vetrine/");
    ?>
</form>
<?

end_admin_panel();
?>