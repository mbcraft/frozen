<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */


function fg_write_error_messages($form_errors)
{
    if ($form_errors!="")
    {
        echo "<br />";
        echo "<br />";
        echo "<table cellpadding=\"2\" border=\"4\" style=\"border-color:red; border-style:dotted dottet dotted dotted;\"><tr><td>";
        echo "<h5 style=\"color:red;\"><b>$form_errors</b></h5>";
        echo "</td></tr></table>";
        echo "<br />";
    }
}

function fg_write_ok_message($message)
{
    echo "<h3><center>$message</center></h3>";
}

function fg_write_image_menu_item($icon_name,$title,$link)
{
    $linkIndex = fg_get("linkIndex");
    fg_set("linkIndex",$linkIndex+1);

    $linkId = "link_".$linkIndex;

    fg_check_not_start_with_slash($icon_name);
    fg_check_start_with_slash($link);

    $full_image_path = "/immagini/grafica/icone/".$icon_name;
    echo "<table><tbody><tr>";
    echo "<td><a href=\"$link\"><img style=\"border-width:0px\" src=\"$full_image_path\" width=\"35\" height=\"35\" alt=\"$title\"></a></td>";
    echo "<td align=\"middle\"><a id='".$linkId."' class=\"link_not_selected\" onmouseover=\"fg_js_update_class('".$linkId."','link_mouse_over')\" onmouseout=\"fg_js_update_class('".$linkId."','link_not_selected')\" href=\"$link\">$title</a></td>";
    echo "</tr></tbody></table>";
}
/**
 * Effettua l'escape di una stringa per la rappresentazione in un campo di testo
 * o textarea html.
 *
 * @param <type> $string La stringa di cui fare l'escape
 * @return <type> La stringa pronta per l'html/xml
 */
function fg_html_escape_entities($string)
{
    return htmlentities($string,ENT_QUOTES,"ISO-8859-15");
}
/**
 * Effettua l'escape di un array associativo direttamente al suo interno.
 *
 * @param <type> $array L'array sul quale effettuare l'escape.
 */
function fg_html_escape_entities_assoc(&$array)
{
    foreach ($array as $key => $val)
    {
        $array[$key] = fg_html_escape_entities($val);
    }
}

function fg_html_prezzo($amount)
{
    $round_amound = round($amount, 2);

    return str_replace(".", ",", $round_amound)." &euro; ";
}

function fg_html_prezzo_round($amount)
{
    if ($amount<0) throw new Exception("L'arrotondamento non supporta prezzi negativi.");
    if ($amount==0) return 0.0;
    return round($amount-0.005,2);
}

function fg_html_buttons($base_path)
{
    $result = array();
    $result["selected"] = $base_path."_selected.png";
    $result["not_selected"] = $base_path."_not_selected.png";
    $result["mouse_over"] = $base_path."_mouse_over.png";
    return $result;
}

function fg_html_loading_write_js()
{
    ?>

    <script type="text/javascript">

        function fg_js_html_loading_start(name)
        {
            $("#id_loading_"+name).attr("src", "/immagini/grafica/icone/caricamento_trasparente_mini.gif");
        }

        function fg_js_html_loading_stop(name)
        {
            $("#id_loading_"+name).attr("src", "/immagini/grafica/icone/loading_placeholder.png");
        }

    </script>


    <?php
}

function fg_html_loading_write_placeholder($name)
{
    $align = "top";
    $path_loading_placeholder = "/immagini/grafica/icone/loading_placeholder.png";

    $full_id = "";
    if ($name!="")
        $full_id = "id=\"id_loading_$name\"";

    echo "<img $full_id src=\"$path_loading_placeholder\" alt=\"\" align=\"$align\" >";
}

function fg_html_image_thumbnail($base_image_folder,$image_name,$image_alt,$image_align)
{
    $final_align = $image_align == "" ? "" : "align=\"$image_align\"";
    ?>

    <a href="<?=$base_image_folder.$image_name.".jpg" ?>">
        <img class="simple" <?=$final_align ?> alt="<?=$image_alt ?>" src="<?=$base_image_folder."thumbnails/".$image_name."_small.jpg" ?>" />
    </a>

    <?php
}

function fg_html_image_thumbnail_two_third($base_image_folder,$image_name,$image_alt,$image_align)
{
    $final_align = $image_align == "" ? "" : "align=\"$image_align\"";
    ?>

    <a href="<?=$base_image_folder.$image_name.".jpg" ?>">
        <img class="stretched_image_two_third" style="margin:3px;" <?=$final_align ?> alt="<?=$image_alt ?>" src="<?=$base_image_folder."thumbnails/".$image_name."_small.jpg" ?>" />
    </a>

    <?php
}

function fg_html_image_thumbnail_half($base_image_folder,$image_name,$image_alt,$image_align)
{
    $final_align = $image_align == "" ? "" : "align=\"$image_align\"";
    ?>

    <a href="<?=$base_image_folder.$image_name.".jpg" ?>">
        <img class="stretched_image_half" style="margin:3px;" <?=$final_align ?> alt="<?=$image_alt ?>" src="<?=$base_image_folder."thumbnails/".$image_name."_small.jpg" ?>" />
    </a>

    <?php
}

?>