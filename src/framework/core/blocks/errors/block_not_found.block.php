<div style="max-width:60%; width:60%; border-color: black; border-style: solid; border-width: 1px;">
    <img src="/framework/core/immagini/simboli/blocco_non_trovato.png" alt="blocco non trovato" />
        Il blocco <?= $name ?> non &egrave; stato trovato.
        <br />
        Percorsi di ricerca : <br />
        <ul>
        <?  foreach (BlockFactory::get_search_dirs() as $d) { ?>
        <li><?=$d ?></li>
        <? } ?>
        </ul>
        
        Blocchi disponibili :
        <ul>
            <?php
            foreach (BlockFactory::get_available_blocks() as $bk)
                echo "<li>$bk</li>";
            ?>
        </ul>
</div>