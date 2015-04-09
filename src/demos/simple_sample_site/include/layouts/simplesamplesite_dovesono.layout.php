<?
CSS::require_css("/css/simplesamplesite.css");
?>
<!DOCTYPE HTML>
<html lang="it">
<head>
    ##/page/headers##
    <style type="text/css">

        html {
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        body {
            width: 100%;
            height: 100%;
            margin: 0;
            overflow: hidden;
            background-color: #a5bfdd;
        }

    </style>
</head>
<body>
<div align="center" style="height:100%;z-index:10;">
    <iframe src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d51655.0722554513!2d-5.4040658!3d35.985065!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sit!2sit!4v1428585033184" width="600" height="450" frameborder="0" style="border:0"></iframe><br /><small><a href="https://www.google.it/maps/@35.985065,-5.4040658,13z" style="color:#0000FF;text-align:left">Visualizzazione ingrandita della mappa</a></small></div>
<div class="credits">
    <div style="text-align:center"><? include_block("common/powered_by") ?></div>
</div>
<div class="footer">
    <div class="navigator">
        <div class="menu">##/main_menu##</div>
        <div class="dati_azienda">##/dati_azienda##</div>
    </div>
</div>
</body>
</html>