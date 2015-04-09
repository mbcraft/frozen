<table class="paneltable" cellpadding="0" cellspacing="0">
    <tr>
        <td class="altsx"></td><td class="altce"><?=$titolo ?></td><td class="altdx"></td>
    </tr>
    <tr>
        <td class="medsx"></td>
        <td class="medce">
        <?
            if (isset($contenuto))
                echo $contenuto;
        ?>
        <?
            if (isset($menu))
            {
                echo "<ul>";
                foreach ($menu as $menu_elem)
                {
                    echo "<li>";
                    echo '<a href="'.$menu_elem["link"].'">'.$menu_elem["titolo"].'</a>';
                    echo "</li>";
                }
                echo "</ul>";
            }
        ?>

        </td>
        <td class="meddx"></td>
    </tr>
    <tr>
        <td class="bassx"></td><td class="basce"></td><td class="basdx"></td>
    </tr>
</table>