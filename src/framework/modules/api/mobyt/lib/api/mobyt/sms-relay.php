<?php
/**
 * File di esempio per il relay tramite PHP
 *
 * Accetta i seguenti parametri POST/GET:
 * - <b>prefisso</b>: prefisso del destinatario nel formato 3xx
 * - <b>numero</b>: numero telefonico del destinatario
 * - <b>data</b>: testo del messaggio (max 160 char)
 *
 * Lo script utilizza l'autenticazione MD5 e la qualità automatica.
 *
 * <b>N.B.</b><br>
 * Affinché lo script funzioni correttamente, impostare le {@link $from variabili di configurazione}.
 *
 * @package Mobyt-SmsWeb
 * @author  Matteo Beccati - matteo.beccati@mobyt.it
 * @copyright (C) 2003-2005 Mobyt srl
 * @filesource
 * @license https://www.mobyt.it/bsd-license.html BSD License
 * @version 1.3.1
 */


//******************************************************************
//* INIZIO CONFIGURAZIONE                                          *
//******************************************************************

	/**
	 * Username di accesso (Login) 
	 * @global string $login
	 */
	$login = 'C00000_001';
	
	/**
	 * Password dispositiva
	 * @global string $password
	 */
	$password = 'password';
	
	/**
	 * Intestazione mittente (max 11 caratteri alfanumerici) 
	 * @global string $from
	 */
	$from = 'mobytSms';
	
	/**
	 * Utilizza redirezione anziché stampare la risposta del gateway
	 * @global boolean $redirect
	 * @see $sms_ok
	 * @see $sms_ko
	 */
	$redirect = false;
	
	/**
	 * URL di destinazione se l'invio è andato a buon fine
	 * @global string $sms_ok
	 * @see $redirect
	 */
	$sms_ok = 'http://www.sito.tld/ok.php';
	
	/**
	 * URL di destinazione se l'invio <b>non</b> è andato a buon fine
	 * @global string $sms_ko
	 * @see $redirect
	 */
	$sms_ko = 'http://www.sito.tld/ko.php';

//******************************************************************
//* FINE CONFIGURAZIONE                                            *
//******************************************************************




/**
 * Inclusione definizione classe mobytSms
 */
require('lib-mobytsms.inc.php');


// Preleva variabili GET/POST in maniera compatibile con PHP4 e PHP5
if (!function_exists('version_compare'))
	$request = array('HTTP_', '_VARS');
else
	$request = array('_', '');

$request = $request[0].$HTTP_SERVER_VARS['REQUEST_METHOD'].$request[1];

if (!isset($$request))
	die('Errore imprevisto');

$request =& $$request;

$prefisso	= isset($request['prefisso']) ? $request['prefisso'] : '';
$numero		= isset($request['numero']) ? $request['numero'] : '';
$data		= isset($request['data']) ? $request['data'] : '';

// Controllo dati in input
if (!preg_match('/^3\d\d+$/', $prefisso))
	die('Prefisso non valido');
if (!preg_match('/^\d+$/', $numero))
	die('Numero non valido');
if (strlen($data) > 160)
	die('Testo troppo lungo');

// Creazione numero con prefisso internazionale
$rcpt = '+39'.$prefisso.$numero;

// Creazione oggetto e impostazione mittente
$sms = new mobytSms($login, $password);
$sms->setFrom($from);

// Utilizza qualità automatica
$sms->setQualityAuto();

// Utilizza autenticazione MD5
$sms->setAuthMd5();

// Invio SMS
$result = $sms->sendSms($rcpt, $data);


if ($redirect)
{
	// Redirezione
	header('Location: '.(substr($result, 0, 2) == 'OK' ? $sms_ok : $sms_ko));
	exit;
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>sms-relay.php</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<b>Risposta ricevuta dal gateway SMS:</b> <?php echo $result; ?>
<body>
</body>
</html>