<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

class ContactsController extends AbstractController
{
    function send()
    {
        $success_message = Params::get("success_message");
        
        $em = new EMail(Params::get("email"),Params::get("dest_address"),"Nuovo messaggio ricevuto",EMail::HTML_FORMAT);
    
        $vars = array("first_name" => Params::get("first_name"),"last_name" => Params::get("last_name"),"message"=> Params::get("message"));
        
        $em->render_and_send("include/mail/message.php.inc", $vars);
        
        Flash::ok(Params::get($success_message));
        
        return Redirect::success();
    }
}

?>
