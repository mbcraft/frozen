<?

$num_cols_final = isset($num_cols) ? $num_cols : 22;
$num_rows_final = isset($num_rows) ? $num_rows : 8;

$spaces_after_nome_final = isset($spaces_after_nome) ? $spaces_after_nome : 0;
$spaces_after_email_final = isset($spaces_after_email) ? $spaces_after_email  : 0;

if (!isset($legend)) $legend = "Invia commento : ";
?>
<script type="text/javascript">
    function check_comment_form()
    {
       var nome =  $("#id_commenti_nome").val();
       var mail = $("#id_commenti_email").val();
       var testo = $("#id_commenti_testo").val();

       if (nome!="" && mail!="" && testo!="")
           return true;
        else
        {
           alert("Devi inserire tutti i valori richiesti!");
           return false;
        }
    }
</script>
<form name="form__commenti" method="POST" action="/actions/commenti/invia_commento.php" onsubmit="return check_comment_form();">
    <fieldset>
        <legend><span class="form_legend"><?=$legend ?></span></legend>
    </fieldset>
    <input type="hidden" name="subject" value="<?=$subject ?>" />
    <table>
        <tr>
            <td><label for="id_commenti_nome" class="form_label">Nome :*</label></td>
            <td><input id="id_commenti_nome" class="form_field" type="text" name="nome" value="" size="<?=$num_cols_final ?>" /></td>
        </tr>
        <tr>
            <td colspan="2">
                <? for ($i=0;$i<$spaces_after_nome_final;$i++) echo "<br />"; ?>
            </td>
        </tr>
        <tr>
            <td><label for="id_commenti_email" class="form_label">Email :*</label></td>
            <td><input id="id_commenti_email" class="form_field" type="text" name="email" value="" size="<?=$num_cols_final ?>" /></td>
        </tr>
        <tr>
            <td colspan="2">
                <? for ($i=0;$i<$spaces_after_email_final;$i++) echo "<br />"; ?>
            </td>
        </tr>
        <tr>
            <td valign="top"><label for="id_commenti_testo" class="form_label">Testo :*</label></td>
            <td><textarea style="width:100%;" class="form_field" id="id_commenti_testo" name="testo" rows="<?=$num_rows_final ?>" cols="<?=$num_cols_final - 2 ?>"></textarea></td>
        </tr>
        <tr>
            <td colspan="2" align="right">
                <button type="submit">
                    <div>
                        Invia
                    </div>
                </button>
            </td>
        </tr>
    </table>
    <? if (isset($on_success)) Form::on_success($on_success."?success=true"); ?>
    <? if (isset($on_failure)) Form::on_failure($on_failure."?success=false"); ?>
</form>