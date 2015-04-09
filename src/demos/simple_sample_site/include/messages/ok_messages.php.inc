<?php
if (Flash::has_oks())
{
?>
<div id="flash_oks" class="flash_container">
    <div class="ok_container"></div>
    <ul>
        <?php
        $all_ok_messages = Flash::get_ok_messages();
        foreach ($all_ok_messages as $message)
                echo "<li>".$message."</li>";
        ?>
    </ul>
</div>
<?php } ?>