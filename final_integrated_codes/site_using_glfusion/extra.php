
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Attendance Sheet</title>
</head>

<body>

	<?PHP
		require_once './lib-common1.php';	
		require_once $_CONF1['path'] . 'db.php';

		$teacher_name = $_POST['teacher_name'];
		$branch = $_POST['branch'];
		 $section = $_POST['section'];
		 $year = $_POST['year'];
		 $sub_code = $_POST['sub_code'];
		 $month = $_POST['month'];

		retrieve_attendance_data($branch, $section, $year, $month, $sub_code, &$no_students, &$arr_date, &$arr_attnd, &$arr_name, &$arr_roll);

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

