<?php

JS::require_jquery();
JS::require_script("/js/lightbox/jquery.lightbox-0.5.min.js");
CSS::require_css_file("/css/gallery/base/jquery.lightbox-0.5.css");

?>
<div id="gallery_<?=$gallery_name ?>">
    <ul>
    <?

    foreach ($image_list as $k => $v)
    {
    ?>
    <li>
        <a href="<?=$v["path"] ?>"><img height="50" src="<?=$v["path"] ?>" alt="<?=$v["title"] ?>" /></a>
    </li>
    <?
    
    }
    ?>
    </ul>
</div>
<script type="text/javascript">
    $("#gallery_<?=$gallery_name ?> a").lightBox({fixedNavigation:true});
</script>
