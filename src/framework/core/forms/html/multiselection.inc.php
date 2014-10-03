<select MULTIPLE id="<?=$id ?>" name="<?=$name ?>">
    <?
    foreach ($picklist_values as $k => $v)
    {
        if (is_array($v))
        {
            ?>
    <optgroup label="<?=$k ?>">
            <?
            foreach ($v as $kk => $vv)
            {
                ?>
        <option value="<?=$kk ?>" <?=$value===$kk ? "SELECTED" : "" ?>><?=$vv ?></option>
                <?
            }
            ?>
    </optgroup>
            <?
        }
        else
        {
            ?>
    <option value="<?=$k ?>" <?=$value===$kk ? "SELECTED" : "" ?>><?=$v ?></option>
            <?
        }
    }
    ?>
</select>