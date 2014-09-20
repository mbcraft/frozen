<?php

JS::require_jquery();
JS::require_script("/js/jquery/jquery.lightbox-0.5.min.js");
CSS::require_css_file("/css/jquery-lightbox/jquery.lightbox-0.5.css");

$html_gallery_name = str_replace("/","_",$gallery_name);

?>
<span id="gallery_<?=$html_gallery_name ?>">
    <a href="<?=$image_list[$thumb_image_index]["path"] ?>">
        <?=$link_text ?>
    </a>
    <?

    foreach ($image_list as $k => $v)
    {
        if ($k!=$thumb_image_index)
        {
            if (isset(Config::instance()->GALLERY_RESIZE_BY_WIDTH))
            {
                $final_image_path = image_w($v["path"],Config::instance()->GALLERY_RESIZE_BY_WIDTH);
            }
            else if (isset(Config::instance()->GALLERY_RESIZE_BY_HEIGHT))
            {
                $final_image_path = image_h($v["path"],Config::instance()->GALLERY_RESIZE_BY_HEIGHT);
            }
            else $final_image_path = $v["path"];
            ?>
            <a href="<?= $final_image_path ?>" title="<?=$v["title"] ?>"></a>
            <?
        }
    }
    ?>
</span>
<script type="text/javascript">
    $("#gallery_<?=$html_gallery_name ?> a").lightBox({fixedNavigation:true});
</script>