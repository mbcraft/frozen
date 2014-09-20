<?php
/**
 * Libreria per l'invio di SMS tramite il servizio SMS-Web offerto da Mobyt Srl
 *
 * - <b>Versione 1.2.0</b>
 * - Aggiunto supporto alle nuova {@link mobytSms::setQualityAuto() qualita' automatica}
 * - Aggiunto supporto agli sms con {@link mobytSms::setQualityAutoNotify() notifica}
 * - Aggiunto supporto agli sms {@link mobytWapPush Wap/Push}
 * - <b>Versione 1.2.1</b>
 * - Aggiunto supporto alle suonerie in {@link mobytRTTTL formato RTTTL}
 * - <b>Versione 1.2.2</b>
 * - Bugfix: la versione, utile per motivi di debug, non veniva inviata correttamente al server
 * - <b>Versione 1.2.3</b>
 * - Bugfix: corretto un problema nell'invio di messaggi Wap/Push
 * - <b>Versione 1.2.4</b>
 * - Aggiunta possibilita' di ottenere il {@link mobytSms::getAvailableNotifies() numero di notifiche disponibili}
 * - <b>Versione 1.2.5</b>
 * - Aggiunto supporto per l'invio multiplo tramite SMS-Batch (FTP)
 * - <b>Versione 1.3.0</b>
 * - Classe aggiornata alla nuova documentazione
 * - <b>Versione 1.3.1</b>
 * - Aggiunto supporto ai messaggi Flash
 * - Aggiunta compatibilita' con register_long_arrays off (opzione PHP5) in sms-relay.php
 * - <b>Versione 1.3.2</b>
 * - Risolto problema nella scelta della qualita' se la classe viene inclusa all'interno di una funzione
 * - <b>Versione 1.3.3</b>
 * - Aggiunto supporto al servizio {@link mobytMnc MNC (Mobyt Number Check)}
 * - <b>Versione 1.4.0</b>
 * - Aggiunto supporto al servizio {@link mobytMMS MMS}
 * - <b>Versione 1.4.1</b>
 * - Risolti problemi nell'utilizzo del servizio MNC
 * - <b>Versione 1.4.2</b>
 * - Risolti problemi nell'esempio MNC
 * - <b>Versione 1.4.3</b>
 * - Modificata spedizione FTP per consentire invio SMS con notifica
 * - <b>Versione 1.4.4</b>
 * - Aggiunto supporto per la ricezione MMS 
 * - <b>Versione 1.5.0</b>
 * - Aggiunto supporto per l'invio di MMS video
 * - Compatibilita' PHP4 - PHP5 
 * - <b>Versione 1.5.1</b>
 * - Aggiunto supporto per le notifiche MMS
 * - Compatibilita' PHP4 - PHP5 
 *
 * @version 1.5.1
 * @package Mobyt-SmsWeb
 * @author  Mobyt - help@mobyt.it
 * @copyright (C) 2003-2011 Mobyt srl
 * @license https://www.mobyt.it/bsd-license.html BSD License
 *
 */

/**#@+
 * @access	private
 */
/**
 * Versione della classe
 */
define('MOBYT_PHPSMS_VERSION',	'1.5.0');
/**
 * Tipo di autenticazione basata su MD5, con password <b>non</b> inviata in chiaro
 */
define('MOBYT_AUTH_MD5',	1);
/**
 * Tipo di autenticazione basata su IP, con password inviata in chiaro
 */
define('MOBYT_AUTH_PLAIN',	2);

/**
 * Qualita' messaggi in base al valore di default dell'account
 */
define('MOBYT_QUALITY_DEFAULT',	0);
/**
 * Qualita' messaggi bassa (LQS)
 */
define('MOBYT_QUALITY_LQS',	1);
/**
 * Qualita' messaggi media (MQS)
 */
define('MOBYT_QUALITY_MQS',	2);
/**
 * Qualita' messaggi alta (HQS)
 */
define('MOBYT_QUALITY_HQS',	3);
/**
 * Qualita' messaggi automatica
 */
define('MOBYT_QUALITY_AUTO',	4);
/**
 * Qualita' messaggi automatica con notifica
 */
define('MOBYT_QUALITY_AUTO_NY',	5);

/**
 * Tipo operazione TEXT
 */
define('MOBYT_OPERATION_TEXT',	0);
/**
 * Tipo operazione RING
 */
define('MOBYT_OPERATION_RING',	1);
/**
 * Tipo operazione Logo Operatore
 */
define('MOBYT_OPERATION_OLGO',	2);
/**
 * Tipo operazione Logo Gruppo
 */
define('MOBYT_OPERATION_GLGO',	3);
/**
 * Tipo operazione 8 bit
 */
define('MOBYT_OPERATION_8BIT',	4);
/**
 * Tipo operazione Flash
 */
define('MOBYT_OPERATION_FLASH',	5);

/**
 * @global array Array di conversione per le qualita'
 */
$GLOBALS['mobyt_qty'] = array(
		MOBYT_QUALITY_LQS		=> 'll',
		MOBYT_QUALITY_MQS		=> 'l',
		MOBYT_QUALITY_HQS		=> 'h',
		MOBYT_QUALITY_AUTO		=> 'a',
		MOBYT_QUALITY_AUTO_NY	=> 'a'
	);
	
/**
 * @global array Array di conversione per l'operazione
 */
$GLOBALS['mobyt_ops'] = array(
		MOBYT_OPERATION_TEXT	=> 'TEXT',
		MOBYT_OPERATION_RING	=> 'RING',
		MOBYT_OPERATION_OLGO	=> 'OLGO',
		MOBYT_OPERATION_GLGO	=> 'GLGO',
		MOBYT_OPERATION_8BIT	=> '8BIT',
		MOBYT_OPERATION_FLASH	=> 'FLASH'
	);
/**#@-*/

/**
 * Classe per l'invio di SMS tramite il servizio SMS-Web
 *
 * Le impostazioni utilizzate di default sono:
 * - Mittente: <b>"MobytSms"</b>
 * - Autenticazione: <b>MD5</b>
 * - Qualita': <b>Non impostata</b> - Il default a' l'utilizzo della modalita' automatica
 *
 * @package Mobyt-SmsWeb
 * @example sms-single.php Invio di un singolo sms in alta qualita' con autenticazione MD5
 */
class mobytSms
{
	/**#@+
	 * @access	private
	 * @var		string
	 */
	var $auth = MOBYT_AUTH_MD5;
	var $quality = MOBYT_QUALITY_DEFAULT;
	var $operation = MOBYT_OPERATION_TEXT;
	var $from;
	var $login;
	var $pwd;
	var $udh;
	/**#@-*/
	
	/**
	 * @param string	Username di accesso (Login)
	 * @param string	Password dispositiva
	 * @param string	Intestazione mittente
	 *
	 * @see setFrom
	 */
	function mobytSms($login, $pwd, $from = 'MobytSms')
	{
		$this->login = $login;
		$this->pwd = $pwd;
		$this->setFrom($from);
	}
	
	/**
	 * Imposta intestazione mittente
	 *
	 * Il mittente pua' essere composto da un massimo di 11 caratteri alfanumerici o un numero telefonico
	 * con prefisso internazionale. 
	 *
	 * @param string	Intestazione mittente
	 */
	function setFrom($from)
	{
		$this->from = substr($from, 0, 14);
	}
	
	
	/**
	 * Utilizza l'autenticazione di tipo MD5
	 */
	function setAuthMd5()
	{
		$this->auth = MOBYT_AUTH_MD5;
	}
	
	/**
	 * Utilizza l'autenticazione con password in chiaro basata sull'IP
	 */
	function setAuthPlain()
	{
		$this->auth = MOBYT_AUTH_PLAIN;
	}
	
	
	/**
	 * Imposta la qualita' messaggi al default dell'account
	 */
	function setQualityDefault()
	{
		$this->quality = MOBYT_QUALITY_DEFAULT;
	}
	
	/**
	 * Imposta la qualita' messaggi come bassa
	 */
	function setQualityLow()
	{
		$this->quality = MOBYT_QUALITY_LQS;
	}
	
	/**
	 * Imposta la qualita' messaggi come media
	 */
	function setQualityMedium()
	{
		$this->quality = MOBYT_QUALITY_MQS;
	}
	
	/**
	 * Imposta la qualita' messaggi come alta
	 */
	function setQualityHigh()
	{
		$this->quality = MOBYT_QUALITY_HQS;
	}
	
	/**
	 * Imposta la qualita' messaggi automatica
	 */
	function setQualityAuto()
	{
		$this->quality = MOBYT_QUALITY_AUTO;
	}
	
	/**
	 * Imposta la qualita' messaggi automatica con notifica
	 *
	 * @example sms-single-notify.php Invio di un singolo sms con notifica
	 * @example sms-multi-notify.php Invio sms multipli con notifica
	 */
	function setQualityAutoNotify()
	{
		$this->quality = MOBYT_QUALITY_AUTO_NY;
	}
		
	/**
	 * Imposta il tipo di messaggio a TEXT
	 */
	function setOperationText()
	{
		$this->operation = MOBYT_OPERATION_TEXT;
	}
			
	/**
	 * Imposta il tipo di messaggio a RING (suoneria)
	 *
	 * L'invio di messaggi di tipo RING necessita l'invio in alta qualita' o con notifica.
	 * Questa verra' impostata automaticamente, tranne nel caso in cui sia stata impostata la qualita' automatica con notifica
	 *
	 * @example sms-single-ring.php Invio di un singolo sms in modalita' RING
	 */
	function setOperationRing()
	{
		$this->operation = MOBYT_OPERATION_RING;
		
		if ($this->quality != MOBYT_QUALITY_AUTO_NY)
			$this->setQualityHigh();
	}
	
	/**
	 * Imposta il tipo di messaggio a OLGO (logo operatore)
	 *
	 * L'invio di messaggi di tipo OLGO necessita l'invio in alta qualita' o con notifica.
	 * Questa verra' impostata automaticamente, tranne nel caso in cui sia stata impostata la qualita' automatica con notifica
	 */
	function setOperationOlgo()
	{
		$this->operation = MOBYT_OPERATION_OLGO;
		
		if ($this->quality != MOBYT_QUALITY_AUTO_NY)
			$this->setQualityHigh();
	}
	
	/**
	 * Imposta il tipo di messaggio a GLGO (logo gruppo)
	 *
	 * L'invio di messaggi di tipo GLGO necessita l'invio in alta qualita' o con notifica.
	 * Questa verra' impostata automaticamente, tranne nel caso in cui sia stata impostata la qualita' automatica con notifica
	 */
	function setOperationGlgo()
	{
		$this->operation = MOBYT_OPERATION_GLGO;
		
		if ($this->quality != MOBYT_QUALITY_AUTO_NY)
			$this->setQualityHigh();
	}

	/**
	 * Imposta il tipo di messaggio a 8 bit
	 *
	 * L'invio di messaggi di tipo 8BIT necessita l'invio in alta qualita' o con notifica.
	 * Questa verra' impostata automaticamente, tranne nel caso in cui sia stata impostata la qualita' automatica con notifica
	 *
	 * @param string UDH
	 */
	function setOperation8Bit($udh)
	{
		$this->operation = MOBYT_OPERATION_8BIT;
		
		$this->udh = $udh;
		
		if ($this->quality != MOBYT_QUALITY_AUTO_NY)
			$this->setQualityHigh();
	}
		
	/**
	 * Imposta il tipo di messaggio a FLASH
	 */
	function setOperationFlash()
	{
		$this->operation = MOBYT_OPERATION_FLASH;
	}
	
	
	
	/**
	 * Controlla il credito disponibile espresso in Euro
	 *
	 * @returns mixed Un intero corrispondente al credito o <i>FALSE</i> in caso di errore
	 *
	 * @example sms-credit.php Controllo credito e messaggi disponibili
	 */
	function getCredit()
	{
		$op = 'GETCREDIT';
		
		$fields = array(
				'operation' => $op,
				'id'		=> $this->login,
				'password'	=> $this->auth == MOBYT_AUTH_MD5 ? '' : $this->pwd,
				'ticket'	=> $this->auth == MOBYT_AUTH_MD5 ? md5($this->login.$op.$this->pwd) : ''
			);
		
		if (preg_match('/^OK (\d+)/', $this->httpPost($fields), $m))
			return intval($m[1]);
		
		return false;
	}
	
	
	
	/**
	 * Controlla il numero approssimativo di messaggi disponibili
	 *
	 * <b>N.B.</b> Il numero di messaggi disponibile dipende dalla qualita' con cui verranno inviati.
	 *
	 * @returns mixed Un intero corrispondente al numero di messaggi o <i>FALSE</i> in caso di errore
	 *
	 * @example sms-credit.php Controllo credito e messaggi disponibili
	 */
	function getAvailableSms()
	{
		$op = 'GETMESS';
		
		$fields = array(
				'operation' => $op,
				'id'		=> $this->login,
				'password'	=> $this->auth == MOBYT_AUTH_MD5 ? '' : $this->pwd,
				'ticket'	=> $this->auth == MOBYT_AUTH_MD5 ? md5($this->login.$op.$this->pwd) : ''
			);
		
		if (preg_match('/^OK (\d+)/', $this->httpPost($fields), $m))
			return intval($m[1]);
		
		return false;
	}
	
	
	
	/**
	 * Controlla il numero di notifiche disponibili
	 *
	 * @returns mixed Un intero corrispondente al numero di notifiche o <i>FALSE</i> in caso di errore
	 */
	function getAvailableNotifies()
	{
		$op = 'GETNOTIFY';
		
		$fields = array(
				'operation' => $op,
				'id'		=> $this->login,
				'password'	=> $this->auth == MOBYT_AUTH_MD5 ? '' : $this->pwd,
				'ticket'	=> $this->auth == MOBYT_AUTH_MD5 ? md5($this->login.$op.$this->pwd) : ''
			);
		
		if (preg_match('/^OK (\d+)/', $this->httpPost($fields), $m))
			return intval($m[1]);
		
		return false;
	}

	/**
	 * Invia un SMS
	 *
	 * Nel caso sia utilizzata la qualita' automatica con notifica, sera' necessario passare un identificatore univoco di max 20 caratteri numerici come terzo parametro. Qualora non venisse impostato, ne verra' generato uno casuale in maniera automatica, per permettere il corretto invio del messaggio.
	 *
	 * @param string Numero telefonico con prefisso internazionale (es. +393201234567)
	 * @param string Testo del messaggio (max 160 caratteri)
	 * @param string Identificatore univoco del messaggio da utilizzare nel caso sia richiesta la notifica 
	 *
	 * @returns string Risposta ricevuta dal gateway ("OK ..." o "KO ...")
	 *
	 * @example sms-single.php Invio di un singolo sms in alta qualita' con autenticazione MD5
	 */
	function sendSms($rcpt, $text, $act = '')
	{
		global $mobyt_qty, $mobyt_ops;
		
		$operation = isset($mobyt_ops[$this->operation]) ? $mobyt_ops[$this->operation] : 'TEXT';
		
		$fields = array(
				'operation' => $operation,
				'from'		=> $this->from,
				'rcpt'		=> $rcpt,
				'data'		=> $text,
				'id'		=> $this->login
			);
		
		if ($this->quality == MOBYT_QUALITY_AUTO_NY)
		{
			if ($act == '')
			{
				// Generate random act
				while (strlen($act) < 16)
					$act .= preg_replace('/[^0-9]/', '', md5(uniqid('', true)));
				
				if (strlen($act) > 20)
					$act = substr($act, 0, 20);
			}
						
			$fields['act'] = $act;
		}
		
		if ($this->quality != MOBYT_QUALITY_DEFAULT && isset($mobyt_qty[$this->quality]))
			$fields['qty'] = $mobyt_qty[$this->quality];
		
		if ($this->auth == MOBYT_AUTH_MD5)
		{
			$fields['password'] = '';
			$fields['ticket'] = md5($this->login.$operation.$rcpt.$this->from.$text.$this->pwd);
		}
		else
		{
			$fields['password'] = $this->pwd;
			$fields['ticket'] = '';
		}
		
		if ($this->operation == MOBYT_OPERATION_8BIT)
			$fields['udh'] = $this->udh;
		
		return trim($this->httpPost($fields));
	}
	
	/**
	 * Invia un SMS a piu' destinatari
	 *
	 * Nel caso sia utilizzata la qualita' automatica con notifica, sera' necessario passare un array associativo come primo parametro, le cui chiavi siano identificatori univoci di max 20 caratteri numerici.
	 *
	 * @example sms-multi.php Invio di un sms a piu' numeri in media qualita' con autenticazione tramite password in chiaro
	 *
	 * @param array Array di numeri telefonici con prefisso internazionale (es. +393201234567)
	 * @param string Testo del messaggio (max 160 caratteri)
	 *
	 * @returns string Elenco di risposte ricevute dal gateway ("OK ..." o "KO ..."), separate da caratteri di "a capo" (\n)
	 */
	function sendMultiSms($rcpts, $text)
	{
		global $mobyt_qty, $mobyt_ops;
		
		if (!is_array($rcpts))
			return $this->sendSms($rcpts, $text);
		
		
		$operation = isset($mobyt_ops[$this->operation]) ? $mobyt_ops[$this->operation] : 'TEXT';
		
		$fields = array(
				'id'		=> $this->login,
				'password'	=> $this->auth == MOBYT_AUTH_MD5 ? '' : $this->pwd,
				'operation' => $operation,
				'from'		=> $this->from,
				'data'		=> $text
			);
		
		if ($this->quality != MOBYT_QUALITY_DEFAULT && isset($mobyt_qty[$this->quality]))
			$fields['qty'] = $mobyt_qty[$this->quality];
		
		if ($this->operation == MOBYT_OPERATION_8BIT)
			$fileds['udh'] = $this->udh;
		
		$ret = array();
		foreach ($rcpts as $act => $rcpt)
		{
			$fields['rcpt']  = $rcpt;
			$fields['ticket'] = $this->auth == MOBYT_AUTH_MD5 ?
				md5($this->login.$operation.$rcpt.$this->from.$text.$this->pwd) :
				'';
				
			if ($this->quality == MOBYT_QUALITY_AUTO_NY)
				$fields['act'] = $act;

			$ret[] = trim($this->httpPost($fields));
		}
		
		return join("\n", $ret);
	}

	/**
	 * Send an HTTP POST request, choosing either cURL or fsockopen
	 *
	 * @access private
	 */
	function httpPost($fields, $url = '/sms-gw/sendsmart')
	{
		$qs = array();
		foreach ($fields as $k => $v)
			$qs[] = $k.'='.urlencode($v);
		$qs = join('&', $qs);
		
		if (function_exists('curl_init'))
			return mobytSms::httpPostCurl($qs, $url);
		
		$errno = $errstr = '';
		if ($fp = @fsockopen('smsweb.mobyt.it', 80, $errno, $errstr, 30)) 
		{
			fputs($fp, "POST ".$url." HTTP/1.0\r\n");
			fputs($fp, "Host: smsweb.mobyt.it\r\n");
			fputs($fp, "User-Agent: phpMobytSms/".MOBYT_PHPSMS_VERSION."\r\n");
			fputs($fp, "Content-Type: application/x-www-form-urlencoded\r\n");
			fputs($fp, "Content-Length: ".strlen($qs)."\r\n");
			fputs($fp, "Connection: close\r\n");
			fputs($fp, "\r\n".$qs);
			
			$content = '';
			while (!feof($fp))
				$content .= fgets($fp, 1024);
			
			fclose($fp);
			
			return preg_replace("/^.*?\r\n\r\n/s", '', $content);
		}
		
		return false;
	}

	/**
	 * Send an HTTP POST request, through cURL
	 *
	 * @access private
	 */
	function httpPostCurl($qs, $url)
	{
		if ($ch = @curl_init('http://smsweb.mobyt.it'.$url))
		{
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_USERAGENT, 'phpMobytSms/'.MOBYT_PHPSMS_VERSION.' (curl)');
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $qs);
			
			return curl_exec($ch);
		}
		
		return false;
	}
	
	/**
	 * Converti stringa in formato esadecimale OTA, per invio RING, 8BIT, ecc...
	 *
	 * @param string Stringa da convertire
	 *
	 * @return string
	 */
	function stringToOTA($str)
	{
		$ret = '';
		
		$len = strlen($str);
		for ($x = 0; $x < $len; $x++)
			$ret .= sprintf('%X', ord($str{$x}));
		
		return $ret;
	}
}



/**
 * Classe per l'invio di SMS multipli tramite il servizio SMS-Batch
 *
 * Il servizio richiede una directory scrivibile dall'utente con cui gira l'interprete PHP e le funzioni FTP abilitate
 *
 * Le impostazioni utilizzate di default sono:
 * - Mittente: <b>"MobytSms"</b>
 * - Qualita': <b>Automatica</b>
 * - Directory temporanea: <b>la directory impostata come <i>upload_tmp_dir</i> in php.ini</b>
 *
 * <b>N.B.</b> Il servizio supporta solo messaggi di testo e non supporta la notifica
 *
 * @package Mobyt-SmsWeb
 * @example smsftp-multi.php Invio di messaggi multipli via SMS-Batch
 */
class mobytSmsFtp extends mobytSms
{
	/**#@+
	 * @access	private
	 * @var		boolean
	 */
	var $has_ftp;
	var $use_pasv = false;

	/**
	 * @var		string
	 */
	var $cache_dir;
	/**#@-*/
	
	/**
	 * @param string	Username di accesso (Login)
	 * @param string	Password dispositiva
	 * @param string	Intestazione mittente
	 *
	 * @see setFrom
	 */
	function mobytSmsFtp($login, $pwd, $from = 'MobytSms')
	{
		$this->login = $login;
		$this->pwd = $pwd;
		$this->setFrom($from);
		
		if (!function_exists('ftp_connect'))
			die("Estensione FTP non disponibile");
		
		$this->cache_dir = ini_get('upload_tmp_dir');
	}

	/**
	 * Imposta la directory per i file temporanei
	 *
	 * @param string	Directory temporanea
	 */
	function setTmpDir($dir)
	{
		$this->cache_dir = preg_replace('/[/\\\\]$/', '', $dir);
	}

	/**
	 * Utilizza la modalita' passiva per il trasferimento
	 *
	 * @param boolean	Abilita modalita' passiva
	 */
	function usePassive($pasv = true)
	{
		$this->use_pasv = $pasv;
	}

	/**#@+
	 * Disabilita alcune funzioni
	 *
	 * @access private
	 */
	
	function batchOperationError()
	{
		trigger_error("E' possibile inviare solo messaggi di testo in modalita' batch", E_USER_WARNING);
	}
	function setOperationRing()
	{
		batchOperationError();
	}
	function setOperationOlgo()
	{
		batchOperationError();
	}
	function setOperationGlgo()
	{
		batchOperationError();
	}
	function setOperation8Bit()
	{
		batchOperationError();
	}
	/**#@-*/


	/**
	 * Invia un SMS tramite SMS-Batch
	 *
	 * @param string Numero telefonico con prefisso internazionale (es. +393201234567)
	 * @param string Testo del messaggio (max 160 caratteri)
	 * @param string Identificativo dell' SMS spedito (da valorizzare solo in caso di spedizione con notifica)
	 *
	 * @returns boolean True se il messaggio a' stato accodato con successo
	 */
	function sendSms($rcpt, $text, $act='')
	{
		return $this->sendMultiSms($rcpt, $text, $act);
	}
	
	/**
	 * Invia un SMS a piu' destinatari tramite SMS-Batch
	 *
	 * @example smsftp-multi.php Invio di un sms a piu' numeri tramite SMS-Batch
	 *
	 * @param array Array di numeri telefonici con prefisso internazionale (es. +393201234567)
	 * @param string Testo del messaggio (max 160 caratteri)
	 * @param array Array di identificativi dei singoli SMS spediti (da valorizzare solo in caso di spedizione con notifica)
	 *
	 * @returns integer Numero di messaggi accodati
	 */
	function sendMultiSms($rcpts, $text, $act='')
	{
		global $mobyt_qty, $mobyt_ops;
		$notify = true;
		
		if (!is_array($act))
		{	
			if($act == '')
				$notify = false;
			$act = array($act);
			
		}
		
			
		foreach ($act as $x => $v)
		{
			$v = trim($act[$x]);
			$act[$x] = $v;
		}
		
		if (!is_array($rcpts))
			$rcpts = array($rcpts);
		

		foreach ($rcpts as $x => $v)
		{
			$v = trim($rcpts[$x]);
		
			if (preg_match('/^\+\d+$/', $v))
				$rcpts[$x] = $v;
			else
			{
				unset($rcpts[$x]);
				unset($act[$x]);
			}
		}
		
		$rcpts = array_values($rcpts);
		$act = array_values($act);

		if (!count($rcpts))
			die("Nessun numero valido fornito");
			
		
		
		if (!is_writable($this->cache_dir) || !($fname = tempnam($this->cache_dir, 'phpSmsFtp-')))
			die("Impossibile creare il file temporaneo");		
		
		$from		= substr(preg_replace('/[\t\n\r]+/', ' ', $this->from), 0, 11);
		$data		= substr(preg_replace('/[\t\n\r]+/', ' ', $text), 0, 160);
		$expire		= 72;
		
		if ($this->quality != MOBYT_QUALITY_DEFAULT && isset($mobyt_qty[$this->quality]))
			$qty = $mobyt_qty[$this->quality];
		else
			$qty = '';
			
		$fp = @fopen($fname, 'w');
		foreach($rcpts as $k => $rcpt){
			printf("%-25s%-25s%-160s%010d%-2s%-20s\n", $rcpt, $from, $data, $expire, $qty, $act[$k]);
			@fputs($fp, sprintf("%-25s%-25s%-160s%010d%-2s%-20s\n", $rcpt, $from, $data, $expire, $qty, $act[$k]));
		}
		@fclose($fp);
		
		$ok = false;
		if ($ftp = ftp_connect('smsftp.mobyt.it'))
		{
			if (ftp_login($ftp, $this->login, $this->pwd))
			{
				ftp_pasv($ftp, $this->use_pasv);
				
				if (ftp_chdir($ftp, 'incoming'))
				{
					if (ftp_put($ftp, basename($fname).'.txt', $fname, FTP_ASCII))
					{
						$fp = @fopen($fname, 'w');
						if($notify)
							@fputs($fp, "ACTION=INFO\nGET_NOTIFY=on\nWHERE=HTTP\n");
						else
							@fputs($fp, ".");
						@fclose($fp);
						
						if (ftp_put($ftp, basename($fname).'.txt.do_send', $fname, FTP_ASCII))
						{
							$ok = true;
						}
					}
				}
			}
			else
			{
				@unlink($fname);
				die("Login/password errati o servizio non abilitato");
			}
			
			ftp_close($ftp);
		}
		
		@unlink($fname);
		
		if (!$ok)
			die("Si a' verificato un errore durante l'upload dei file");
		
		return count($rcpts);
	}
}



/**
 * Classe per l'invio di SMS WAP/Push tramite il servizio SMS-Web
 *
 * Le impostazioni utilizzate di default sono:
 * - Mittente: <b>"MobytSms"</b>
 * - Autenticazione: <b>MD5</b>
 * - Qualita': <b>Alta</b>
 *
 * @package Mobyt-SmsWeb
 * @example wappush-single.php Invio di un singolo sms Wap/Push con autenticazione MD5
 */
class mobytWapPush extends mobytSms
{
	/**
	 * Invia un SMS WAP/Push
	 *
	 * @param string Numero telefonico con prefisso internazionale (es. +393201234567)
	 * @param string Testo del messaggio
	 * @param string Collegamento ipertestuale 
	 *
	 * @returns string Risposta ricevuta dal gateway ("OK ..." o "KO ...")
	 *
	 * @example wappush-single.php Invio di un singolo sms Wap/Push con autenticazione MD5
	 */
	function sendSms($rcpt, $title, $url)
	{
		$this->setQualityHigh();
		$this->setOperation8Bit('05040B8423F0');
		
		$data = 'DC0601AE02056A0045C6';
		
		if (preg_match('#^http(s?)://(www\.)?#', $url, $m))
		{
			$ssl = isset($m[1]) && $m[1];
			$www = isset($m[2]) && $m[2];
			
			if ($ssl)
				$data .= $www ? '0F' : '0E';
			else
				$data .= $www ? '0D' : '0C';
			
			$url = str_replace($m[0], '', $url);
		}
		
		$data .= MobytWapPush::str2wbxml($url);
		$data .= '01';
		$data .= MobytWapPush::str2wbxml($title);
		$data .= '0101';
		
		return parent::sendSms($rcpt, $data);
	}

	/**
	 * Invia un SMS WAP/Push a piu' destinatari
	 *
	 * @param array Array di numeri telefonici con prefisso internazionale (es. +393201234567)
	 * @param string Testo del messaggio
	 * @param string Collegamento ipertestuale
	 *
	 * @returns string Elenco di risposte ricevute dal gateway ("OK ..." o "KO ..."), separate da caratteri di "a capo" (\n)
	 */
	function sendMultiSms($rcpts, $title, $url)
	{
		if (!is_array($rcpts))
			return $this->sendSms($rcpts, $text);
		
		$ret = array();
		foreach($rcpts as $rcpt)
			$ret[] = $this->sendSms($rcpt, $title, $url);
		
		return join("\n", $ret);
	}
	
	/**
	 * Converti stringa in formato wbxml
	 *
	 * @access	private
	 */
	function str2wbxml($str)
	{
		return '03'.mobytSms::stringToOTA($str).'00';
	}
}




/**
 * Classe per l'invio di suonerie in formato RTTTL tramite il servizio SMS-Web
 *
 * Le impostazioni utilizzate di default sono:
 * - Mittente: <b>"MobytSms"</b>
 * - Autenticazione: <b>MD5</b>
 * - Qualita': <b>Alta</b>
 *
 * @package Mobyt-SmsWeb
 * @example rtttl-single.php Invio di una suoneria RTTTL con autenticazione MD5
 */
class mobytRTTTL extends mobytSms
{
	/**#@+
	 * @access	private
	 * @var		string
	 */
	var $data = '';
	/**#@-*/
	
	/**
	 * Invia una suoneria in formato RTTTL
	 *
	 * @param string Numero telefonico con prefisso internazionale (es. +393201234567)
	 * @param string Suoneria in formato RTTTL
	 *
	 * @returns string Risposta ricevuta dal gateway ("OK ..." o "KO ...")
	 *
	 * @example rtttl-single.php Invio di una suoneria RTTTL con autenticazione MD5
	 */
	function sendSms($rcpt, $rttl)
	{
		$this->setQualityHigh();
		$this->setOperationRing();
		
		if ($rttl)
			$this->setRtttl($rttl);
		
		return parent::sendSms($rcpt, $this->data);
	}

	/**
	 * Invia una suoneria in formato RTTTL a piu' destinatari
	 *
	 * @param array Array di numeri telefonici con prefisso internazionale (es. +393201234567)
	 * @param string Suoneria in formato RTTTL
	 *
	 * @returns string Elenco di risposte ricevute dal gateway ("OK ..." o "KO ..."), separate da caratteri di "a capo" (\n)
	 */
	function sendMultiSms($rcpts, $rtttl)
	{
		if (!is_array($rcpts))
			return $this->sendSms($rcpts, $text);
		
		$this->setRtttl($rttl);
		
		$ret = array();
		foreach($rcpts as $rcpt)
			$ret[] = $this->sendSms($rcpt, '');
		
		return join("\n", $ret);
	}
	
	/**
	 * Imposta dati OTA da RTTTL
	 *
	 * @access	private
	 */
	function setRtttl($rtttl)
	{
		$this->data = $this->httpPost(array('rtttl' => $rtttl), '/sms-gw/getota');
	}
}

/**
 * Classe per l'utilizzo del servizio MNC (Mobyt Number Check)
 *
 * Le impostazioni utilizzate di default sono:
 * - Autenticazione: <b>MD5</b>
 *
 * @package Mobyt-SmsWeb
 * @example mnc-query.php Richiesta di un controllo
 */
class mobytMnc
{
	/**#@+
	 * @access	private
	 * @var		string
	 */
	var $login;
	var $pwd;
	var	$auth = MOBYT_AUTH_MD5;
	/**#@-*/

	/**
	 * @param string	Username di accesso (Login)
	 * @param string	Password dispositiva
	 */
	function mobytMnc($login, $pwd)
	{
		$this->login = $login;
		$this->pwd = $pwd;
	}
	
	
	/**
	 * Utilizza l'autenticazione di tipo MD5
	 */
	function setAuthMd5()
	{
		$this->auth = MOBYT_AUTH_MD5;
	}
	
	/**
	 * Utilizza l'autenticazione con password in chiaro basata sull'IP
	 */
	function setAuthPlain()
	{
		$this->auth = MOBYT_AUTH_PLAIN;
	}


	/**
	 * Richiedi controllo asincrono per uno o piu' numeri
	 *
	 * @param array		Numeri per il quale richiedere il controllo
	 * @param string	URL al quale ricevere la risposta
	 * @param string	Identificativo query
	 *
	 * @returns string	Risposta ricevuta dal gateway
	 */
	function queryBatch($numbers, $url, $queryid = '1')
	{
		$numbers = join(',', $numbers);

		$fields = array(
				'id'		=> $this->login,
				'password'	=> $this->auth == MOBYT_AUTH_MD5 ? '' : $this->pwd,
				'numbers'	=> $numbers,
				'url'		=> $url,
				'queryid'	=> $queryid
			);
		
		if ($this->auth == MOBYT_AUTH_MD5)
			$fields['ticket'] = md5($this->login.$numbers.$url.$queryid.$this->pwd);
		else
			$fields['ticket'] = '';

		$ret = MobytSms::httpPost($fields, '/sms-gw/mncbatch');

		return trim($ret);
	}
}


/**
 * Classe per l'invio di MMS
 *
 * L'invio di MMS richede l'utilizzo della classe NuSOAP, distribuita sotto licenza GNU Lesser
 * Public License (LGPL). Il file lib-nusoap.inc.php deve essere copiato nella stessa
 * directory di lib-mobytsms.inc.php per il corretto funzionamento del servizio.
 * SOLO PER PHP 4
 *
 * Le impostazioni utilizzate di default sono:
 * - Autenticazione: <b>MD5</b>
 *
 * @package Mobyt-SmsWeb
 * @example mms-single.php Invio di un MMS con immagine
 * @example mms-multi.php Invio multiplo di MMS con immagine e audio
 * @example mms-recv.php Ricezione MMS
 */
class mobytMms
{
	/**
	 * @param string	Eventuale messaggio di errore
	 */
	var $errorMessage = '';

	/**#@+
	 * @access	private
	 * @var		string
	 */
	var $login;
	var $pwd;
	var	$auth = MOBYT_AUTH_MD5;
	/**#@-*/


	/**
	 * @param string	Username di accesso (Login)
	 * @param string	Password dispositiva
	 */
	function mobytMms($login, $pwd)
	{
		$this->login = $login;
		$this->pwd = $pwd;
	}	
	
	/**
	 * Utilizza l'autenticazione di tipo MD5
	 */
	function setAuthMd5()
	{
		$this->auth = MOBYT_AUTH_MD5;
	}
	
	/**
	 * Utilizza l'autenticazione con password in chiaro basata sull'IP
	 */
	function setAuthPlain()
	{
		$this->auth = MOBYT_AUTH_PLAIN;
	}

	/**
	 * Ricevi singolo MMS
	 *
	 *
	 * @param string       mmsid (Id del messaggio precedentemente ricevuto dal gagteway
	 * MMS durante la fase di alert (fase 1)
	 * vedere la documentazione relativa al servizio di ricezione MMS) (opzionale)
	 *
	 * @returns array      contiene la struttura dell'MMS.
	 *
	 * Esempio di struttura ritornata (MMS inviato da un nokia N70) :
	 * 
	 *
	 * Array
	 *  (
	 *	[phone] => +392222222
	 *	[subject] => prova mms
	 *	[timestamp] => 2007-09-12 11:13:24
	 *	[attachments] => Array
	 *				   (
	 *		   [0] => Array
	 *					 (
	 *			 [type] => image/jpeg
	 *			 [filename] => 10082007.jpg
	 *			 [content] = 	  
	 *              /9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAMCAgMCAgMDAwMEAwMEBQgFBQQEBQoH....
	 *
	 *					 )
	 *
	 *		   [1] => Array
	 *				 (
	 *			 [type] => application/smil
	 *			 [filename] => <1785700435>
	 *			 [content] =>  <smil><head><layout><root-layout width="176" 
	 *				height="208"/><region id="Image" width="160" height="120" top="68" 
	 *				left="8" fit="meet"/><region id="Text" width="160" height="58" 
	 *				top="5" left="8" fit="scroll"/></layout></head><body><par 
	 *				dur="5000ms"><img region="Image" src="10082007.jpg"/><text 
	 *				region="Text" src="001prova.txt"/></par></body></smil>
	 *
	 *				 )
	 *
	 *		   [2] => Array
	 *				  (
	 *			  [type] => text/plain
	 *			  [filename] => 001prova.txt
	 *			  [content] => 001prova invio mms
	 *
	 *			  )
	 *
	 *		   )
	 *
	 *  )
	 *
 	 *  
	 *
	 */
	
     function recvMms($mmsid = "")
	 {
		if ($this->checkVersion()==4){
			require_once('lib-nusoap.inc.php');		  
		  	$client = new soapclient('http://mmsgw.mobyt.it/mms-soap/?wsdl', true);
			$err = $client->getError();
			if ($err)
				trigger_error('Errore nella creazione del client SOAP: '.$err, E_USER_ERROR);
			$res = $client->call('recvMms', array(
							$this->login,
							$this->pwd,
							));
		  
			if ($client->fault) {
				return join(' ', $res);
			}else if ($err) {
				trigger_error('Errore la call di recvMms: '.$err, E_USER_ERROR);
			}else {
				return $res;
			}
		}else {
		 
			$client = new SoapClient('http://mmsgw.mobyt.it/mms-soap/?wsdl',array('login'=>$this->login,'password'=>$this->pwd));
			$res = $client->recvMms($this->login,$this->pwd );
			
			if (!$res){
				trigger_error('Errore durante la call di recvMms: '.$e->__toString(), E_USER_ERROR); 
				return false;
				}
 
			if (is_soap_fault($res)) {
   				 trigger_error("Errore SOAP: (faultcode: {$res->faultcode}, faultstring: {$res->faultstring})", E_USER_ERROR);
			}else{
				return $res;
			}
		}
	  
	  }
		


	

	/**
	 * Invia singolo MMS
	 *
	 * @param string	Oggetto dell'MMS
	 * @param string	Testo dell'MMS
	 * @param mixed		Numero telefonico con prefisso internazionale (es. +393201234567), o array di numeri telefonici in caso di invio multiplo
	 * @param string	Percorso del file immagine (opzionale)
	 * @param string	Percorso del file audio (opzionale)
	 * @param string	Percorso del file video (opzionale)
	 *
	 * @returns string Risposta ricevuta dal gateway ("OK ..." o "KO ...")
	 */
	function sendMms($subject, $text, $rcpt, $image = '', $sound = '', $video = '', $act = '', $url ='')
	{
		if ($this->checkVersion()==4) require_once('lib-nusoap.inc.php');
		
		if (is_array($rcpt))
				$rcpt = join(',', $rcpt);

		$params = array(
				'id'		=> $this->login,
				'password'	=> $this->auth == MOBYT_AUTH_MD5 ? '' : $this->pwd,
				'ticket'	=> $this->auth == MOBYT_AUTH_MD5 ? md5($this->login.$rcpt.$subject.$text.$this->pwd) : '',
				'subject'	=> $subject,
				'text'		=> $text,
				'rcpt'		=> $rcpt,
				'act'		=> $act,
				'url'		=> $url
			);

		if ($image)
		{

			

			$imagedata = file_get_contents($image) or trigger_error('Immagine non trovata', E_USER_ERROR);
			$params['imagefile'] = '@'.$image;
			$params['imagetype'] = $this->imageType($imagedata);
			
			
		}

		if ($sound)
		{

			
			$sounddata = file_get_contents($sound) or trigger_error('File audio non trovato', E_USER_ERROR);
			$params['soundfile'] = '@'.$sound; 
			$params['soundtype'] = $this->soundType($sounddata);
		}
		
		if ($video)
		{

			
			$videodata = file_get_contents($video) or trigger_error('File video non trovato', E_USER_ERROR);
			$params['videofile'] = '@'.$video;
			$params['videotype'] = $this->videoType($videodata);  
		}
	
	//Stampa i parametri contenuti nell'MMS
	echo '<pre>';
	var_dump($params);
	echo '</pre>';
	
			
        $ch = curl_init('http://smsweb.mobyt.it/sms-gw/mm7');
		curl_setopt($ch, CURLOPT_VERBOSE,true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		
		$res = curl_exec($ch);
	
        return $res;
		
	}

	function checkVersion(){
		$version = explode('.', PHP_VERSION);
		return $version[0];
	}

	
	function imageType ($imagedata)
	{
		if (preg_match('/^GIF8[79]a/', $imagedata))
			return 'gif';

		if (preg_match('/^\xFF\xD8/', $imagedata))
			return 'jpeg';

		if (preg_match('/^\x89PNG/', $imagedata))
			return 'png';

		if (preg_match('/\xFF\xD8\xFF\xE0\x00\x10JFIF\x00/', $imagedata))
			return 'jpeg';
			
		return false;
	}
	
	function soundType ($sounddata)
	{
		if (substr($sounddata, 0, 4) == 'MThd')
			return 'midi';
		
		// Strip ID3 tag, if present
		if (preg_match('/^ID3([^\xFF])\x00(.)(....)/s', $sounddata, $m))
		{
			list(, $version, $flags, $size) = $m;
			
			$version = ord($version);
			
			$unsynchronisation		= $flags & (1 << 7);
			$extended_header		= $flags & (1 << 6);
			$experimental_indicator	= $flags & (1 << 5);
			$footer_present			= $flags & (1 << 4);
			
			$size =	str_pad(decbin(ord($size{0}) & 0x7F), 7, '0', STR_PAD_LEFT).
					str_pad(decbin(ord($size{1}) & 0x7F), 7, '0', STR_PAD_LEFT).
					str_pad(decbin(ord($size{2}) & 0x7F), 7, '0', STR_PAD_LEFT).
					str_pad(decbin(ord($size{3}) & 0x7F), 7, '0', STR_PAD_LEFT);
			
			$size = bindec($size);
			
			$sounddata = substr($sounddata, $size + ($footer_present ? 20 : 10));
		}
	
		if (preg_match('/^\xFF[\xE0-\xFF]../s', $sounddata))
			return 'mp3';
		
		return false;
	}
	
	function videoType ($videodata)
	{
		 if (preg_match('/^\x00\x00\x00/', $videodata))
			return '3gp';
			
		return false;
	}


}

?>