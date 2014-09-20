<?
JS::require_jquery();
JS::require_script("/js/tiny_mce/jquery.tinymce.js");
if (!isset($htmleditor_field_id))
    $htmleditor_field_id = "textarea_testo";
?>
<script type="text/javascript">
        $(function() {
                $('#<?=$htmleditor_field_id ?>').tinymce({
                        // Location of TinyMCE script
                        script_url : '/js/tiny_mce/tiny_mce.js',

                        // General options
                        theme : "advanced",
                        plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,fgfileselect",

                        // Theme options
                        theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
                        theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,<? if (!isset($hide_file_selection) || !$hide_file_selection) { ?>fgfileselect,<? } ?>cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
                        theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
                        theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
                        theme_advanced_toolbar_location : "top",
                        theme_advanced_toolbar_align : "left",
                        theme_advanced_statusbar_location : "bottom",
                        theme_advanced_resizing : true,
                        //,

                        // Example content CSS (should be your site CSS)
                        //content_css : "css/content.css",

                        // Drop lists for link/image/media/template dialogs
                        //template_external_list_url : "lists/template_list.js",
                        <? if (!isset($hide_file_selection) || !$hide_file_selection) { ?>
                        external_file_list_url : "/lib/contenuti/core/document_list_js.php?folder=<?=$folder ?>",
                        <? }
                        if (!isset($hide_external_image_list) || !$hide_external_image_list) { ?>
                        external_image_list_url : "/lib/contenuti/core/image_list_js.php?folder=<?= $folder ?>"
                        <? } ?>
                        //media_external_list_url : "lists/media_list.js",

                        // Replace values for the template plugin

                });
        });

</script>