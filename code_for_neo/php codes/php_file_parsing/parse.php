
<?php

//parses the file send by the openmoko
function parse_file($file_name, $no_students, $roll_list, $attendance_list)
{
	$file_handle=fopen($file_name,'r');
	$data=fgets($file_handle);
	echo $data;
	$no_students=fgets($file_handle);
	for($i=0;$i<$no_students;$i++)
	{
		$attend=chop(fgets($file_handle));
		if($attend=="yes")
		{
			$roll_list[$i] = $i+1;
			$attendance_list[$i]=1;
		}
		else
		{
			$roll_list[$i] = $i+1;
			$attendance_list[$i]=0;

		}
	}
	fclose($file_handle);

}


parse_file("test_file.txt", &$no, &$roll, &$attend);
echo "no of students are ".$no."\n";
for($i = 0; $i < $no; $i++)
{
	echo $roll[$i]."\t". $attend[$i]."\n";
}

?>

