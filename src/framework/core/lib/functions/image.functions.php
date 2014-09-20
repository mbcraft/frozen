<?php

/* This software is released under the BSD license. Full text at project root -> license.txt */

function image_w($path,$width)
{
    return ImagePicker::get_image_by_width($path,$width);
}

function image_h($path,$height)
{
    return ImagePicker::get_image_by_height($path,$height);
}

?>