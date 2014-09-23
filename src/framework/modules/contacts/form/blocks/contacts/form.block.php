<form name="form_contacts" method="post" action="/actions/contacts/send.php">
    <input type="hidden" name="dest_address" value="<?=$dest_address ?>" />
    <input type="hidden" name="success_message" value="<?=$success_message ?>" />
    <table cellspacing="5px" cellpadding="5px">
        <tr>
            <td style="text-align:right;vertical-align: top;"><label for="form_contact_email" class="form_contact_label">Email <span style="color:red;">*</span>:</label></td>
            <td><input id="form_contact_email" type="text" name="email" value="" size="25" /></td>
        </tr>
        <tr>
            <td style="text-align:right;vertical-align: top;"><label for="form_contact_first_name" class="form_contact_label">First name <span style="color:red;">*</span>:</label></td>
            <td><input id="form_contact_first_name" type="text" name="first_name" value="" size="30" /></td>            
        </tr>
        <tr>
            <td style="text-align:right;vertical-align: top;"><label for="form_contact_last_name" class="form_contact_label">Last name <span style="color:red;">*</span>:</label></td>
            <td><input id="form_contact_last_name" type="text" name="last_name" value="" size="30" /></td>           
        </tr>
        <tr>
            <td style="text-align:right;vertical-align: top;"><label for="form_contact_message" class="form_contact_label">Message <span style="color:red;">*</span>:</label></td>
            <td><textarea id="form_contact_message" name="message" rows="4" cols="30"></textarea></td>            
        </tr>
        <tr>
            <td></td>
            <td><input class="form_contact_submit" type="submit" name="Submit message" value="Submit message" /></td>
        </tr>
    </table> 
    <?
    Form::on_success($success_url);
    ?>
</form>