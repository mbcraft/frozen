<?
/* This software is released under the BSD license. Full text at project root -> license.txt */


function admin_page($title,$show_forbidden=true)
{
    if (call("admin","is_logged"))
    Html::set_layout("admin");
    else
    {
        if ($show_forbidden)
        {
            Html::set_title("Pannello di amministrazione - Sessione scaduta");
            Html::set_layout("admin_forbidden");
            return;
        }
        else
            Html::set_layout("admin");
    }
    Html::set_title("Pannello di amministrazione - ".$title);

    if (call("admin","is_logged"))
    {
        //Carico tutti i moduli andando a includere i file che trovo in /include/plugins/admin/
        $plugins = Plugin::list_files("admin");
        foreach ($plugins as $p)
            @include_once($p);

    }
    //se non e' stato definito nessun modulo, lascio vuoto.
    if (!has_sector("/pannello_sinistra"))
        set_sector("/pannello_sinistra","");

    //inizio settore "bottom"
    
    start_sector("/bottom");
    include_block("common/powered_by");
    end_sector();

    start_sector("/framework/installed_modules");
    $modules = InstalledModules::get_all_installed_modules();
    echo "Elenco dei moduli installati : <br /><br />";
    echo "<ul>";
    foreach ($modules as $mod)
    {
        $global = $mod["global"];
        $properties = $mod["properties"];
    ?>
        <li><?=$global["nome_categoria"] ?>/<?=$global["nome_modulo"] ?> : <b><?=$properties["major_version"] ?>.<?=$properties["minor_version"] ?>.<?=$properties["revision"] ?></b></li>
    <?
    }
    echo "</ul>";
    end_sector();

}

function start_admin_panel($path,$title)
{
    set_sector($path."/".Block::MARKER_KEY,"admin/admin_panel_table");
    set_sector($path."/titolo",$title);
    start_sector($path."/contenuto");
}

function end_admin_panel()
{
    end_sector();
}

function admin_link($link,$text)
{
    echo '<div class="admin_button">';
    echo '<a class="admin_link" href='.$link.'>'.$text.'</a>';
    echo '</div>';
}

class AdminController extends AbstractController
{
    function login()
    {
        if (Params::get("username")==Config::instance()->ADMIN_USERNAME && Params::get("password")==Config::instance()->ADMIN_PASSWORD)
        {
            Session::set("/session/type","admin");
            Session::set("/session/username",Params::get("username"));
            Session::set("/session/ip",Request::getRemoteIp());
            Session::set("/session/timestamp_inizio_sessione",time());
            return Redirect::success();
        }
        else
            return Redirect::failure();
    }

    function logout()
    {
        Session::remove("/session");
        return Redirect::success();
    }

    function is_logged()
    {
        return Session::is_set("/session/type") && Session::get("/session/type")==="admin";
    }
}

?>