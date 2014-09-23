<?
include_block("contenuti/form/field__id",$this->params);
?>
<label for="input_my_file">File : </label><input id="input_my_file" type="file" name="my_file" /><br />
<?
include_block("contenuti/form/field__nome",$this->params);
include_block("contenuti/form/field__descrizione",$this->params);
include_block("contenuti/form/field__keywords",$this->params);
?>
<input type="hidden" name="folder" value="<?=$folder ?>" />