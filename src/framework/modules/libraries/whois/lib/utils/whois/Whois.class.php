<?
/* This software is released under the BSD license. Full text at project root -> license.txt */

class Whois
{
  var $mappa_estensione_server = array (
      "it" => "whois.nic.it",
      "com" => "whois.internic.net",
      "net"  => "whois.internic.net",
      "org"  => "whois.publicinterestregistry.net",
      "info" => "whois.afilias.net",
      "biz"  => "whois.neulevel.biz",
      "eu"  => "whois.registry.eu",
      "name"  => "whois.nic.name",
      "mobi"  => "whois.dotmobiregistry.net",
      "us" => "whois.nic.us",
      "me" => "whois.meregistry.net",
      "tv" => "whois.nic.tv",
      "ws" => "whois.nic.ws",
      "cn" => "whois.cnnic.cn"
  );

  function search($dominio) {
    $dominio = strtolower(trim($dominio));
    $pos_punto = strrpos($dominio, ".");
    if (!$pos_punto) {
      return "nome di dominio non valido";
    } else {
      $estensione = substr($dominio, $pos_punto + 1);
      if (!array_key_exists($estensione,$this->mappa_estensione_server)) {
        return "estensione <b><i>.".$estensione."</i></b> non supportata";
      }
    }
    $server = $this->mappa_estensione_server[$estensione];
    $puntatore_whois =  fsockopen($server, 43, $errno, $errstr, 30);
    $html_output = '';
    if (!$puntatore_whois) {
      $html_output = "$errstr ($errno)";
    } else {
       fputs($puntatore_whois, "$dominio\r\n");
       $html_output .= "<pre>\r\n";
       while (!feof($puntatore_whois)) {
         $html_output .= fread($puntatore_whois,128);
       }
      $html_output .= "</pre>";
       fclose ($puntatore_whois);
    }
    return $html_output;
  }

  function search_from_full_domain($full_domain)
  {
      $h_tok = explode(".",$full_domain);

      $search_hostname = $h_tok[count($h_tok)-2].".".$h_tok[count($h_tok)-1];

      return $this->search($search_hostname);
  }

  function allowed_extensions_to_string()
  {
    $vettore_estensioni = array_keys($this->mappa_estensione_server);
    $estensioni_supportate = '';
    for ($i = 0; $i < count($vettore_estensioni); $i++) {
      $estensioni_supportate .= '&nbsp;.'.$vettore_estensioni [$i].'&nbsp;';
    }
    return $estensioni_supportate;
  }

  function get_allowed_extensions()
  {
    return $this->get_allowed_extensions();
  }
}

?>