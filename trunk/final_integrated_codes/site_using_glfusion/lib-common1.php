<?php

require_once $_SERVER['DOCUMENT_ROOT'] . 'gl/btp/siteconfig1.php';
//require_once 'siteconfig1.php';

function LogErrMsg($ErrMsg)
{


}

//to be made
function file_read_linewise($file_name, &$data, &$no)
{
	global $_CONF1,$_FILE_NAMES;
//	echo "i am ahere";
//	$class_list = $_CONF1['DataDir'] . $_FILE_NAMES['class_list'];
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


function read_file_names($class_names_file, &$names, &$roll_no, &$no_students)
{

	file_read_linewise($class_names_file,$data,$no);

	$no_students = 0;

	for($i=0 ; $i<$no ; $i+=2)
	{
		$roll_no[$no_students] = $data[$i];
		$names[$no_students] = $data[$i+1];
		$no_students +=1;
	}

}


function show1($string1)
{
	global $_CONF1;
	$file_created = $_CONF1['LocalDir']. 'temp.txt';

	$file = fopen($file_created,"a+") or exit("file can't be opened");
	fputs($file, $string1."\n");

	fclose($file);
}






?>
