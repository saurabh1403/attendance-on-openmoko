
<?php

include "db.php";

//parses the file send by the openmoko
function parse_file($file_name)
{
	$file_handle=fopen($file_name,'r');
	$data=chop(fgets($file_handle));
	if($data=="ATTENDANCE")
	{
//		$info['SubjectCode']  = "210";
		#this part extarcts the info from the file
		$info['ClassName']=chop(fgets($file_handle));
		list($trash,$info['SubjectCode'],$trash1,$trash2) = split('_',$info['ClassName']);
//		echo $info['SubjectCode'];

		$trash=fgets($file_handle);
		$trash=chop(fgets($file_handle));

		$trash=fgets($file_handle);
		$info['OpenmokoID']=chop(fgets($file_handle));
		
		$trash=fgets($file_handle);
		$info['TeacherName']=chop(fgets($file_handle));
//		echo $info['TeacherName']."<br/>\n";

		$trash=fgets($file_handle);
		$trash=chop(fgets($file_handle));

		$info['TimeStamp']=chop(fgets($file_handle));

	// split the phrase by any number of commas or space characters,
	// which include " ", \r, \t, \n and \f
		list($trash, $info['Month'], $info['Date'], $info['Time'],$info['Year'])=preg_split("/[\s,]+/",$info['TimeStamp']);

		echo "\nmonth is\t". $info['Month'] ."\ndate is\t".$info['Date']. "\ntime is\t".$info['Time']."\nyear is\t".$info['Year']. "\n\n";

//		echo $info['Year'] ."\n";

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

//		echo "\n\nno of st". count($arr_attend)."\n\n";
		update_database($info,$arr_attend);
	}

	else
	{
		#notes taking
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

