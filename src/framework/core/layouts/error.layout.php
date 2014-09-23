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
            RouteMap::print_definitions_as_html_list();
            Log::print_logs_as_html_list();
            echo $this->error;
        ?>
        <br />

    </h2>
</body>
</html>