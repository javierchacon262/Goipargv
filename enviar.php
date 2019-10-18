<?php 
    
	include 'send.php';
	
	//echo shell_exec("php send.php ".$_POST ["phoneNumber"]." ".$cad);
	
	$archivo = $_POST ["excel"];
    $archivo = fopen($archivo,'r');
	$numlinea = 0;
	$cad = '"'.$_POST ["smsMessage"].'"';
	$num = '"'.$_POST ["phoneNumber"].'"';
	
	
	while ($linea = fgets($archivo)) 
	{
		//echo $linea.'<br/>';
		$aux[] = $linea;
		//echo gettype($aux[$numlinea]);
		$numlinea++;
		//echo shell_exec("php send.php ".$aux[$numlinea]." ".$cad);
		$argv("", $linea, $cad);
		
	}
	
	
	
?>