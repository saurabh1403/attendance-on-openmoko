
<?php

include 'db.php';

$_SQL['attendance'] = "
CREATE TABLE att(
			TeacherName varchar(20) NOT NULL, 
			SubjectCode varchar(20) NOT NULL,
			OpenmokoID varchar(20) NOT NULL, 
			Date INT NOT NULL,
			Month INT NOT NULL,
			Year INT NOT NULL,
			Time varchar(20) NOT NULL,
			Saurabh_Gupta varchar(5) DEFAULT 'A',
			Praveen_yadav varchar(5) DEFAULT 'A',
			Vijay_Majum varchar(5) DEFAULT 'A',
			Vijay_lamba varchar(5) DEFAULT 'A',
			nimit_varsh varchar(5) DEFAULT 'A',
			PRIMARY KEY (TeacherName,Time,OpenmokoID))";




$_SQL[]= "
insert into att values('Mr. D.V.G.','EC-481','#122321','14','21','2008','11:30:14','P','P','A','A','P')";

$_SQL[]= "
select * from att where TeacherName = 'Mr. D.V.G.'";



$con = mysql_connect("localhost","root","openmoko");

if (!$con)
{
  	die('Could not connect: ' . mysql_error());
}


//$roll = array(11,21,13,14,51);
//$names = array("saurabh","vijay","praveen","nimit","lamba");


//echo "haha '$_SQL[\'attendance\']' $_SQL[0] \n";

//create_class_names("my_db1", $con, "names_ECE_402_2_2008");
//file_read_linewise("ICE_330_2_2005.txt",&$roll,&$names);
//update_class_names("my_db1", $con, " names_ICE_330_2_2005", $roll, $names);

//create_ODASI_table("my_db1",$con);


//create_attendance_table("my_db1", $con, "ICE_330_2_2005", "names_ICE_330_2_2005");


$info = array(  'TeacherName' => 'Mr. D.U.',
				'SubjectCode' => 'EC-401',
				'OpenmokoID' => '#123451',
				'Date' => '12',
				'Month' => '11',
				'Year' => '2009',
				'Time' => '12:15:13',
				'TimeStamp' => 'sdsdss');

$info_odasi = array( 'Branch' => 'ICE',
				'Section' => '2',
				'Year' => '2005',
				'name_file' => 'names_ICE_330_2_2005',
				'attendance_file' => 'ICE_330_2_2005');


$attend = array('P','A','A','P','A');
$no = count($attend);


//echo $no;
//update_attendance_table("my_db1",$con, "attendance_ECE_2_2005",$info, $attend);
//update_ODASI_table("my_db1",$con,$info_odasi);
/*
execute_query_list("my_db1",$con, "SELECT * from names_ECE_2_2005", &$rows, &$col, &$op);

for($i = 0; $i < $rows; $i++)
{
	for($j =0 ; $j<$col; $j++)
	{
		echo $op[$i][$j]. "\t";
	}
	
	echo "\n";
}
*/


retrieve_attendance_data("my_db1",$con, "ICE","2","2005", "Mar", "330", &$no_students, &$stamp, &$stats, &$st_names, &$roll_no);

//print_r($roll_no);

//print_r($st_names);

$no_rows = count($stamp);

echo "$no_rows \t $no_students \n";

for($i = 0; $i < $no_rows; $i++)
{
	echo "$stamp[$i] \t";
	for($j =0 ; $j < $no_students; $j++)
	{
		echo $stats[$i][$j]. "\t";
	}
	
	echo "\n";
}



//print_r($op);
//echo "\n $col \n $rows \n";

//show_data("my_db1",$con, "att");
//execute_query_NR("my_db1",$con, $_SQL[1]);
mysql_close($con);









?>


