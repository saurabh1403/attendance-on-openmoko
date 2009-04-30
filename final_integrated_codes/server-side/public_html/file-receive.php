
<?php

include "parse.php";
$host = "127.0.0.1";
$port = 3491;
$term_string = "EOF";
$data_string = "data";			//string which indicates that data is coming
$DATABASE_DIR = "./";

$action_type['FILE']=1;
$action_type['UPDATE']=2;

require_once 'lib-common.php';

// read client input
function recv_string($spawn)
{
	$buff = "a";
	$buff = socket_read($spawn, 1024);		// or die("Could not read input\n");

	socket_write($spawn, "ok", 2) or die("Could not write output\n");
//	socket_write($spawn, "ok", 2) or return "Could not write output\n";

	return $buff;
}



function communicate($spawn)
{
	global $action_type;
	$input = recv_string($spawn);
	return $action_type[$input];

}


function recv_file($spawn)
{
	global $_CONF;

	$input = recv_string($spawn);
	echo $input . "  file is coming\n";

	$flag = 1;

//	$file_created = DATABASE_DIR. $input;
	$file_created = $_CONF['LocalDir']. $input;

	echo $file_created. "\n";

	$file = fopen($file_created,"w") or exit("file can't be opened");
	echo "\nhere";

	while($flag == 1)
	{
		$input = recv_string($spawn);

//		if($input ==$data_string)
		if($input =="data")
			$flag=1;

		else
			$flag = 0;

		if($flag !=0)
		{
			$input = recv_string($spawn);
			fputs($file, $input, 1);
		}
	
	}

	fclose($file);

	return $file_created;
}

// don't timeout!
set_time_limit(0);

// create socket
$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");

// bind socket to port
$result = socket_bind($socket, $host, $port) or die("Could not bind to socket\n");

// start listening for connections
$result = socket_listen($socket, 3) or die("Could not set up socket listener\n");

// accept incoming connections
// spawn another socket to handle communication
while(1)
{
	$spawn = socket_accept($socket) or die("Could not accept incoming connection\n");
	$action = communicate($spawn);

//	$action = 1;

	switch($action)
	{
		case $action_type['FILE']: 
			$file_name = recv_file($spawn);
			parse_file($file_name);
			break;

		default:
			break;
	}
}

socket_close($spawn);
socket_close($socket);

?>

