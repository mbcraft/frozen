<?

preload("AdminController");
admin_page("Gestione prodotti/servizi");

$id_prodotto_servizio = $_GET["id_prodotto_servizio"];

$prodotto_servizio = call("prodotto_servizio","get",array("id_prodotto_servizio" => $id_prodotto_servizio));

start_admin_panel("/pannello_centrale","Modifica prodotto/servizio");

?>
<script type="text/javascript">

    function aggiungi_immagine()
    {
        image_count = parseInt($("#input_image_count").val());
        $("#input_image_count").val(image_count+1);
        insert_html_after('/admin/prodotti_servizi/ajax/carica_immagine.php',{image_count : image_count},'elenco_immagini');
    }

    function insert_html_after(url,data,target)
    {
        result = $.get(url,data,function(data,result)
        {
            if (result=="success" || result=="notmodified")
                $("#"+target).append(data);
            else
                alert("Si e' verificato un errore. Contattare il supporto tecnico.");
        });

    }
</script>
<form name="form__modifica_prodotto_servizio" method="post" enctype="multipart/form-data" action="/actions/prodotto_servizio/modifica.php">
    <? include_block("prodotti_servizi/__form_modifica_prodotto_servizio",$prodotto_servizio); ?>

    <br />
    <br />

    <input type="hidden" id="input_image_count" name="image_count" value="0" />
    <br />
    <a href="#" onclick="aggiungi_immagine();">Aggiungi immagine</a>
    <br />
    <br />
    <div id="elenco_immagini"></div>


    <br />
    <input type="submit" name="Salva modifiche" value="Salva modifiche" />
    <?
    Form::after("/admin/prodotti_servizi/");
    ?>
</form>
<br />
<br />
<?
$elenco_immagini = call("prodotto_servizio","index_immagini",array("__filter_id_prodotto_servizio__EQUAL" => $id_prodotto_servizio));
include_block_if("prodotti_servizi/immagini/elenco_immagini","prodotti_servizi/immagini/nessuna_immagine",count($elenco_immagini)>0,array("elenco_immagini" => $elenco_immagini));
?>
<br />
<br />
<a href="/admin/prodotti_servizi/">Torna all'elenco dei prodotti/servizi</a>
<?

end_admin_panel();
?>
