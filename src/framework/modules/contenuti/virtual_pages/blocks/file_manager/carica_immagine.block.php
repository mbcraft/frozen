<form enctype="multipart/form-data" method="post" action="/actions/immagini/aggiungi.php">
            <input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
            <?
            include_block("file_manager/form_modifica_immagini",$this->params);
            Form::after("/admin/contenuti/immagini/");
            ?>
            <button type="submit">
                <span>Aggiungi</span>
            </button>
        </form>