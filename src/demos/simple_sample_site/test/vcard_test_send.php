<?

require_once("../framework/core/lib/api/mobyt/lib-mobytsms.inc.php");

$sms = new mobytSms('C14395_002', '02zpeoem');
$sms->setFrom('+393493510861');

$my_message = "//SCKE2 BEGIN:VCARD\r\nVERSION:2.1\r\nN:Magic Source;;;;\r\nEMAIL;INTERNET:magic_opensource@hotmail.com\r\nTEL;PREF;CELL;VOICE:0192292309\r\nEND:VCARD";
$result = $sms->sendSms('+393381988081', $my_message);

if (substr($result, 0, 2) == 'OK')
	echo 'Il messaggio è stato inviato correttamente<br>';
else
	echo 'Il messaggio NON è stato inviato correttamente<br>';

?>