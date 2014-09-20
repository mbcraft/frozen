<?php

class Dfdt
{
    private $LoginEmail;
    private $LoginPassword;

    function __construct($loginEmail, $loginPassword)
    {
        $this->LoginEmail = $loginEmail;
        $this->LoginPassword = $loginPassword;
    }

    /*
    //dati del dominio
    $DomainName= 'nomedominio.it'; //Nome del dominio, NON deve contenere www davanti
    $RecordType="A"; //Tipo di record, può contenere i valori A , AAAA , CNAME , MX
    $RecordName="XXX"; //Nome del record, deve essere abbreviato (es. www - @)
    $RecordValue="XXXXXXXXXXX"; //Valore del record
                                //per i record A è un indirizzo IP v4
                                //per i record AAAA è un indirizzo IP v6
                                //per i record cname è un fqdn
                                //per i record mx e priorità fqdn esempio "10 pippo.it."
     */
    function dns_create($DomainName, $RecordType, $RecordName, $RecordValue)
    {
        //parametri dell'ordine
        $params = array(
            'LoginEmail' => $this->LoginEmail,
            'LoginPassword' => $this->LoginPassword,
            'DomainName' => $DomainName,
            'RecordType' => $RecordType,
            'RecordName' => $RecordName,
            'RecordValue' => $RecordValue
        );

        //Connection parameters
        //do not modify  -   non modificare
        $proxyhost = '';
        $proxyport = '';
        $proxyusername = '';
        $proxypassword = '';
        $useCURL = '0';
        $client = new nusoap_client("http://api.dominiofaidate.com/xml/Dns.asmx?WSDL", true);
        $client->soap_defencoding = 'UTF-8';
        $err = $client->getError();
        if ($err) {
            echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
            echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->getDebug(), ENT_QUOTES) . '</pre>';
            exit();
        }
        $client->setUseCurl($useCURL);
        $client->useHTTPPersistentConnection();

        $result = $client->call('Create', $params);

        if ($client->fault) {
            echo '<h2>Fault</h2><pre>';
            print_r($result);
            echo '</pre>';
        }
        else
        {
            $err = $client->getError();
            if ($err) {
                echo '<h2>Error</h2><pre>' . $err . '</pre>';
            }
        }

        return $result;
    }

    /*
   *         //dati del dominio
$DomainName= 'nomedominio.it'; //Nome del dominio, NON deve contenere www davanti
$RecordType="A"; //Tipo di record, può contenere i valori A , AAAA , CNAME , MX
$RecordName="XXX"; //Nome del record, deve essere abbreviato (es. www - @)
$RecordValue="XXXXXXXXXXX"; //Valore del record
                       //per i record A è un indirizzo IP v4
                       //per i record AAAA è un indirizzo IP v6
                       //per i record cname è un fqdn
                       //per i record mx e priorità fqdn esempio "10 pippo.it."
   * */
    function dns_delete($DomainName, $RecordType, $RecordName, $RecordValue)
    {
        //parametri dell'ordine
        $params = array(
            'LoginEmail' => $this->LoginEmail,
            'LoginPassword' => $this->LoginPassword,
            'DomainName' => $DomainName,
            'RecordType' => $RecordType,
            'RecordName' => $RecordName,
            'RecordValue' => $RecordValue
        );

        //Connection parameters
        //do not modify  -   non modificare
        $proxyhost = '';
        $proxyport = '';
        $proxyusername = '';
        $proxypassword = '';
        $useCURL = '0';
        $client = new nusoap_client("http://api.dominiofaidate.com/xml/Dns.asmx?WSDL", true);
        $client->soap_defencoding = 'UTF-8';
        $err = $client->getError();
        if ($err) {
            echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
            echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->getDebug(), ENT_QUOTES) . '</pre>';
            exit();
        }
        $client->setUseCurl($useCURL);
        $client->useHTTPPersistentConnection();

        $result = $client->call('Delete', $params);

        if ($client->fault) {
            echo '<h2>Fault</h2><pre>';
            print_r($result);
            echo '</pre>';
        }
        else
        {
            $err = $client->getError();
            if ($err) {
                echo '<h2>Error</h2><pre>' . $err . '</pre>';
            }
        }
        return $result;
    }

    /*
     * $DomainName="nomedominio.it"; //<-- nome del dominio senza il www davanti
     * */
    function dns_list($DomainName)
    {
        //array parametri
        $params = array(
            'LoginEmail' => $this->LoginEmail,
            'LoginPassword' => $this->LoginPassword,
            'DomainName' => $DomainName
        );


        //Connection parameters
        //do not modify  -   non modificare
        $proxyhost = '';
        $proxyport = '';
        $proxyusername = '';
        $proxypassword = '';
        $useCURL = '0';
        $client = new nusoap_client("http://api.dominiofaidate.com/xml/Dns.asmx?WSDL", true);
        $client->soap_defencoding = 'UTF-8';
        $err = $client->getError();
        if ($err) {
            echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
            echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->getDebug(), ENT_QUOTES) . '</pre>';
            exit();
        }
        $client->setUseCurl($useCURL);
        $client->useHTTPPersistentConnection();
        $result = $client->call('List', $params);

        if ($client->fault) {
            echo '<h2>Fault</h2><pre>';
            print_r($result);
            echo '</pre>';
        }
        else
        {
            $err = $client->getError();
            if ($err) {
                echo '<h2>Error</h2><pre>' . $err . '</pre>';
            }
        }
        return $result;
    }

    function domains_list()
    {
        //array parametri
        $params = array(
            'LoginEmail' => $this->LoginEmail,
            'LoginPassword' => $this->LoginPassword
        );

        //Connection parameters
        //do not modify  -   non modificare
        $proxyhost = '';
        $proxyport = '';
        $proxyusername = '';
        $proxypassword = '';
        $useCURL = '0';
        $client = new nusoap_client("http://api.dominiofaidate.com/xml/Domain.asmx?WSDL", true);
        $client->soap_defencoding = 'UTF-8';
        $err = $client->getError();
        if ($err) {
            echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
            echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->getDebug(), ENT_QUOTES) . '</pre>';
            exit();
        }
        $client->setUseCurl($useCURL);
        $client->useHTTPPersistentConnection();
        $result = $client->call('List', $params);

        if ($client->fault) {
            echo '<h2>Fault</h2><pre>';
            print_r($result);
            echo '</pre>';
        }
        else
        {
            $err = $client->getError();
            if ($err) {
                echo '<h2>Error</h2><pre>' . $err . '</pre>';
            }
        }
        return $result;
    }

    /*
     * //dati del dominio
$DomainName= 'nomedominio.it'; //Nome del dominio, NON deve contenere www davanti
$Ns1="ns1.dns.com"; //Name server primario
$Ns2="ns2.dns.com"; //Name server secondario
$Ns3=""; //(opzionale) Eventuale terzo name server
$Ns4=""; //(opzionale) Eventuale quarto name server
     * */
    function nameserver_change($DomainName, $Ns1, $Ns2, $Ns3, $Ns4)
    {
        //parametri dell'ordine
        $params = array(
            'LoginEmail' => $this->LoginEmail,
            'LoginPassword' => $this->LoginPassword,
            'DomainName' => $DomainName,
            'Ns1' => $Ns1,
            'Ns2' => $Ns2,
            'Ns3' => $Ns3,
            'Ns4' => $Ns4
        );

        //Connection parameters
        //do not modify  -   non modificare
        $proxyhost = '';
        $proxyport = '';
        $proxyusername = '';
        $proxypassword = '';
        $useCURL = '0';
        $client = new nusoap_client("http://api.dominiofaidate.com/xml/NameServer.asmx?WSDL", true);
        $client->soap_defencoding = 'UTF-8';
        $err = $client->getError();
        if ($err) {
            echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
            echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->getDebug(), ENT_QUOTES) . '</pre>';
            exit();
        }
        $client->setUseCurl($useCURL);
        $client->useHTTPPersistentConnection();

        $result = $client->call('ChangeNameServer', $params);

        if ($client->fault) {
            echo '<h2>Fault</h2><pre>';
            print_r($result);
            echo '</pre>';
        }
        else
        {
            $err = $client->getError();
            if ($err) {
                echo '<h2>Error</h2><pre>' . $err . '</pre>';
            }
        }
        return $result;
    }

    /*
     * //dati del dominio
        $DomainName= 'nomedominio.it'; //Nome del dominio, NON deve contenere www davanti
     * */
    function nameserver_restore($DomainName)
    {
        //parametri dell'ordine
        $params = array(
            'LoginEmail' => $this->LoginEmail,
            'LoginPassword' => $this->LoginPassword,
            'DomainName' => $DomainName
        );

        //Connection parameters
        //do not modify  -   non modificare
        $proxyhost = '';
        $proxyport = '';
        $proxyusername = '';
        $proxypassword = '';
        $useCURL = '0';
        $client = new nusoap_client("http://api.dominiofaidate.com/xml/NameServer.asmx?WSDL", true);
        $client->soap_defencoding = 'UTF-8';
        $err = $client->getError();
        if ($err) {
            echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
            echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->getDebug(), ENT_QUOTES) . '</pre>';
            exit();
        }
        $client->setUseCurl($useCURL);
        $client->useHTTPPersistentConnection();

        $result = $client->call('RestoreNameServer', $params);

        if ($client->fault) {
            echo '<h2>Fault</h2><pre>';
            print_r($result);
            echo '</pre>';
        }
        else
        {
            $err = $client->getError();
            if ($err) {
                echo '<h2>Error</h2><pre>' . $err . '</pre>';
            }
        }
        return $result;
    }

    /*
   * //dati del dominio
$DomainName= 'nomedominio.it'; //Nome del dominio, NON deve contenere www davanti

  'ServiceDetails' => array(
      'Space' => $Space,
      'Email'=>$Email,
      'MySql' =>$MySql,
      'SubDomains' =>$SubDomains,
      'Linux' => $Linux
      )

$Space='1000'; //Spazio web in MB da associare al dominio, se diverso da zero deve essere un multiplo di 1000
$Email='0'; //Caselle email da associare al dominio, se diverso da zero deve essere un multiplo di 10
$MySql='0'; //Database MySql da associare al dominio
$SubDomains='0'; //Sottodomini da associare al dominio
$Linux= false; //Se Space > 0 e Linux = True allora puoi richiedere l'attivazione su server Linux In caso contrario il dominio viene attivato sul server Windows

//dati del registrante
  'ContactDetails' => array(
      'Name'=>$Name,
      'Surname'=>$Surname,
      'Email' => $cEmail,
      'Phone' => $Phone,
      'Fax' => $Fax,
      'Address' => $Address,
      'City' => $City,
      'Zip' => $Zip,
      'Country'=>$Country,
      'Province' => $Province,
      'IdentityCode' => $IdentityCode,
      'Company' => $Company,
      'VatCode' => $VatCode,
      'EntityType' => $EntityType
      )

$Name='danilo';//Nome dell'intestatario del dominio
            //Se invece il dominio va intestato ad un'azienda inserire il nome del rappresentante legale
$Surname='calzetta'; //Cognome dell'intestatario del dominio
                //Se invece il dominio va intestato ad un'azienda inserire il cognome del rappresentante legale
$cEmail= 'mario@rossi.it'; //Email di riferimento
$Phone= '+39.079201232'; //Telefono di riferimento, in formato +xx.xxxxx
$Fax= '+39.079201232'; //Fax di riferimento, in formato +xx.xxxxx. Se non si dispone di un fax lasciare il campo vuoto
$Address= 'via vai'; //Indirizzo di residenza dell'intestatario del dominio
                   //Se invece il dominio va intestato ad un'azienda inserire l'indirizzo dell'azienda
$City= 'roma'; //Città di residenza dell'intestatario del dominio
             //Se invece il dominio va intestato ad un'azienda inserire la città dove ha sede l'azienda
$Zip= '07100'; //Codice di avviamento postale (CAP) della città di residenza dell'intestatario del dominio
$Country='IT'; //[2 lettere] Codice della nazione di residenza dell'intestatario del dominio
$Province= 'rm'; //Specificare solo se il dominio ha estensione .it e Country = IT
$IdentityCode= 'clzdnl73l10i452w'; //Specificare solo se il dominio ha estensione .it
                                 //Deve contenere il fiscale dell'intestatario del dominio
                                 //Se invece il dominio va intestato ad un'azienda inserire il codice fiscale del rappresentante legale
$Company= ''; //Se il dominio va intestato a un privato lasciare questo campo vuoto
            //Se invece il dominio va intestato ad un'azienda anzichè ad un privato inserire il nome dell'azienza
$VatCode= ''; //Specificare solo se il dominio ha estensione .it e se si desidera intestare il dominio ad un'azienda
            //Inserire la partita iva dell'azienza o vuoto per i privati
$EntityType= '';//Specificare solo se il dominio ha estensione .it e se si desidera intestare il dominio ad un'azienda
              //I valori ammessi sono numeri da 2 , 3 , 4 , 5 , 6 , 7
              //2 - Società / imprese individuali
              //3 - Liberi professionisti
              //4 - Enti no-profit
              //5 - Enti pubblici
              //6 - altri soggetti
              //7 - soggetti stranieri equiparati ai precedenti escluso persone fisiche
   * */

    function order_registerdomain($DomainName, $ServiceDetails, $ContactDetails)
    {
        //parametri dell'ordine
        $params = array(
            'LoginEmail' => $this->LoginEmail,
            'LoginPassword' => $this->LoginPassword,
            'DomainName' => $DomainName,
            'ServiceDetails' => $ServiceDetails,
            'ContactDetails' => $ContactDetails
        );

        //Connection parameters
        //do not modify  -   non modificare
        $proxyhost = '';
        $proxyport = '';
        $proxyusername = '';
        $proxypassword = '';
        $useCURL = '0';
        $client = new nusoap_client("http://api.dominiofaidate.com/xml/Order.asmx?WSDL", true);
        $client->soap_defencoding = 'UTF-8';
        $err = $client->getError();
        if ($err) {
            echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
            echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->getDebug(), ENT_QUOTES) . '</pre>';
            exit();
        }
        $client->setUseCurl($useCURL);
        $client->useHTTPPersistentConnection();

        $result = $client->call('RegisterDomain', $params);

        if ($client->fault) {
            echo '<h2>Fault</h2><pre>';
            print_r($result);
            echo '</pre>';
        }
        else
        {
            $err = $client->getError();
            if ($err) {
                echo '<h2>Error</h2><pre>' . $err . '</pre>';
            }
        }
        return $result;
    }
}


?>