<?
JS::require_jquery();
JS::require_script("/js/jquery/jquery.cycle.all.js");
?>

<ul id="rotator_<?=$rotator_name ?>" class="generic_rotator"></ul>

<script type="text/javascript">

    var image_width = <?= isset($width) ? $width : "-1" ?>;
    var image_height = <?= isset($height) ? $height : "-1" ?>;
    var path_array = [<?
    $first = true;
    foreach ($image_list as $image)
    {
        if (!$first) echo ",";
        $first = false;
        echo "\"";
        echo $image["path"];
        echo "\"";
    }
?>];
    var title_array = [<?
    $first = true;
    foreach ($image_list as $image)
    {
        if (!$first) echo ",";
        $first = false;
        echo "\"";
        echo $image["title"];
        echo "\"";
    }
?>];
    var img_array = new Array();
    for (i=0;i<<?=count($image_list) ?>;i++) {
        var img = new Image
        img.src = path_array[i];
        img.title = title_array[i];
        img.alt = title_array[i];
        img_array[i] = img;

        img_tag = document.createElement("img");

        img_tag.src = img.src;
        img_tag.title = img.title;
        img_tag.alt = img.alt;
        if (image_width>0) img_tag.width = image_width;
        if (image_height>0) img_tag.height = image_height;

        li_img = document.createElement("li");
        $(li_img).append(img_tag);

        $("#rotator_<?=$rotator_name ?>").append(li_img);
    }

    $('#rotator_<?=$rotator_name ?>').cycle({
 	  speed: 1000
   });
</script>