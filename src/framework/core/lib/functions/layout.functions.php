<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */
function render_path_result($path)
{
    return render_result(RenderingStack::peek()->get($path));
}

function render_path($path)
{
    echo render_path_result($path);
}

/*
 * Funzione per l'inclusione di un blocco.
 */

function include_block($name,$params=array())
{
    $bk = BlockFactory::create($name, $params);
    
    $bk->render();
}

function include_block_if($block1,$block2,$condition,$params=array())
{
    if ($condition===true)
    {
        if ($block1!==null)
            include_block($block1,$params);
    }
    else
    {
        if ($block2!==null)
            include_block($block2,$params);
    }
}

/*
 * Funzioni per salvare da parte il risultato per eventuali settori. Il settore viene definito in base al
 * rendering stack corrente. 
 */

function start_sector($sector_path,$store_mode = Sector::STORE_MODE_ERROR_ON_OVERWRITE)
{
    Sector::start($sector_path, $store_mode);
}

function end_sector()
{
    Sector::end();
}

function get_sector($sector_path)
{
    return Sector::get($sector_path);
}

function set_sector($sector_path,$sector_content, $store_mode = Sector::STORE_MODE_ERROR_ON_OVERWRITE)
{
    Sector::start($sector_path, $store_mode);
    echo $sector_content;
    Sector::end();
}

function has_sector($sector_path)
{
    return Sector::is_set($sector_path);
}

function render_sector($sector_path)
{
    echo Sector::get($sector_path);
}

/*
 * Funzione che renderizza tutti gli elementi trovati in quel ramo dell'albero, prendendo solo le chiavi come riferimento.
 * In questo caso l'ordine è quello trovato nell'albero.
 */

function render_all($data)
{
    foreach ($data as $k => $v)
    {
        render($v);
    }
}

/*
 * Funzione che renderizza l'elemento passato come parametro, cercando in automatico il blocco o il layout necessari
 * per il rendering (se trova eventualmente il settore .)
 */

function render($data)
{
    echo render_result($data);
}

function render_result($data)
{
    if ($data!==null)
    {
        if (is_array($data))
        {
            if (isset($data[Block::MARKER_KEY]))
            {
                $block_name = $data[Block::MARKER_KEY];
                $block = BlockFactory::create($block_name,$data);
                return $block->__toString();
                
            }
            if (isset($data[Layout::MARKER_KEY]))
            {
                $layout_name = $data[Layout::MARKER_KEY];
                //il layout ha bisogno della vista dell'albero ma forse la posso passare anche così
                $layout = LayoutFactory::create($layout_name,$data);
                return $layout->__toString();
            }
            $collected = "";
            foreach ($data as $k => $v)
                $collected.=render_result($v);
            return $collected;
                
        }
    //nel caso in cui non sia un blocco e non sia un layout stampo quello che trovo :)
    return $data;
    }
}

?>