<div style="max-width:60%; width:60%; border-color: black; border-style: solid; border-width: 1px;">
    <img src="/framework/core/immagini/simboli/blocco_non_trovato.png" alt="blocco non trovato" />
        Il layout <?= $layout_name ?> non &egrave; stato trovato.
        <br />
        Percorsi di ricerca : <br />
        <ul>
        <?  foreach (LayoutFactory::get_search_dirs() as $d) { ?>
        <li><?=$d ?></li>
        <? } ?>
        </ul>
        <br />
        Layout disponibili :
        <ul>
            <?php
            foreach (LayoutFactory::get_available_layouts() as $ly)
                echo "<li>$ly</li>";
            ?>
        </ul>
</div>