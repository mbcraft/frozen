<?
JS::require_jquery();
JS::require_script("/js/jquery.jcarousel.js");

$final_gallery_name = str_replace("/","_",$gallery_name);

?>

<script type="text/javascript">
    $(document).ready(function(){
       $("#gallery_<?=$final_gallery_name ?>").jcarousel({
           auto: <?=$wait_seconds ?>,
           scroll : <?=$items_scrolled ?>,
           wrap: 'circular'
       });
    });

</script>