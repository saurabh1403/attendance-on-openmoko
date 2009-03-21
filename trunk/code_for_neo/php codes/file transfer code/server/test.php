
<?php

$host = "127.0.0.1";
$port = 3490;
$term_string = "EOF";


// read client input
function recv_string($spawn)
{
	$buff = "a";
	$buff = socket_read($spawn, 1024);// or die("Could not read input\n");

	socket_write($spawn, "ok", 2) or die("Could not write output\n");
//	socket_write($spawn, "ok", 2) or return "Could not write output\n";
	
	return $buff;
}


function recv_file($spawn)
{
	$input = recv_string($spawn);

	while($input != "FILE")
	{
		$input = recv_string($spawn);
	}

	$input = recv_string($spawn);
	echo $input . "  file is coming\n";

	$flag = 1;

	$file = fopen($input,"w") or exit("file can't be opened");
//	fseek($file, 0, SEEK_END);

	while($flag == 1)
	{
		$input = recv_string($spawn);

		if($input =="data")
			$flag=1;

//		elseif($input == $term_string)
//			$flag  = 0;

		else
			$flag = 0;

		if($flag !=0)
		{
			$input = recv_string($spawn);
			echo $input;
//			$input[1]='\0';
			fputs($file, $input, 1);
		}
	
	}

	fclose($file);
}


echo $term_string[0]. "first letter\n";


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
recv_file($spawn);
}

socket_close($spawn);
socket_close($socket);

?>

