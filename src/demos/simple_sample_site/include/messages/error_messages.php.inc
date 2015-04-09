<?php
if (Flash::has_errors())
{
?>
<div class="flash_container">
    <div class="error_container">
        <ul>
            <?php
            $all_error_messages = Flash::get_error_messages();
            foreach ($all_error_messages as $message)
                    echo "<li>".$message."</li>";
            ?>
        </ul>
    </div>
</div>
<? }  ?>

