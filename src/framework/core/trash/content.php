<?php

require_once("lib/session/utils.php");

/*
 * 
 * --nuova voce qui [fg_optional_echo_add_menu_button()]
 * VOCE 1 --edit [fg_optional_echo_edit_menu_button() fg_optional_echo_delete_menu_button()]
 * --nuova voce qui
 * VOCE 2 --edit
 * --nuova voce qui
 * VOCE 3 --edit
 * --nuova voce qui
 * 
 */

function fg_optional_echo_edit_menu_button()
{
    
}

function fg_optional_echo_add_menu_button()
{
    
}

function fg_optional_echo_delete_menu_button()
{
    
}

function fg_optional_echo_edit_content_button()
{
    if (fg_is_logged_in_admin())
    {
        $path_pagina = Engines::getRequestUri();
    
    ?>
<br />
<div id="modifica_contenuto_link">
    <a href="/admin/modifica_contenuto.php?path_pagina=<?=$path_pagina ?>">[[ Modifica il contenuto della pagina ]]</a>
</div>
<br />
    <?php
    }
}

function fg_is_page_content_editable($path_pagina)
{
    $all_content = file_get_contents(SITE_ROOT_PATH.$path_pagina);
    
    return fg_is_content_editable($all_content);
}

/*
 * Ritorna true se il contenuto contiene un determinato smart tag
 */
function fg_has_smart_tag($name,$all_content)
{
    return preg_match("/<\?\/\*".$name."\*\/\?>/", $all_content);
}

/*
 * Ritorna true se un contenuto è modificabile.
 */
function fg_is_content_editable($all_content)
{
    $start_contenuto = "START-CONTENT";
    $end_contenuto = "END-CONTENT";
    
    return fg_has_smart_tag($start_contenuto,$all_content) && fg_has_smart_tag($end_contenuto, $all_content);
}

function fg_get_page_editable_content($path_pagina)
{
    $all_content = file_get_contents(SITE_ROOT_PATH.$path_pagina);
        
    return fg_get_editable_content($all_content);
}

/*
 * Ritorna il valore corrente di un contenuto modificabile.
 */
function fg_get_editable_content($all_contenuto)
{
    preg_match_all("/<\?\/\*START-CONTENT\*\/\?>/",$all_contenuto,$match_start,PREG_OFFSET_CAPTURE);
    
    $start_offset = $match_start[0][0][1];
    $start_offset_end = $start_offset + strlen("START-CONTENT") + 4 + 4;
    
    preg_match_all("/<\?\/\*END-CONTENT\*\/\?>/",$all_contenuto,$match_end,PREG_OFFSET_CAPTURE);
    
    $end_offset = $match_end[0][0][1];
    $end_offset_end = $end_offset - 1;
    $result = substr($all_contenuto, $start_offset_end,$end_offset-$start_offset_end);
        
    return $result;
}

function fg_set_page_editable_content($new_content,$path_pagina)
{
    $all_contenuto = file_get_contents(SITE_ROOT_PATH.$path_pagina);
    
    $new_page_content = fg_set_editable_content($new_content, $all_contenuto);

    file_put_contents(SITE_ROOT_PATH.$path_pagina, $new_page_content);
}

/*
 * Imposta il contenuto di un contenuto modificabile
 */
function fg_set_editable_content($new_content,$all_contenuto)
{
    preg_match_all("/<\?\/\*START-CONTENT\*\/\?>/",$all_contenuto,$match_start,PREG_OFFSET_CAPTURE);
    
    $start_offset = $match_start[0][0][1];
    $start_offset_end = $start_offset + strlen("START-CONTENT") + 4 + 4;
    
    preg_match_all("/<\?\/\*END-CONTENT\*\/\?>/",$all_contenuto,$match_end,PREG_OFFSET_CAPTURE);
    
    $end_offset = $match_end[0][0][1];
    $end_offset_end = $end_offset - 1;
    
    $before_content = substr($all_contenuto,0,$start_offset_end);
    $after_content = substr($all_contenuto,$end_offset);
    return $before_content.$new_content.$after_content;
}

?>