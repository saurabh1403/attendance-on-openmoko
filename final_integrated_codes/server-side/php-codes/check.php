<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Attendance Sheet</title>
</head>

<body>

	<?PHP
	
	include "db.php";

//	echo DB_NAME;

		$teacher_name = $_POST['teacher_name'];
		$branch = $_POST['branch'];
		 $section = $_POST['section'];
		 $year = $_POST['year'];
		 $sub_code = $_POST['sub_code'];
		 $month = $_POST['month'];
//		$month = chop($month);

//		$temp[0] = $branch[0];
//		echo $branch[4]. "\n";
//		
//		echo strlen($temp);

//		if($month == "Mar")
		if($branch == "ICE")
		{
//			echo "yes\n";
		}
		
		$con = mysql_connect("localhost","root","openmoko");

			if (!$con)
			{
				die('Could not connect: ' . mysql_error());
			}

		//return_data($branch, $section, $year, $sub_code, $month, &$roll_no, );
		//FF0000
		//66FF99
//		$arr_roll = array(51, 52, 53, 54, 55, 56, 57,58,59);
//		$arr_name = array ("Vijay","Saurabh","Lamba","Vijay","Saurabh","Lamba","Vijay","Saurabh","Lamba");
//		$arr_attnd = array(array(1,0,1),array(1,0,1),array(1,0,1),array(1,0,1),array(1,0,1),array(1,0,1),array(1,0,1),array(1,0,1),array(1,0,1));
//		$arr_date = array("1","2","3","4","5","6","7", "8", "9");

/*
	execute_query_list("my_db1",$con, "SELECT * from ODASI", &$rows, &$col, &$op);

	for($i = 0; $i < $rows; $i++)
	{
		for($j =0 ; $j<$col; $j++)
		{
			echo $op[$i][$j]. "\t";
		}
		
		echo "\n";
	}
*/

		retrieve_attendance_data(DB_NAME, $con, $branch, $section, $year, $month, $sub_code, &$no_students, &$arr_date, &$arr_attnd, &$arr_name, &$arr_roll);
//		retrieve_attendance_data(DB_NAME, $con, "ICE","2","2005", "Mar", "330", &$no_students, &$arr_date, &$arr_attnd, &$arr_name, &$arr_roll);
		mysql_close($con);
		
		
		?>
	
	<H1>Attendance Table</H1>

	<table width="200" border="1">
	<tr>
    	<td>Roll No</td>
    	<td>Name</td>
		<?PHP
			for($i = 0; $i < count($arr_date); $i++)
			{
				echo "<td>";
				echo $arr_date[$i];
				echo "</td>\n";
			}
		?>
	</tr>
	<?PHP
	for($i = 0; $i < count($arr_roll); $i++)
	{
		echo "<tr>\n";
			echo "<td>".$arr_roll[$i]."</td>\n";
			echo "<td>".$arr_name[$i]."</td>\n";
			for($j = 0; $j < count($arr_date); $j++)
			{
				echo "<td>";
					if($arr_attnd[$j][$i]==1)
					{
						echo "<font color=\"#66FF00\"><b>"."P"."</b></font>";
					}
					else
					{
						echo "<font color=\"#FF0000\"><b>"."A"."</b></font>";
					}
				echo "</td>\n";
			}
		echo "</tr>\n";
	}
	?>
	</table>
</body>
</html>
