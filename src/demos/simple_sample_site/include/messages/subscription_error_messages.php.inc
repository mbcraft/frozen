<?php
/*
 *  Attenzione, ci sono # dati incompleti o inesatti.
 *
 *  Si sono verificati # errori. [Fai click per visualizzarli]
 *
 *
 *  Ti preghiamo di verificare i seguenti # campi ;
 * */
if (Flash::has_errors())
{
?>
<div id="flash_errors" class="flash_container">
    <?
    if (count(Flash::get_error_messages())>3)
    {
    ?>
        <p align="center" style="font-size: 13px;color:red;">Ti preghiamo di verificare i seguenti <?=count(Flash::get_error_messages()) ?> campi. [Fai click per visualizzarli]</p>
    <?
    }
    ?>
    <div class="error_container" style="<?=count(Flash::get_error_messages())>3 ? "display:none;" : "" ?>">
        <ul>
            <?php
            $all_error_messages = Flash::get_error_messages();
            foreach ($all_error_messages as $message)
                    echo "<li>".$message."</li>";
            ?>
        </ul>
    </div>
</div>
    <?
    if (count(Flash::get_error_messages())>3)
    {
    ?>
<script type="text/javascript">
    $(document).ready(function()
    {
      jQuery(".error_container").hide();
      //toggle the componenet with class msg_body
      jQuery("#flash_errors p").click(function()
      {
        jQuery(this).next(".error_container").slideToggle(500);
      });
    });
</script>
<? } } ?>