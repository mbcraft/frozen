<html>
    <head>
        <title>
            Nuovo commento da : <?=$nome ?> -- <?= Host::current() ?>
        </title>
    </head>
    <body>
    == Nuovo commento ricevuto da <?= htmlentities($nome) ?> == <br />
    <br />
    == Email : <a href="mailto:<?=$email ?>"><?=$email ?></a> ==<br />
    <br />
    == Oggetto : <?= htmlentities($subject) ?> ==<br />
    <br />
    == Testo : ==<br />
    <br />
    <?= htmlentities($testo) ?>
    <br />
    <br />
    ====<br />
    <br />
    </body>
</html>