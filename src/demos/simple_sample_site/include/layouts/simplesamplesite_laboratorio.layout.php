<?
CSS::require_css("/css/simplesamplesite.css");
?>
<!DOCTYPE HTML>
<html lang="it">
    <head>
        ##/page/headers##
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <style type="text/css">

            .contenuto {
                font-family: Palace Script, Times New Roman, Times, Georgia, Serif;
                font-size: 20px;
                font-weight: normal;
                color: #f2f2f2;
            }

            .vetrina {
                position: absolute;
                z-index: 50;
                width: 100%;
                top: 20%;
                text-align: center;
                color: #f2f2f2;
            }



            body {
                margin: 0;
                overflow: hidden;
                width: 100%;
                height: 100%;
                min-width:1024px;
            }

            .antie {
                position: absolute;
                z-index: 1;
                top: -20%;
                left: 0;
                width:100%;
            }

            .antie_trasp {
                position: absolute;
                z-index: 2;
                top: -20%;
                left: 0;
                width:100%;
            }
        </style>
    </head>

    <body>
        <?
        include_block("widgets/shower");
        ?>
        <img class="antie" src="##/immagine_sfondo##" alt="immagine di sfondo">
        <img class="antie_trasp" src="/immagini/grafica/layouts/simplesamplesite_laboratorio/sfondo_trasp.png" alt="sfondo trasparente">

        <div class="credits">
            <div style="text-align:center"><? include_block("common/powered_by") ?></div>
        </div>
        <div class="content_container">
            <table cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td valign="top" style="width:60%">
                        <table cellpadding="0" cellspacing="0" border="0" style="width:95%">
                            <tr>
                                <td></td>
                            </tr>
                        </table>
                    </td>
                    <td style="min-width:200px;width:200px;">

                    </td>
                    <td valign="top" style="width:40%">
                        <table cellpadding="0" cellspacing="0" border="0" width="95%">
                            <tr>
                                <td valign="top" style="width:90%" class="contenuto"><br/>##/contenuto##</td>
                                <td style="width:10%">&nbsp;&nbsp;&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>

        <div class="vetrina">
            <table align="center" style="text-align:center;">
                <tr>
                    <td style="text-align:center;">
                        <div>##/vetrine/sinistra##</div>
                    </td>
                    <td style="min-width:400px"></td>
                    <td style="text-align:center;">
                        <div>##/vetrine/destra##</div>
                    </td>
                </tr>
            </table>
        </div>
            
        <div class="footer">
            <div class="navigator">
                <div class="menu">##/main_menu##</div>
                <div class="dati_azienda">##/dati_azienda##</div>
            </div>
        </div>
    </body>
</html>