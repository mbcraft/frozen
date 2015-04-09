<?
JS::require_jquery();
JS::require_script("/js/tiny_mce/jquery.tinymce.js");
?>

<? if (isset($id)) { ?>
    <label for="input_id">ID : </label><input id="input_id" type="text" name="id" readonly="readonly" value="<?=$id ?>" /><br />
<? } ?>

    <label for="input_chiave">Chiave : </label><input id="input_chiave" type="text" name="chiave" value="<?=$chiave ?>" /><br />

    <label for="input_titolo">Titolo : </label><input id="input_titolo" type="text" name="titolo" value="<?=$titolo ?>" /><br />
    <label for="textarea_testo">Testo : </label><textarea id="textarea_testo" type="text" name="testo"><?=$testo ?></textarea><br />
    <label for="input_keywords">Keywords : </label><input id="input_keywords" type="text" name="keywords" value="<?=$keywords ?>" /><br />
    <label for="select_codice_lingua">Lingua : </label>
    <select name="codice_lingua" id="select_codice_lingua">
        <option value="it">Italiano</option>
    </select><br />

<script type="text/javascript">
        $(function() {
                $('#textarea_testo').tinymce({
                        // Location of TinyMCE script
                        script_url : '/js/tiny_mce/tiny_mce.js',

                        // General options
                        theme : "advanced",
                        plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

                        // Theme options
                        theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
                        theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
                        theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
                        theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
                        theme_advanced_toolbar_location : "top",
                        theme_advanced_toolbar_align : "left",
                        theme_advanced_statusbar_location : "bottom",
                        theme_advanced_resizing : true//,

                        // Example content CSS (should be your site CSS)
                        //content_css : "css/content.css",

                        // Drop lists for link/image/media/template dialogs
                        //template_external_list_url : "lists/template_list.js",
                        //external_link_list_url : "lists/link_list.js",
                        //external_image_list_url : "lists/image_list.js",
                        //media_external_list_url : "lists/media_list.js",

                        // Replace values for the template plugin

                });
        });

</script>
