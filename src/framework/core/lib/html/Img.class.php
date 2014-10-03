<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

class Img extends BasicObject
{
    public static function animated($base_images_path,$alt_text)
    {
        fg_check_start_with_slash($base_images_path);

        $img_selected = $base_images_path."_selected.png";
        $img_not_selected = $base_images_path."_not_selected.png";
        $img_mouse_over = $base_images_path."_mouse_over.png";
    ?>
        <img style="border-width:0px" onmousedown="this.src ='<?=$img_selected ?>' " onmouseover="this.src ='<?=$img_mouse_over ?>' " onmouseout="this.src ='<?=$img_not_selected ?>' " src="<?=$img_not_selected ?>" alt="<?=$alt_text ?>">

    <?php
    }

    public static function button($base_images_path,$alt_text,$button_id,$link)
    {
        fg_check_start_with_slash($base_images_path);

        $img_selected = $base_images_path."_selected.png";
        $img_not_selected = $base_images_path."_not_selected.png";
        $img_mouse_over = $base_images_path."_mouse_over.png";

    ?>
        <a href="<?=$link ?>">
        <img style="border-width:0px" id="<?=$button_id ?>" onmousedown="this.src ='<?=$img_selected ?>' " onmouseover="this.src ='<?=$img_mouse_over ?>' " onmouseout="this.src ='<?=$img_not_selected ?>' " src="<?=$img_not_selected ?>" alt="<?=$alt_text ?>">
        </a>
    <?php
    }
}