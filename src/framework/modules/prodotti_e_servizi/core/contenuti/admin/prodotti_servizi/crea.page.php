<?

preload("AdminController");
admin_page("Gestione prodotti/servizi");

start_admin_panel("/pannello_centrale","Crea nuovo prodotto/servizio");

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
<form name="form__crea_prodotto_servizio" method="post" enctype="multipart/form-data" action="/actions/prodotto_servizio/crea.php">
    <? include_block("prodotti_servizi/__form_modifica_prodotto_servizio",array()); ?>
    <br />
    <br />

    <input type="hidden" id="input_image_count" name="image_count" value="0" />
    <a href="#" onclick="aggiungi_immagine();">Aggiungi immagine</a>

    <div id="elenco_immagini"></div>

    <input type="submit" name="Crea" value="Crea" />

    <?
    Form::after("/admin/prodotti_servizi/");
    ?>

</form>
<?

end_admin_panel();
?>