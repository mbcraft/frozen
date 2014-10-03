<?php

/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

function image_w($path,$width)
{
    return ImagePicker::get_image_by_width($path,$width);
}

function image_h($path,$height)
{
    return ImagePicker::get_image_by_height($path,$height);
}

?>