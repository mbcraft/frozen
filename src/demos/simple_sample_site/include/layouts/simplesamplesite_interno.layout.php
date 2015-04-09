<?
CSS::require_css("/css/simplesamplesite.css");
?>
<!DOCTYPE HTML>
<html lang="it">
    <head>
        ##/page/headers##
        <style type="text/css">
            .citazione
            {
                font-family: Palace Script, Times New Roman, Times, Georgia, Serif;
                font-size: 20px;
                font-weight: normal;
                font-style: italic;
                color:#f2f2f2;
            }

            .cit_firma
            {
                text-align: right;
            }

            .contenuto
            {
                font-family: Palace Script, Times New Roman, Times, Georgia, Serif;
                font-size: 20px;
                font-weight: normal;
                color:#f2f2f2;
            }

            body
            {
                overflow:hidden;
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
        <img class="antie" src="##/immagine_sfondo##" alt="immagine di sfondo">
        <img class="antie_trasp" src="/immagini/grafica/layouts/simplesamplesite_laboratorio/sfondo_trasp.png" alt="sfondo trasparente">

        <div class="credits">
            <div style="text-align:center;"><? include_block("common/powered_by") ?></div>
        </div>
        <div class="content_container">
            <table cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td valign="top" style="width:60%">
                        <table cellpadding="0" cellspacing="0" border="0" width="95%">
                            <tr>
                                <td style="width:25%" valign="top" align="right"><img style="width:50px" src="/immagini/grafica/layouts/simplesamplesite_interno/cit_open.png" alt="apri citazione"/></td>
                                <td style="width:50%" class="citazione"><br />##/citazione/testo##<br /><p class="cit_firma" style="text-align:right">##/citazione/firma##</p></td>
                                <td style="width:25%" valign="bottom" align="left"><br /><br /><img style="width:50px" src="/immagini/grafica/layouts/simplesamplesite_interno/cit_close.png" alt="chiudi citazione"/><br /><br /></td>
                            </tr>
                        </table>
                    </td>
                    <td style="min-width:200px;width:200px;">

                    </td>
                    <td valign="top" style="width:40%">
                        <table cellpadding="0" cellspacing="0" border="0" style="width:95%">
                            <tr>
                                <td valign="top" style="width:90%" class="contenuto"><br />##/contenuto##</td>
                                <td style="width:10%">&nbsp;&nbsp;&nbsp;</td>
                            </tr>
                        </table>
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