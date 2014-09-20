<?
//ok funzionante

?>
<ul>
    <?
        foreach ($tree_elements as $elem)
        {
            echo "<li>";

            if ($elem["childs"]!==null)
            {
                echo $elem["name"];

                include_block("gallery/base/tree_element",array("tree_elements" => $elem["childs"]));
            }
            else
            {
                ?><a href="#" onclick="
                    $('#gallery_view').load('/actions/gallery/get_gallery.php',{gallery_name:'<?=$elem["path"] ?>'},function (){
                     $('#gallery_<?=preg_replace("/[\/ ]/","_",$elem["path"])?> a').lightBox({fixedNavigation:true});
                    });
                    
                    "><?=$elem["name"] ?></a><?
            }
            echo "</li>\n";
        }
    ?>
</ul>