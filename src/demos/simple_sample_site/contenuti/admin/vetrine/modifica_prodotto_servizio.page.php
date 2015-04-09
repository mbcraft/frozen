<?
/*
 * Siccome non deve essere possibile inserire più di una volta lo stesso prodotto
 * */

preload("AdminController");
admin_page("Gestione vetrine");

$prodotto_servizio_vetrina = call("vetrine","get_prodotto_servizio_vetrina");

start_admin_panel("/pannello_centrale","Modifica prodotto/servizio in vetrina");

?>
<form name="form__modifica_prodotto_servizio_vetrina" method="post" action="/actions/vetrine/modifica_prodotto_servizio_vetrina.php" >
<br />
<?
include_block("vetrine/prodotti_servizi/__form_modifica_prodotto_servizio_vetrina",$prodotto_servizio_vetrina);
include_block("vetrine/prodotti_servizi/link_back_to_elenco_prodotti_servizi_vetrina");
?>

    &nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="Salva modifiche" value="Salva modifiche" />
<br />
    <?
    Form::after("/admin/vetrine/elenco_prodotti_servizi.php?id_vetrina=".$_GET["id_vetrina"]);
    ?>
</form>
<?

end_admin_panel();
?>