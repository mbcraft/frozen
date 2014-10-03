<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

require_once("lib/fg.php");

function fg_form_upload_open($form_name,$action_url="",$method="POST",$default_azione="")
{
    fg_ex_param_defined_not_empty($form_name, "Il nome della form deve essere specificato.");

    if (Form::$current_form==null)
    {
        Form::$current_form = $form_name;
    }
    else throw new Exception("Una form risulta gia aperta.");

    if (!isset ($action_url) || $action_url=="")
        $action_url = $_SERVER['PHP_SELF'];
    ?>

    <form name="<?=$form_name ?>" method="<?=$method ?>" action="<?=$action_url ?>" enctype="multipart/form-data">
    <input id="<?=Form::$current_form ?>_id_azione_form" type="hidden" name="azione" value="<?=$default_azione ?>" >

    <?php
}

function fg_form_open($form_name,$action_url="",$method="POST",$default_azione="")
{
    fg_ex_param_defined_not_empty($form_name, "Il nome della form deve essere specificato.");

    if (Form::$current_form==null)
    {
        Form::$current_form = $form_name;   
    }
    else throw new Exception("Una form risulta gia aperta.");

    if (!isset ($action_url) || $action_url=="")
        $action_url = $_SERVER['PHP_SELF'];
    ?>

    <form name="<?=$form_name ?>" method="<?=$method ?>" action="<?=$action_url ?>">
    <input id="<?=Form::$current_form ?>_id_azione_form" type="hidden" name="azione" value="<?=$default_azione ?>" >

    <?php

}

function fg_form_close()
{
    if (Form::$current_form!=null)
    {
        echo "</form>";
        Form::$current_form = null;
    }
    else throw new Exception("Non ci sono form gi&agrave; aperte!");
}

function fg_is_form_get($form_command)
{
    fg_ex_param_defined_not_empty($form_command, "Il comando del GET deve essere specificato.");

    if (isset($_GET['azione']))
    {
        if ($_GET['azione']==$form_command)
        {
            return true;
        }
    }
    return false;
}

function fg_is_form_post($form_command)
{
    fg_ex_param_defined_not_empty($form_command, "Il comando del POST deve essere specificato.");

    if (isset($_POST['azione']))
    {
        if ($_POST['azione']==$form_command)
        {
            return true;
        }
    }
    return false;
}

function fg_form_start_table($table_name="",$width="",$height="",$cellspacing=1,$cellpadding=0)
{

    echo "<center>";
    if ($table_name!="")
        echo "$table_name :<br />";

    $width_code = "";
    if ($width!="")
        $width_code = "width=\"$width\"";

    $height_code = "";
    if ($height!="")
        $height_code = "height=\"$height\"";

    echo "<table $width_code $height_code border=\"0\" cellspacing=\"$cellspacing\" cellpadding=\"$cellpadding\" style=\"text-align:left\" class=\"sfondo_grigio_bordato\" >";
    echo "<tbody\">";
    
}

function fg_form_end_table()
{
    echo "</tbody></table></center>";
}

?>