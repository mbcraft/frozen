<?
if (isset($id_evento)) {
?>
<input type="hidden" name="id_evento" value="<?=$id_evento ?>" />
<? } ?>

<label for="input_dataora_inizio">Data inizio :</label>
<input type="text" id="input_dataora_inizio" name="dataora_inizio" value="<?=$dataora_inizio ?>" /><br />

<label for="input_dataora_fine">Data fine :</label>
<input type="text" id="input_dataora_fine" name="dataora_fine" value="<?=$dataora_fine ?>" /><br />

<label for="input_indirizzo">Indirizzo :</label>
<input type="text" id="input_indirizzo" name="indirizzo" value="<?=$indirizzo ?>" /><br />

<label for="input_dataora_fine">Citta :</label>
<input type="text" id="input_citta" name="citta" value="<?=$citta ?>" /><br />

<label for="input_dataora_fine">Provincia :</label>
<input type="text" id="input_provincia" name="provincia" value="<?=$provincia ?>" /><br />

<label for="input_regione">Regione :</label>
<input type="text" id="input_regione" name="regione" value="<?=$regione ?>" /><br />

<label for="input_stato">Stato :</label>
<input type="text" id="input_stato" name="stato" value="<?=$stato ?>" /><br />