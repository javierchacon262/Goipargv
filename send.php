<?php
$cad = '"'.$_POST["smsMessage"].'"';
if(isset($cad) && $cad != "")
{
		require 'classes/PHPExcel.php';

	/* Allow the script to hang around waiting for connections. */
	set_time_limit(0);
 	/* Turn on implicit output flushing so we see what we're getting
 	* as it comes in. */
	ob_implicit_flush();

	require_once dirname(__FILE__).'/models/message.php';
	require_once dirname(__FILE__).'/classes/goip.php';

	//Network settings
	$settings = array('goipAddress' => '192.168.0.102', //The IP address of the GOIP
    	              'goipPort' => '10991', //The port that GOIP listens to (maybe 9991, find out using keepalive.php 
        	          'goipPassword' => 'admin' //The password set in GOIP management
					  );

	//GOIP object creation					  
	$goip = new FSG\Goip($settings['goipAddress'], $settings['goipPort'], $settings['goipPassword']);

	//die(var_dump($_FILES));
	//Get data fields from the index.html
	
	$num = '"'.$_POST["phoneNumber"].'"';

	//Send individual message if the user wrote a number in the individual phone number form field
	if(isset($num) && $num != "")
	{
		$message = new FSG\MessageVO(rand(1000, 9999), $num, $cad);
		$result = $goip->sendSMS($message);
		if($result === true) {
   			echo "Mensaje enviado";
			include 'aviso.html';
			$mens[][aviso]="enviado";
		}
		else {
   			echo $result;
			include 'nosms.html';
			$mens[][aviso]="no enviado";
		}
	}

	//Excel file reading and messages sending from the numbers in the excel file
	if (isset($_FILES['excel']) && ($_FILES['excel']['error']==0)) {
		$numbers = array();
		require_once 'Excel/reader.php';
		$tmpfname = $_FILES['excel']['tmp_name'];
		$excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);
		$excelObj = $excelReader->load($tmpfname);
		$worksheet = $excelObj->getSheet(0);
		$lastRow = $worksheet->getHighestRow();

		//Read every number into an array
		for ($row = 1; $row <= $lastRow; $row++) {
		 	array_push($numbers, $worksheet->getCell('A'.$row)->getValue());
		}
		
		//Loop the numbers' array and sending the message to every number
		foreach($numbers as $ni)
		{
			$message = new FSG\MessageVO(rand(1000, 9999), $ni, $cad);
			$result = $goip->sendSMS($message);

			if($result === true) {
    			echo "Mensaje enviado";
				include 'aviso.html';
				$mens[][aviso]="enviado";
			}
			else {
    			echo $result;
				include 'nosms.html';
				$mens[][aviso]="no enviado";
			}
		}
	}

	$debug = true;
	error_reporting(E_ALL);
	if ($debug) {
	    ini_set('display_errors', 1);
	} else {
	    ini_set('display_errors', 0);
	}

	$goip->close();
	print_r($mens);
}
else
{
	echo("No escribio ningun mensaje para enviar. Por favor retroceda y vuelva a intentarlo.")
}