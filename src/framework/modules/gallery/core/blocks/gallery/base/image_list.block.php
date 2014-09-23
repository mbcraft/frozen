<?php

JS::require_jquery();
JS::require_script("/js/jquery/jquery.lightbox-0.5.min.js");
CSS::require_css_file("/css/jquery-lightbox/jquery.lightbox-0.5.css");

$html_gallery_name = str_replace("/","_",$gallery_name);

$thumb_image_height = isset($thumb_image_height) ? $thumb_image_height : 50;
?>
<div id="gallery_<?=$html_gallery_name ?>">
    <ul>
        <?

        foreach ($image_list as $k => $v)
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
            <li>
                <a href="<?= $final_image_path ?>"><img height="<?=$thumb_image_height ?>" src="<?=image_h($v["path"],$thumb_image_height) ?>" alt="<?=$v["title"] ?>" /></a>
            </li>
            <?

        }
        ?>
    </ul>
</div>
<script type="text/javascript">
    $("#gallery_<?=$html_gallery_name ?> a").lightBox({fixedNavigation:true});
</script>
