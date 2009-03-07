<?php
	$myfile="test_file.txt";
	$file_handle=fopen($myfile,'r');
	$data=fgets($file_handle);
	echo $data;
	$no_student=fgets($file_handle);
	echo $no_student;	
	for($i=0;$i<$no_student;$i++)
	{
		$attend=chop(fgets($file_handle));
		if($attend=="yes")
		{
			$arr[$i]=1;
		}
		else
		{
			$arr[$i]=0;
		}
		echo $arr[$i];
	}
	fclose($file_handle);
?>