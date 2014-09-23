<html>
    <head>
        <title>Si &egrave; verificato un errore nell'applicazione.</title>
        <style>
            body
            {
                background: #FFF;
                color:#000;
            }
        </style>
    </head>
    <body>
        <h2>

            Si &egrave; verificato un errore :<br />
            <br />
            <?php
                var_dump($this->error);
            ?>

        </h2>
    </body>
</html>