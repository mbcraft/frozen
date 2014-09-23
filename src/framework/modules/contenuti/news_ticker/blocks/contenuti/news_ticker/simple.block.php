<?
JS::require_jquery();
JS::require_script("/js/jquery/jcarousel_lite_1_0_1.min.js");
?>
<script type="text/javascript">
     $(function()
     {
         $(".<?=$container_div_class ?>").jCarouselLite(
            {
                 vertical: true,
                 visible: <?= isset($num_entries) ? $num_entries : "3" ?>,
                 auto: <?= isset($delay) ? $delay : "2000" ?>,
                 speed: <?= isset($speed) ? $speed : "2000" ?>
            });
     });
</script>
