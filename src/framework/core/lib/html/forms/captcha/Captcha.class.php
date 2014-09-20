<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */
class Captcha {

    function isValid() {
        $img = new Securimage();
        return $img->check($_POST['codice_captcha']);
    }

    function __write_captcha_image($class="")
    {
        ?>
            <img border="5" class="<?=$class ?>" src="/<?=FRAMEWORK_CORE_PATH ?>lib/html/forms/captcha/securimage/securimage_show.php?sid=<?php echo md5(uniqid(time())); ?>" id="img_captcha" align="absmiddle" />
        <?
    }

    function __write_listen_captcha($class="",$listen_text="(Ascolta in inglese)")
    {
        ?>
        <a class="<?=$class ?>" href="/<?=FRAMEWORK_CORE_PATH ?>lib/html/forms/captcha/securimage/securimage_play.php"><?=$listen_text ?></a>
        <?
    }

    function __write_change_captcha($class="",$change_image_text="(Cambia immagine)")
    {
        ?>
        <a href="#" class="<?=$class ?>" onclick="document.getElementById('img_captcha').src = '/<?=FRAMEWORK_CORE_PATH ?>lib/html/forms/captcha/securimage/securimage_show.php?sid=' + Math.random(); return false"><?=$change_image_text ?></a>
        <?
    }

    function __write_form_label($class="",$text="Codice:")
    {
        ?>
            <label class="<?=$class ?>" for="input_captcha"><?=$text ?></label>
        <?
    }

    function __write_form_field($class="")
    {
        ?>
            <input class="<?=$class ?>" id="input_captcha" type="text" name="codice_captcha" value="" size="6" title="Inserire il codice visualizzato a fianco (obbligatorio).">
        <?
    }

    function write($layout_file="framework/core/forms/html/captcha.inc.php")
    {
        include($layout_file);
    }

}
?>