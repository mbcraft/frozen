<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */


function fg_html_image_vertical_scrollable($offset,$min,$max_offset,$container_element_id,
    $hidden_id,$img_id="id_img_guida_vscroll")
{
    ?>

    <form>
        <input id="<?=$hidden_id ?>" type="hidden" value="">
    </form>

    <script type="text/javascript">

        var saved_table_height = document.getElementById("<?=$container_element_id ?>").clientHeight;
        var max_offset = <?=$max_offset ?>;
        var final_offset = saved_table_height + max_offset;

        $("#<?=$hidden_id ?>").val(final_offset);

        $(window).scroll(function()
        {
            var final_height =  $("#<?=$hidden_id ?>").val();
            
            verticalScrollUpdate("#<?=$img_id ?>", <?=$offset ?>, <?=$min ?>, final_height);
            
        });

    </script>

    <?php
}

?>