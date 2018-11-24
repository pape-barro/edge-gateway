<?php

function logFile(){
	$log = json_decode(file_get_contents("./log.json"));
	return $log->{'login'};
}

function serial(){
	$arrayName = array();
	$arrayName ['p']="Pape";
	$arrayName ['A']="Abdoulaye";
	$arrayName ['B']="BARRO";
	$string = serialize($arrayName);
	return $string;
}

function create_file(){
	$login = "Abdoulaye";
	$pwd = "barro";
	$string="{\"login\":\"".$login."\", \"password\":\"".$pwd."\"}";
	// write o the file
	$file = './log.json';
	$f = fopen($file, 'w+');
	fwrite($f, $string);
	fclose($f);
	return $string;
}

print_r(create_file());
