            <li class="headlink">
                <a class="colore_menu__fisso" href="<?= $link ?>"><?= $title ?></a>
                <? if ($this->has_childs()) { ?>
                <ul>
<? $this->write_all_childs(); ?> 
                </ul>
                <? } ?>
            </li>
