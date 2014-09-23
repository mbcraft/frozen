<form method="post" action="/actions/folder/create.php">
    Crea cartella :
    <input type="text" name="name" value="" size="30" />
    <input type="hidden" name="current_folder" value="<?=$current_folder ?>" />
    <?
    Form::after($after_action);
    ?>
    <button type="submit">
        <span>Crea</span>
    </button>
</form>