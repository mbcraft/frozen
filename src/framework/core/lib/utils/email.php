<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */
class EMail
{
    const HTML_FORMAT = "HTML_FORMAT";
    const TXT_FORMAT = "TXT_FORMAT";

    private $from,$to,$subject,$format;

    private $cc_contacts = array();
    private $bcc_contacts = array();

    /*
     * Costruttore : i parametri sono :
     * from : il destinatario
     * to : chi riceve la mail
     * subject : l'oggetto
     * format : una costante a scelta tra Email::HTML_FORMAT e Email::TXT_FORMAT
     */
    function __construct($from,$to,$subject,$format)
    {
        if ($format!==self::HTML_FORMAT && $format!==self::TXT_FORMAT) throw new Exception("Errore nella creazione della mail : formato sconosciuto.");

        $this->from = $from;
        $this->to = $to;
        $this->subject = $subject;
        $this->format = $format;
    }

    /*
     * Aggiunge un contatto mail alla lista dei cc
     * */
    public function add_cc($cc_contact)
    {
        $this->cc_contacts[] = $cc_contact;
    }

    /*
     * Aggiunge un contatto mail alla lista dei bcc
     * */
    public function add_bcc($bcc_contact)
    {
        $this->bcc_contacts[] = $bcc_contact;
    }

    /*
     * Invia il messaggio specificato come parametro. Il parametro message deve contenere tutto il testo della mail,
     * in formato html o txt.
     * */
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
        $headers .= "X-Mailer: MBCRAFT Mail Bot\n";

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

        if (!$result) throw new Exception("Si e' verificato un errore nell'invio della mail : TO=".$this->to." SUBJECT=".$this->subject.".");

    }

    private function send_html_email($html_message)
    {
        $headers = $this->__get_mail_headers(false);

        $result = @mail($this->to,$this->subject,$html_message,$headers);

        if (!$result) throw new Exception("Si e' verificato un errore nell'invio della mail : TO=".$this->to." SUBJECT=".$this->subject.".");
    }

}

?>