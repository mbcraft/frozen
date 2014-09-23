<html>
    <head>
        <title>
            [<?=$app_name ?>] - <?=$alert_title ?>
        </title>
    </head>
    <body>
        == &Egrave; stato ricevuto un alert dall'applicazione <?=$app_name ?> == <br />
        <br />

        <h3><?=$alert_title ?></h3>
        <br />
        <hr>
        <h2>SESSION</h2>
        <?= var_export($_SESSION) ?>
        <hr>
        <h2>REQUEST</h2>
        <?= var_export($_REQUEST) ?>
        <hr>
        <h2>SERVER</h2>
        <?= var_export($_SERVER) ?>
        <hr>

    </body>
</html>