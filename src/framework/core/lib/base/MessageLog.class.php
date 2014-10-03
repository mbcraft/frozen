<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

class MessageLog
{
    private $messages;
    private $debug_messages_count;
    private $info_messages_count;
    private $warning_messages_count;
    private $error_messages_count;

    function getInfoMessageCount()
    {
        return $this->info_messages_count;
    }

    function debug($message)
    {
        $this->messages[] = array("debug" => $message);
        $this->debug_messages_count+=1;
    }

    function info($message)
    {
        $this->messages[] = array("info" => $message);
        $this->info_messages_count+=1;
    }

    function getWarningMessageCount()
    {
        return $this->warning_messages_count;
    }

    function warning($message)
    {
        $this->messages[] = array("warning" => $message);
        $this->warning_messages_count+=1;
    }

    function getErrorMessageCount()
    {
        return $this->error_messages_count;
    }

    function error($message)
    {
        $this->messages[] = array("error" => $message);
        $this->error_messages_count+=1;
    }

    function toFlash()
    {
        foreach ($this->messages as $ix => $msg)
        {
            echo $msg;
        }
    }


}