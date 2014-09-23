<hr/>
<h3>Moduli disponibili :</h3>
<hr/>
<table class="module_list" id="moduli_disponibili">
    <thead>
    <tr>
        <th>Categoria</th>
        <th>Nome</th>
        <th>Versione</th>
        <th>Comandi</th>
    </tr>
    </thead>
    <tbody>
        <?php
        foreach ($available_modules as $modulo)
        {          
            if ($modulo["show"])
                include_block("modules/__riga_modulo_disponibile",array("modulo" => $modulo));
        }
        ?>
    </tbody>
</table>