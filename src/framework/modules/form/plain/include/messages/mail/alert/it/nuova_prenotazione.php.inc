<html>
    <head>
        <title>
            Nuova prenotazione da : <?=$nome_cognome ?> -- <?= Host::current() ?>
        </title>
    </head>
    <body>
    == Nuovo prenotazione ricevuta da <?= htmlentities($nome_cognome) ?> == <br />
    <br />
    == Telefono : <?=$telefono ?> ==<br />
    <br />
    == Email : <a href="mailto:<?=$email ?>"><?=$email ?></a> ==<br />
    <br />
    == Oggetto : <?= htmlentities($subject) ?> ==<br />
    <br />
    == Testo : ==<br />
    <br />
    <?= htmlentities($richiesta) ?>
    <br />
    <br />
    ====<br />
    <br />
    </body>
</html>