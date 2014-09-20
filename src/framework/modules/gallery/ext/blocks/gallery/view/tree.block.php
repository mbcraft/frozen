<?php
//ok funzionante

//params : $tree_elements

JS::require_jquery();
JS::require_script("/js/jquery/jquery.lightbox-0.5.min.js");

CSS::require_css_file("/css/jquery-lightbox/jquery.lightbox-0.5.css");

?>
<script type="text/javascript">
    function load_gallery(my_gallery_name)
    {
        $('#gallery_view').load('/actions/gallery/get_gallery.php',{gallery_name:my_gallery_name});
        $("#gallery_"+my_gallery_name+" a").lightBox({fixedNavigation:true});
    }
    function reload_gallery(gallery_name)
    {
        $("#gallery_"+gallery_name+" a").lightBox({fixedNavigation:true});
    }
</script>
<?
include_block("gallery/base/tree_element",$this->params);
?>