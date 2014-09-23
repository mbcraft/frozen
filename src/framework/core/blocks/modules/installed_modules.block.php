<hr />
<h3>Moduli installati :</h3>
<hr />
<table class="module_list" id="moduli_installati">
<thead>
<tr>
    <th>Nome categoria</th>
    <th>Nome modulo</th>
    <th>Versione installata</th>
    <th>Moduli mancanti</th>
    <th>Servizi mancanti</th>
    <th>Comandi</th>
</tr>
</thead>
<tbody>
    <?php
    foreach ($installed_modules as $modulo)
    {
        include_block("modules/__riga_modulo_installato",array("modulo" => $modulo));
    }
    ?>
</tbody>
</table>