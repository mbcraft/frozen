<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

class EMail extends BasicObject
{
    const HTML_FORMAT = "HTML_FORMAT";
    const TXT_FORMAT = "TXT_FORMAT";

    private $from,$to,$subject,$format;

    private $cc_contacts = array();
    private $bcc_contacts = array();

    function __construct($from,$to,$subject,$format)
    {
        if ($format!==self::HTML_FORMAT && $format!==self::TXT_FORMAT) Log::error("__construct", "Errore nella creazione della mail : formato sconosciuto.");

        $this->from = $from;
        $this->to = $to;
        $this->subject = $subject;
        $this->format = $format;
    }

    public function add_cc($cc_contact)
    {
        $this->cc_contacts[] = $cc_contact;
    }

    public function add_bcc($bcc_contact)
    {
        $this->bcc_contacts[] = $bcc_contact;
    }

    public function render_and_send($path_mail_template,$template_vars=array())
    {
        extract($template_vars);
        ob_start();

        $f = new File(DS.$path_mail_template);
        if ($f->exists())
            include($path_mail_template);
        else
        {
            echo "ATTENZIONE : template ".$path_mail_template." non trovato!!";
        }
        $message = ob_get_contents();
        ob_end_clean();
        $this->send($message);
    }

    public function send($message)
    {
        if ($this->format == self::HTML_FORMAT)
        {
            $this->send_html_email($message);
        }
        if ($this->format == self::TXT_FORMAT)
        {
            $this->send_text_email($message);
        }
    }

    private function __get_mail_headers($txt_email)
    {
        // costruiamo alcune intestazioni generali
        $headers = "From: ".$this->from."\n";
        $headers .= "X-Mailer: Frostlab Gate Mail Bot\n";

        // costruiamo le intestazioni specifiche per il formato HTML
        $headers .= "MIME-Version: 1.0\n";
        if ($txt_email)
            $headers .= "Content-Type: text/plain; charset=\"iso-8859-1\"\r\n";
        else
            $headers .= "Content-Type: text/html; charset=\"iso-8859-1\"\r\n";
        $headers .= "Content-Transfer-Encoding: 7bit\n";

        if (count($this->cc_contacts)>0)
        {
            $cc_string = "Cc: ";
            foreach ($this->cc_contacts as $cc)
                $cc_string.=$cc.",";
            substr($cc_string,strlen($cc_string)-1);
            $cc_string .= "\n";
            $headers .= $cc_string;
        }

        if (count($this->bcc_contacts)>0)
        {
            $bcc_string = "Bcc: ";
            foreach ($this->bcc_contacts as $bcc)
                $bcc_string.=$bcc.",";
            substr($bcc_string,strlen($bcc_string)-1);
            $bcc_string .= "\n";
            $headers .= $bcc_string;
        }

        $headers.= "\n";

        return $headers;
    }

    private function send_text_email($txt_message)
    {
        $headers = $this->__get_mail_headers(true);

        $result = @mail($this->to,$this->subject,$txt_message,$headers);

        if (!$result) $this->__error(__METHOD__,"Si e' verificato un errore nell'invio della mail : TO=".$this->to." SUBJECT=".$this->subject.".");

    }

    private function send_html_email($html_message)
    {
        $headers = $this->__get_mail_headers(false);

        $result = @mail($this->to,$this->subject,$html_message,$headers);

        if (!$result) $this->__error(__METHOD__,"Si e' verificato un errore nell'invio della mail : TO=".$this->to." SUBJECT=".$this->subject.".");
    }

    public static function is_valid($email)
    {
        return preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $email);
    }

    public static function alert($app_name,$alert_title)
    {
        $e = new EMail("alert@".Host::current(),"info@frostlab.it","[".$app_name."] - ".$alert_title,EMail::HTML_FORMAT);
        $e->render_and_send("framework/core/messages/alert/alert.php.inc",array("app_name" => $app_name,"alert_title" =>$alert_title));
    }

}

?>