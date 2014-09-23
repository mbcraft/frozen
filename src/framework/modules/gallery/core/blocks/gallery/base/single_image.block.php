<?php

JS::require_jquery();
JS::require_script("/js/jquery/jquery.lightbox-0.5.min.js");
CSS::require_css_file("/css/jquery-lightbox/jquery.lightbox-0.5.css");

$html_gallery_name = str_replace("/","_",$gallery_name);

$thumb_image_height = isset($thumb_image_height) ? $thumb_image_height : 500;
$thumb_image_index = isset($thumb_image_index) ? $thumb_image_index : 0;


if (isset(Config::instance()->GALLERY_RESIZE_BY_WIDTH))
{
    $final_image_path = image_w($image_list[$thumb_image_index]["path"],Config::instance()->GALLERY_RESIZE_BY_WIDTH);
}
else 
if (isset(Config::instance()->GALLERY_RESIZE_BY_HEIGHT))
{
    $final_image_path = image_h($image_list[$thumb_image_index]["path"],Config::instance()->GALLERY_RESIZE_BY_HEIGHT);
}
else 
    $final_image_path = $image_list[$thumb_image_index]["path"];

?>
<div id="gallery_<?=$html_gallery_name ?>">
    <a href="<?=$image_list[$thumb_image_index]["path"] ?>">
        <img style="border:0px;" src="<?=$image_list[$thumb_image_index]["path"] ?>" alt="<?=$image_list[$thumb_image_index]["title"] ?>" title="<?=$image_list[$thumb_image_index]["title"] ?>" />
    </a>
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
            <a href="<?= $final_image_path ?>" title="<?=$v["title"] ?>"></a>
        <?
    }
    ?>
</div>
<script type="text/javascript">
    $("#gallery_<?=$html_gallery_name ?> a").lightBox({fixedNavigation:true});
</script>