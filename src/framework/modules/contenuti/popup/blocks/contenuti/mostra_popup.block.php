<?
JS::require_jquery();
JS::require_script("/js/jquery/show_popup.js");

$js_size = "{ width:".$width." ,height:".$height."}";
?>
show_popup('<?=$url ?>',<?=$js_size ?>);