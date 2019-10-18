<?php

	$archivo = $_POST ["excel"];
    $archivo = fopen($archivo,'r');
	$numlinea = 0;
	$cad = '"'.$_POST ["smsMessage"].'"';
	$num = '"'.$_POST ["phoneNumber"].'"';
	
	
	while ($linea = fgets($archivo)) 
	{
		
		$aux[] = $linea;
		$numlinea++;
	}
	
	//$texto = substr($cad,0,120);
	//$var = filter_var($texto, FILTER_SANITIZE_URL, FILTER_NULL_ON_FAILURE);

/*
 * Usage: pass parameters through line command like example below
 * example:
 *    php send.php 0121212123 "Hello World!"
 * @parameters receiver message
 * @author Iivo Raitahila
 * @author Eduardo Fontinelle
 * This project was perfectly written by Iivo Raitahila and forked and adapted to my use. Enjoy!
 */

$debug = true;
error_reporting(E_ALL);
if ($debug) {
    ini_set('display_errors', 1);
} else {
    ini_set('display_errors', 0);
}

/* Allow the script to hang around waiting for connections. */
set_time_limit(0);
 /* Turn on implicit output flushing so we see what we're getting
 * as it comes in. */
ob_implicit_flush();

require_once dirname(__FILE__).'/models/message.php';
require_once dirname(__FILE__).'/classes/goip.php';
//$settings = require dirname(__FILE__).'/settings.php';

$settings = array('goipAddress' => '192.168.0.102', //The IP address of the GOIP
                  'goipPort' => '10991', //The port that GOIP listens to (maybe 9991, find out using keepalive.php 
                  'goipPassword' => 'admin' //The password set in GOIP management
				  );


$goip = new FSG\Goip($settings['goipAddress'], $settings['goipPort'], $settings['goipPassword']);

//foreach($aux as $comando)
//{
	//$argv = array("", $comando, $_POST ["smsMessage"]);
	
//}

	$mensaje = array (
                  array("", $aux[0], $cad),
				  array("", $aux[1], $cad),
				  array("", $aux[2], $cad)
                 );
				 
				 echo gettype($mensaje);
				 echo strlen($mensaje);
				 
	//for($i=0; $i<count($aux); $i++)
	//{
	 //$mensaje = array("", $aux[$i], $cad);	
		
	//}

foreach($mensaje as $men)
{
	$argv = $men;
	//print_r($argv);
	//die();
	 echo gettype($argv);
				 echo strlen($argv);

//$argv = array("","","");/*array para tomar numero y mensaje*/

if (count($argv) != 3) {
    exit("
...................................................................
* * Wrong use * *
  Example how to use this script:

$ php send.php <phone number> <message>

................................................................... \n");
}



$message = new FSG\MessageVO(rand(1000, 9999), $argv[1], $argv[2]);


$result = $goip->sendSMS($message);

if($result === true) {
    //echo =  "Mensaje enviado";
	//include 'aviso.html';
	$mens[][aviso]="enviado";
} else {
    //echo = $result;
	//include 'nosms.html';
	$mens[][aviso]="no enviado";
}
   
}
	

$goip->close();

	print_r($mens);
