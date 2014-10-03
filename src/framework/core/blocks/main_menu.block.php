<tr> <!-- seconda riga tabella principale -->

    <td>

<div align="center" class="menu">
    <img class="bordo_menu" src="/immagini/menu/lato_sinistro.png" align="left" alt="Bordo sinistro">
    <ul id="cssdropdown">
        <li class="headlink">
            <div align="center" class="centered_text"><a class="colore_menu__fisso" href="/index.php">Home</a></div>
        </li>
        <li class="headlink">
            <div align="center" class="centered_text"><a class="colore_menu__fisso" href="/chi_siamo.php">Chi siamo</a></div>
        </li>
        <li class="headlink">
            <div align="center" class="centered_text"><a class="colore_menu__fisso" href="/soci.php">I soci</a></div>
        </li>
        <li class="headlink">
            <div align="center" class="centered_text"><a class="colore_menu__fisso" href="/gallery">Gallery</a></div>
        </li>
        <li class="headlink">
            <div align="center" class="centered_text"><a class="colore_menu__fisso" href="/forum">Forum</a></div>
        </li>
        <li class="headlink">
            <div align="center" class="centered_text"><a class="colore_menu__fisso" href="/contatti.php">Contatti</a></div>
        </li>
    </ul>
    <img class="bordo_menu" src="/immagini/menu/lato_destro.png" align="left" alt="Bordo destro">
</div>

<script language="JavaScript">

    $(document).ready(function(){
        $('#cssdropdown li.headlink').hover(
        function() { $('ul', this).css('display', 'block'); },
        function() { $('ul', this).css('display', 'none'); });
        //aggiunta funzione per click sull'intero menù'
        $('#cssdropdown li.headlink').click(
        function() { document.location = $('a',this).attr("href");}
    );
    });

</script>

            </td>
</tr> <!-- fine seconda riga tabella principale -->