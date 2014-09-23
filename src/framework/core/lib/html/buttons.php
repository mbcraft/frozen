<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

function fg_write_form_button($base_images_path,$button_id,$alt_text,$width,$height,$action)
{
    fg_check_start_with_slash($base_images_path);

    $img_selected = $base_images_path."_selected.png";
    $img_not_selected = $base_images_path."_not_selected.png";
    $img_mouse_over = $base_images_path."_mouse_over.png";
    
    ?>


    <img src="<?=$img_mouse_over ?>" width="0" height="0" alt="" />
    <input onclick="fg_update_azione_form('<?=Form::$current_form ?>','<?=$action ?>')" type="image" id="<?=$button_id ?>" onmousedown="this.src='<?=$img_selected?>'" onmouseout="this.src='<?=$img_not_selected ?>'" onmouseover="this.src='<?=$img_mouse_over ?>'" src="<?=$img_not_selected ?>" >

    <?php
}

function fg_write_linked_image($img_path,$link,$alt_text,$width=-1,$height=-1)
{
    fg_check_start_with_slash($img_path);

    $width_text = $width==-1 ? "" : "width=\"".$width."\"";
    $height_text = $height==-1 ? "" : "height=\"".$height."\"";
?>
    <a href="<?=$link ?>"><img style="border-width:0px" <?=$width_text ?> <?=$height_text ?> src="<?=$img_path ?>" alt="<?=$alt_text ?>"></a>
<?php
}

function fg_write_animated_image($base_images_path,$alt_text,$link)
{
    fg_check_start_with_slash($base_images_path);

    $img_selected = $base_images_path."_selected.png";
    $img_not_selected = $base_images_path."_not_selected.png";
    $img_mouse_over = $base_images_path."_mouse_over.png";
?>
    <img src="<?=$img_mouse_over ?>" width="0" height="0" alt="" />
    <a href="<?=$link ?>"><img style="border-width:0px" onmousedown="this.src ='<?=$img_selected ?>' " onmouseover="this.src ='<?=$img_mouse_over ?>' " onmouseout="this.src ='<?=$img_not_selected ?>' " src="<?=$img_not_selected ?>" alt="<?=$alt_text ?>"></a>

<?php
}

function fg_write_image_button($base_images_path,$button_id,$link,$alt_text)
{
    
    fg_check_start_with_slash($base_images_path);

    $img_selected = $base_images_path."_selected.png";
    $img_not_selected = $base_images_path."_not_selected.png";
    $img_mouse_over = $base_images_path."_mouse_over.png";

?>
    <img src="<?= $img_mouse_over ?>" width="0" height="0" alt=""/>
    <a href="<?=$link ?>">
    <img style="border-width:0px" id="<?=$button_id ?>" onmousedown="this.src ='<?=$img_selected ?>' " onmouseover="this.src ='<?=$img_mouse_over ?>' " onmouseout="this.src ='<?=$img_not_selected ?>' " src="<?=$img_not_selected ?>" alt="<?=$alt_text ?>">
    </a>
<?php
}

?>