<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */
class Http
{
    static function get_to_file($url,$target)
    {
        if (!($target instanceof File))
            $target_file = new File($target);
        else
            $target_file = $target;
        
        if (!$target_file->exists()) $target_file->touch();
        
        $ch = curl_init($url);
        
        $fw = $target_file->openWriter();
        $handle = $fw->getHandler();
        curl_setopt($ch,CURLOPT_FILE,$handle);
        curl_exec($ch);
        curl_close($ch);
    }
    
    static function get($url)
    {
        $ch = curl_init($url);
        
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $response = curl_exec($ch);
        curl_close($ch);
        
        return $response;
    }
    
    static function post($url,$params)
    {
        $ch = curl_init($url);
        
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_POST,true);
        $post_fields = array();
        foreach ($params as $k => $v)
        {
            if ($v instanceof File)
                $post_fields[$k] = "@".$v->getPath();
            else
                $post_fields[$k] = $v;
        }
        
        curl_setopt($ch,CURLOPT_POSTFIELDS,$post_fields);
        
        
        
        $response = curl_exec($ch);
        curl_close($ch);
        
        return $response;
    }
}

?>