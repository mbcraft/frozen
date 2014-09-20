<?
JS::require_jquery();
JS::require_jquery_ui();
JS::require_script("/js/jquery/datepicker/jquery.ui.datepicker-it.js");
if (!isset($changeYear)) $changeYear = false;
if (!isset($startYear)) $startYear = date("Y")-78;
if (!isset($endYear)) $endYear = date("Y")-16;

$options = array("gotoCurrent"=>true,"dateFormat"=> "dd/mm/yy","changeYear" => $changeYear,"yearRange" => $startYear.":".$endYear);

if (isset($input_id))
{
?>
<script type="text/javascript">
    $("#<?=$input_id ?>").datepicker(<?=json_encode($options) ?>);

    <?
    if (isset($image_id))
    {
    ?>
    $("#<?=$image_id ?>").on("click",function ()
    {
        $("#<?=$input_id ?>").datepicker("show");
    });
    <? } ?>
</script>
<?
}
else JS::require_script("/js/jquery/datepicker/default_datepicker.js");
?>