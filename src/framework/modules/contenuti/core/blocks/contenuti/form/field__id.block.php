<?
if (isset($id))
{
?>
<label for="input_id">ID : </label><input id="input_id" type="text" name="id" readonly="readonly" value="<?= isset($id) ? $id : "" ?>" /><br />
<?
}
?>