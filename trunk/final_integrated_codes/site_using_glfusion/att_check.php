<?php
//require_once ('../lib-common.php');
require_once $_SERVER['DOCUMENT_ROOT'] . 'gl/btp/lib-common1.php';
require_once $_CONF1['path'] . 'db.php';


$display =  COM_siteHeader('menu','test');
//echo $display;
global $_CONF1,$_CONF;

echo '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Attendance Sheet</title>
<style type="text/css">
<!--
.style3 {font-size: 36px}
-->
</style>

</head>

<body>';

   		$teacher_name = $_POST['teacher_name'];
		$branch = $_POST['branch'];
		 $section = $_POST['section'];
		 $year = $_POST['year'];
		 $sub_code = $_POST['sub_code'];
		 $month = $_POST['month'];

$att_stats_script = $_CONF['site_url'] . '/btp/' . 'att_stats.php';

echo'
<div style="border-bottom: 2px solid rgb(247, 247, 247);" class="yui-g">
	<div class="yui-u first">
		<span class="info">
			<H2>
				<center><strong>Attendance Table</strong>
				</center>
			</H2>
			<ul class="arrow">
				<li>Branch: ' . $branch .'</li>
				<li>Section: ' . $section .'</li>
				<li>Year of Entry: ' . $year .'</li>
				<li>Subject Code: ' . $sub_code .'</li>
			</ul>
		</span> 
	</div>

	<div class="yui-u">

		<ul class="script">
		<strong>
			<a href="http://www.nsit.com">
				<li>Print It</li>
			</a>
			</strong>
		</ul>
		<br />
		<ul class="bullet-star">
		<strong>
			<a href="'. $att_stats_script .'">
				<li>View overall Statistics of attendance data</li>
			</a>
			</strong>
		</ul>
		<br />

		<ul class="bullet-plus">
		<strong>
			<a href="http://www.nsit.com">
				<li>Refresh the result</li>
			</a>
			</strong>
		</ul>
		
	</div>





</div>';


echo'<table width="200" border="1">
	<tr>
    	<td>Roll No</td>
    	<td>Name</td>';

		$i = retrieve_attendance_data($branch, $section, $year, $month, $sub_code, $no_students, $arr_date, $arr_attnd, $arr_name, $arr_roll);

		for($i = 0; $i < count($arr_date); $i++)
		{
			echo '<td>';
			echo $arr_date[$i];
			echo '</td>';
		}
		?>

</tr>
<?php
	for($i = 0; $i < count($arr_roll); $i++)
	{
		echo '<tr>';
			echo '<td>'.$arr_roll[$i].'</td>';
			echo '<td>'.$arr_name[$i].'</td>';
			for($j = 0; $j < count($arr_date); $j++)
			{
				echo '<td>';
					if($arr_attnd[$j][$i]==1)
					{
						echo "<font color=\"#66FF00\"><b>".'P'.'</b></font>';
					}
					else
					{
						echo "<font color=\"#FF0000\"><b>".'A'.'</b></font>';
					}
				echo '</td>';
			}
		echo '</tr>';
	}


echo '
	</table>
</body>
</html>';

$display = COM_siteFooter();
echo $display;

?>