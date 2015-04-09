<?
if (isset($id_vetrina))
{
?>
<input type="hidden" name="id_vetrina" value="<?=$id_vetrina ?>" />
<?
}
?>
Titolo : <input type="text" name="titolo" value="<?= isset($titolo) ? $titolo : "" ?>" /><br />
<br />
Nome vetrina : <input type="text" name="nome_vetrina" value="<?= isset($nome_vetrina) ? $nome_vetrina : "" ?>" /><br />
<br />
Blocco vetrina : <input type="text" name="blocco_vetrina" value="<?= isset($blocco_vetrina) ? $blocco_vetrina : "" ?>" /><br />