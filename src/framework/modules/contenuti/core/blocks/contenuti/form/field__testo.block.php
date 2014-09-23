<label for="textarea_testo">Testo : </label><textarea style="width:100%;height:100%;" id="textarea_testo" type="text" name="testo"><?= isset($testo) ? $testo : "" ?></textarea><br />
<?
include_block("widgets/html_editor",array("folder" => "/contenuti/","htmleditor_field_id" => "textarea_testo"));
?>