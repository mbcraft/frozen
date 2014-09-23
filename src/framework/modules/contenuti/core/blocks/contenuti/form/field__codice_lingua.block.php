
<?
if (isset($codice_lingua)) $current_value = $codice_lingua;
else $current_value = null;
?>
<label for="select_codice_lingua">Lingua : </label>
    <select name="codice_lingua" id="select_codice_lingua">
        <?
        if (Language::isEnabled("it")) {
        ?>
        <option value="it" <?=$current_value=="it" ? "selected" : "" ?>>Italiano</option>
        <? 
        } 
        if (Language::isEnabled("en")) {
        ?>
        <option value="en" <?=$current_value=="en" ? "selected" : "" ?>>Inglese</option>
        <?
        }
        if (Language::isEnabled("es")) {
        ?>
        <option value="es" <?=$current_value=="es" ? "selected" : "" ?>>Spagnolo</option>
        <?
        }
        if (Language::isEnabled("fr")) {
        ?>
        <option value="fr" <?=$current_value=="fr" ? "selected" : "" ?>>Francese</option>
        <?
        }
        if (Language::isEnabled("de")) {
        ?>
        <option value="de" <?=$current_value=="de" ? "selected" : "" ?>>Tedesco</option>
        <?
        }
        ?>
    </select><br />