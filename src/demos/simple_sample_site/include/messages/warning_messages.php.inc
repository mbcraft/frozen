<?php
if (Flash::has_warnings())
{
?>
<div id="flash_warnings" class="flash_container">
    <div class="warning_container">
        <ul>
            <?php
            $all_warning_messages = Flash::get_warning_messages();
            foreach ($all_warning_messages as $message)
                    echo "<li>".$message."</li>";
            ?>
        </ul>
    </div>
</div>
<?php } ?>
