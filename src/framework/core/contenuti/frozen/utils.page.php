<?php

if (SuperAdminUtils::is_logged())
{
Html::set_title("Utilities di amministrazione del framework");
Html::set_layout("admin_frozen");

start_sector("/pannello_centrale");
?>


        <ul>
            <li>
                <a href="/framework/utilities/phpinfo.php">PHP INFO</a>
            </li>
            <li>
                <a href="/framework/utilities/create_database.php">Crea un nuovo database in locale</a>
            </li>
            <li>
                <a href="/framework/utilities/fix_spaces.php">Rimuove spazi bianchi all'inizio e alla fine di tutte le classi php.</a>
            </li>
            <li>
                <a href="/framework/utilities/validate_modules.php">Validazione di tutti i moduli.</a>
            </li>
            <li>
                <a href="/framework/utilities/webscan.php">Scansione del sito per presenza eventuale malware.</a>
            </li>
            <li>
                <a href="/framework/utilities/fix_permissions.php">Fix di tutti i permessi delle cartelle.</a>
            </li>
            <li>
                <a href="/framework/utilities/list_tables.php">Elenca tutte le tabelle</a>
            </li>
            <li>
                <a href="/framework/utilities/init_test_env.php">Inizializza l'ambiente di test.</a>
            </li>
        </ul>

<?php
end_sector();

} else {
    header ("Location: /frozen/");
}

?>