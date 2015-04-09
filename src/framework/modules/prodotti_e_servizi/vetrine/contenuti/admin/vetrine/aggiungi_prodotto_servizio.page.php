<?
preload("AdminController");
admin_page("Gestione vetrine");

start_admin_panel("/pannello_centrale","Aggiungi un prodotto/servizio alla vetrina");

$elenco_prodotti_servizi = call("prodotto_servizio","index");

?>

<form name="form__aggiungi_prodotto_servizio_vetrina" method="post" action="/actions/vetrine/aggiungi_prodotto_servizio_vetrina.php">
    <?
    include_block("vetrine/prodotti_servizi/__form_modifica_prodotto_servizio_vetrina");
    include_block("vetrine/prodotti_servizi/link_back_to_elenco_prodotti_servizi_vetrina");
    ?>
    &nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="Aggiungi" value="Aggiungi" />
    <?
    Form::after("/admin/vetrine/elenco_prodotti_servizi.php?id_vetrina=".$_GET["id_vetrina"]);
?>
</form>


<script type="text/javascript">
    load_immagini_prodotto_servizio('prodotto_servizio_chooser','elenco_immagini_chooser');
</script>
<?


end_admin_panel();
?>