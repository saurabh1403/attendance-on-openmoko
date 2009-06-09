<?php

require_once $_SERVER['DOCUMENT_ROOT'] . 'gl/btp/lib-common1.php';
require_once $_CONF1['path'] . 'db.php';


function parse_attendance_file($file_handle)
{

	$trash=fgets($file_handle);			//Device information
	$trash=chop(fgets($file_handle));
	
	$trash=fgets($file_handle);
	$info['OpenmokoID']=chop(fgets($file_handle));

	$trash=fgets($file_handle);
	$info['TeacherName']=chop(fgets($file_handle));

	$trash=fgets($file_handle);			//year of issue
	$trash=chop(fgets($file_handle));

	$info['TimeStamp']=chop(fgets($file_handle));
// split the phrase by any number of commas or space characters,
// which include " ", \r, \t, \n and \f
	list($trash, $info['Month'], $info['Date'], $info['Time'],$info['Year'])=preg_split("/[\s,]+/",$info['TimeStamp']);

	#this part extarcts the info from the file
	$trash=fgets($file_handle);			//year of issue
	$info['ClassName']=chop(fgets($file_handle));
	list($info['Branch'],$info['Section'],$info['EntryYear']) = split('_',$info['ClassName']);

	$trash=fgets($file_handle);
	$info['SubjectCode']=chop(fgets($file_handle));

	$trash=fgets($file_handle);
	$i=0;

	while($temp=chop(fgets($file_handle)))
	{
		$attend=chop(fgets($file_handle));
		if($attend=="PRESENT")
		{
			$arr_attend[$i]=1;
		}

		else
		{
			$arr_attend[$i]=0;
		}

//			echo $arr_attend[$i]."\n";
		$i++;
	}

	update_att_database($info,$arr_attend);

}


function parse_notes_file($file_handle)
{

	$trash=fgets($file_handle);			//Device information
	$trash=chop(fgets($file_handle));

	$trash=fgets($file_handle);
	$info['OpenmokoID']=chop(fgets($file_handle));

	$trash=fgets($file_handle);
	$info['TeacherName']=chop(fgets($file_handle));

	$trash=fgets($file_handle);			//year of issue
	$trash=chop(fgets($file_handle));

	$info['TimeStamp']=chop(fgets($file_handle));
// split the phrase by any number of commas or space characters,
// which include " ", \r, \t, \n and \f
	list($trash, $info['Month'], $info['Date'], $info['Time'],$info['Year'])=preg_split("/[\s,]+/",$info['TimeStamp']);

	#this part extarcts the info from the file
	$trash=fgets($file_handle);			//year of issue
	$info['ClassName']=chop(fgets($file_handle));
	list($info['Branch'],$info['Section'],$info['EntryYear']) = split('_',$info['ClassName']);

	$trash=fgets($file_handle);
	$info['SubjectCode']=chop(fgets($file_handle));

	$trash=fgets($file_handle);		//roll number
	$temp=chop(fgets($file_handle));
	$i=0;
	
	while($temp!="Comment")
	{
		$roll_no[$i]=$temp;
		$temp=chop(fgets($file_handle));
		$i++;
	}

//	print_r($info);
	$i=0;
	$temp=chop(fgets($file_handle));		//first line of notes.
	$notes = "";

	while($temp)
	{
		$notes .= $temp;
		$temp=chop(fgets($file_handle));
//			echo $arr_attend[$i]."\n";
		$i++;
	}

//	print_r($roll_no);
//	print_r($notes);
//		echo "\n\nno of st". count($arr_attend)."\n\n";

	update_notes_database($info, $roll_no, $notes);

}



//parses the file send by the openmoko
function parse_file($file_name)
{

	$file_handle=fopen($file_name,'r');
	$data=chop(fgets($file_handle));
	if($data=="ATTENDANCE")
	{

		parse_attendance_file($file_handle);
	}

	else if($data == "NOTES")
	{
		parse_notes_file($file_handle);
	}

	fclose($file_handle);

}

//test();

//parse_file("test_file.txt", &$no, &$roll, &$attend);

//echo "no of students are ".$no."\n";

/*
for($i = 0; $i < $no; $i++)
{
	echo $roll[$i]."\t". $attend[$i]."\n";
}
*/

?>
