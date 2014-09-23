<form enctype="multipart/form-data" method="post" action="/actions/documenti/aggiungi.php">
            <input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
            <?
            include_block("file_manager/form_modifica_documenti",$this->params);
            Form::after("/admin/contenuti/documenti/");
            ?>
            <button type="submit">
                <span>Aggiungi</span>
            </button>
        </form>