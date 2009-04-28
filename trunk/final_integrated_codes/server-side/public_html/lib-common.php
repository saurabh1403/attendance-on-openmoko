<?php

require_once 'siteconfig.php';


function LogErrMsg($ErrMsg)
{
	
	
	
	
	
}


//to be made
function file_read_linewise($file_name, &$data, &$no)
{
	global $_CONF,$_FILE_NAMES;
//	echo "i am ahere";
//	$class_list = $_CONF['DataDir'] . $_FILE_NAMES['class_list'];
	$file_handle=fopen($file_name,'r');

	echo "\n $class_list\n";
//	$file_handle=fopen($class_list,'r');
	
	if(!$file_handle)
	{
		echo "file not opened\n";
		return -1;
	}

	$i=0;
	while($temp = chop(fgets($file_handle)))
	{
		$roll[$i]=$i+1;
		$data[$i]=$temp;
		$i++;
	}

	$no = $i;
	fclose($file_handle);

}



?>
