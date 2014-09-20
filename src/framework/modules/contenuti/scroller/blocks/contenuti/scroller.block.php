<?

CSS::require_css("/css/jquery/jquery.jscrollpane.css");

JS::require_jquery();
JS::require_script("/js/jquery/jquery.mousewheel.js");
JS::require_script("/js/jquery/mwheelIntent.js");
JS::require_script("/js/jquery/jquery.jscrollpane.min.js");
?>
<script type="text/javascript">
    $(function()
    {
        $('<?= isset($id) ? $id : ".".$class ?>').jScrollPane(
            {
                autoReinitialise: true
            }
        );
    });
</script>