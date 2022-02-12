<?php 
	require 'lib/nusoap.php';
	$server = new nusoap_server();
	
	function calculate($calc,$principle,$rate,$time){
		if($calc=='simple'){
			$answer = ($principle*$rate*$time)/100;
			return "The simple interest is: " . $answer;
		}else if($calc=='compound'){
			$temp = 1 + ( $rate / 100 );
			$answer = $principle * pow( $temp , $time );
			$answer = $answer - $principle;
			return "The compound interest is: " . $answer;
		}
		else{
		echo "Invalid Input";
		}
	}
	
	function hello($name){
		return "hello " . $name;
	}

	$server->configureWSDL("calculateWS","urn:calculateWS");
	
	$server->register("calculate",
		array('calc' => 'xsd:string',
			  'principle' => 'xsd:integer',
			  'rate' => 'xsd:integer',
			  'time' => 'xsd:time'),
		array('return' => 'xsd:string'));

	$server->register("hello",
		array("name" => "xsd:string"),
		array("return" => "xsd:string"));

	$server->service(file_get_contents('php://input'));
?>