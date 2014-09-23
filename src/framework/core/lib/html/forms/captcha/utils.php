<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */
require("lib/captcha/securimage/securimage.php");

function fg_form_write_captcha()
{
    fg_form_start_table("Inserisci il codice di sicurezza ");
    ?>

        <tr>
            <td align="center">
                
                <br />
                    <img border="5" src="/lib/captcha/securimage/securimage_show.php?sid=<?php echo md5(uniqid(time())); ?>" id="captcha" align="absmiddle">

                    <br />

                    <a href="/lib/captcha/securimage/securimage_play.php" style="font-size: 13px">(Ascolta in inglese)</a><br />

                    <a href="#" style="font-size: 13px" onclick="document.getElementById('captcha').src = '/lib/captcha/securimage/securimage_show.php?sid=' + Math.random(); return false">(Cambia immagine)</a>

                
                
            </td>

            <td align="center">

            
            
            Codice:

            <br />
            
            <input class="form_field_enabled"  type="text" name="codice_captcha" value="" size="6">

                
                
            </td>

        </tr>
    <?php
    fg_form_end_table();
}

function fg_is_captcha_ok()
{
    $img = new Securimage();
    return $img->check($_POST['codice_captcha']);
}

?>