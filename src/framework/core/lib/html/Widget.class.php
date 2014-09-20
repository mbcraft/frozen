<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

class Widget extends BasicObject
{
    function open_fixed_width($css_class)
    {

    }

    function close_fixed_width($css_class)
    {

    }

    function open_resizable($css_class)
    {
        ?>
<table align="center" cellpadding="0px" cellspacing="0px" class="<?=$css_class ?>">
    <tr>
        <td class="<?=$css_class ?>_1">

        </td>

        <td class="<?=$css_class ?>_2">

        </td>

        <td class="<?=$css_class ?>_3">

        </td>

    </tr>
    <tr>
        <td class="<?=$css_class ?>_4">

        </td>

        <td class="<?=$css_class ?>_5">

        <?php
    }

    function close_resizable($css_class)
    {
        ?>
        </td>

        <td class="<?=$css_class?>_6">

        </td>
    </tr>
    <tr>
        <td class="<?=$css_class?>_7">

        </td>

        <td class="<?=$css_class?>_8">

        </td>

        <td class="<?=$css_class?>_9">

        </td>
    </tr>

</table>
        <?php
    }
}

?>