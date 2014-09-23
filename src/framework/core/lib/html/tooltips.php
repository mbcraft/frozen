<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

function fg_html_tooltip_write($text)
{
    $tip_params = "";

    $escaped_text = str_replace("'", "\'", $text);
    $escaped_text = str_replace("\r","",$escaped_text);
    $escaped_text = str_replace("\n","",$escaped_text);


    ?>
    
        <img width="15" alt="Tooltip" height="15" src="/immagini/grafica/icone/tooltip.png" onmouseover="Tip('<?=$escaped_text ?>'<?=$tip_params?>);" onmouseout="UnTip();">
    
    <?php
}


function fg_html_tooltip_iscrizione_nome_write()
{
    fg_html_tooltip_write("Inserire il nome di chi effettua l'iscrizione.");
}

function fg_html_tooltip_iscrizione_cognome_write()
{
    fg_html_tooltip_write("Inserire il cognome di chi effettua l'iscrizione.");
}

function fg_html_tooltip_iscrizione_data_nascita_write()
{
    fg_html_tooltip_write("Inserire la data di nascita di chi effettua l'iscrizione.");
}

function fg_html_tooltip_iscrizione_luogo_nascita_write()
{
    fg_html_tooltip_write("Inserire il luogo di nascita di chi effettua l'iscrizione.");
}

function fg_html_tooltip_iscrizione_ragione_sociale_write()
{
    fg_html_tooltip_write("Inserire la ragione sociale completa della societ&agrave;<br />Es: 'Frostlab gate s.n.c. di Bagnaresi Marco e Rispoli Michele'");
}

function fg_html_tooltip_iscrizione_stato_write()
{
    fg_html_tooltip_write("Inserire lo stato di residenza per le persone fisiche<br />o lo stato della sede a cui fare riferimento per la fatturazione.");
}

function fg_html_tooltip_iscrizione_regione_write()
{
    fg_html_tooltip_write("Inserire la regione di residenza per le persone fisiche<br />o la regione della sede a cui fare riferimento per la fatturazione.");
}

function fg_html_tooltip_iscrizione_provincia_write()
{
    fg_html_tooltip_write("Inserire la provincia di residenza per le persone fisiche<br />o la provincia della sede a cui fare riferimento per la fatturazione.");
}

function fg_html_tooltip_iscrizione_comune_write()
{
    fg_html_tooltip_write("Inserire il comune di residenza per le persone fisiche<br />o il comune della sede a cui fare riferimento per la fatturazione.");
}

function fg_html_tooltip_iscrizione_citta_write()
{
    fg_html_tooltip_write("Inserire la citt&agrave; di residenza per le persone fisiche<br />o la citt&agrave; della sede a cui fare riferimento per la fatturazione.");
}

function fg_html_tooltip_iscrizione_indirizzo_write()
{
    fg_html_tooltip_write("Inserire l'indirizzo completo di numero, ad esempio 'Via tal dei tali n.10',<br />
                            l'indirizzo di residenza per le persone fisiche o l'indirizzo della sede a cui fare riferimento per la fatturazione.");
}

function fg_html_tooltip_iscrizione_cap_write()
{
    fg_html_tooltip_write("Inserire il codice di avviamento postale (cap) di residenza per le persone fisiche<br />o il cap della sede a cui fare riferimento per la fatturazione.");
}

function fg_html_tooltip_iscrizione_recapito_telefonico_write()
{
    fg_html_tooltip_write("Inserire il telefono fisso o cellulare di chi effettua l'iscrizione.");
}

function fg_html_tooltip_iscrizione_email_primaria_write()
{
    fg_html_tooltip_write("Inserire l'indirizzo email a cui potranno essere inviate le comunicazioni principali.");
}

function fg_html_tooltip_iscrizione_username_write()
{
    fg_html_tooltip_write("Inserire lo username per accedere tramite l'area di accesso all'area riservata.<br />
                           Lo username pu&ograve; essere sia un indirizzo email completo che una sequenza di caratteri alfanumerici.<br />
                           Lo username deve essere compreso fra 6 e 32 caratteri, ed &egrave; case-sensitive<br />
                           ovvero distingue le maiuscole dalle minuscole.");
}

function fg_html_tooltip_iscrizione_password_write()
{
        fg_html_tooltip_write("Inserire la password per accedere tramite l'area di accesso all'area riservata.<br />
                               La password deve essere compresa fra 8 e 36 caratteri, ed &egrave; case-sensitive<br />
                               ovvero distingue le maiuscole dalle minuscole.");
}

?>