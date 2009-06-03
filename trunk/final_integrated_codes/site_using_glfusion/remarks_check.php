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

$branch = $_POST['branch'];
$section = $_POST['section'];
$year_of_entry = $_POST['year_of_entry'];
$sub_code = $_POST['sub_code'];
$roll_no = $_POST['roll_no'];
$month = $_POST['month'];
$year = $_POST['year'];


$notes_menu_script = $_CONF['site_url'] . '/btp/' . 'remarks_menu.php';
$print_script = $_CONF['site_url'] . '/btp/' . 'att_print.php';


echo'
<div style="border-bottom: 2px solid rgb(247, 247, 247);" class="yui-g">
	<div class="yui-u first">
	<div class="story-featured"><h1 style="color:green">Remarks Data</h1></div>
		<span class="info">
			<!--H2>
				<center><H1><strong>Remarks Data</strong></H1>
				</center>
			</H2-->
			<ul class="arrow">
				<li>Branch: ' . $branch .'</li>
				<li>Section: ' . $section .'</li>
				<li>Year of Entry: ' . $year_of_entry .'</li>
				<li>Roll Number: ' . (($roll_no==0)?' Whole class':$roll_no) .'</li>
				<li>Subject Code: ' . (($sub_code==0)?' All Subjects ':$sub_code) .'</li>
				<li>Data for the month: ' . (($month==0)?' Each month':$month) .'</li>
				<li>Data for the Year: ' . (($year==0)?' Every year':$year) .'</li>				
			</ul>
		</span> 
	</div>';

echo'	<div class="yui-u">	
		<br />
		<br />
		<br />
		<ul class="script"><li>

		<strong>
			<a href="'. $print_script .'">
				<li>Print It</li>
			</a>
			</strong></li>
		</ul>
		<br />
		
		
		<ul class="bullet-star"><li>
		<strong>
			<a href="'. $notes_menu_script .'">
				<li>View Remarks for a different student</li>
			</a>
			</strong></li>
		</ul>
		<br />

		<form action="'. $_SERVER['PHP_SELF'] .'" method="post">
		<input type="hidden" name="branch" value='. $branch .' />
		<input type="hidden" name="section" value='. $section .' />
		<input type="hidden" name="roll_no" value='. $roll_no .' />
		<input type="hidden" name="year_of_entry" value='. $year_of_entry .' />
		<input type="hidden" name="sub_code" value='. $sub_code .' />
		<input type="hidden" name="month" value='. $month .' />
		<input type="hidden" name="year" value='. $year .' />		
				<ul class="bullet-plus"><li>
		<input type="submit" name="submit" value="Refresh The Result" /></li>
				</ul>		
		</form>
	</div>
</div>';


unset($notes_stats);

if($sub_code==0)
{
	retrieve_notes_student_all($branch, $section, $year_of_entry, $roll_no, $subject_code, $student_name, $time_stamp, $notes_stats, $ErrMsg, $Teacher_name);
}

else
{
	$i = retrieve_notes_data_student($branch, $section, $year_of_entry, $month, $year, $sub_code, $roll_no, $student_name, $time_stamp, $notes_stats, $ErrMsg, $Teacher_name);
}

if($roll_no !=0)
{
	echo '<H1>Student\'s Name  : '.$student_name.'
	</H1>';
}

	echo'
	<div style="border-bottom: 2px solid rgb(247, 247, 247);" class="yui-gc">
	<div class="yui-u first">';


for($i =0;$i<count($notes_stats);$i++)
{
	echo'
		<span class="note">
		<strong>Teacher Name :  </strong>' .$Teacher_name[$i].'
		<strong> Time :  </strong>' .$time_stamp[$i].'
		<strong>  Subject Code :   </strong>' .(($sub_code==0)?(($subject_code[$i]==0)?' General note ':$subject_code[$i]):$sub_code).'
		<br />
		<ul class="arrow"><strong><li>'.$notes_stats[$i].'</li></strong></ul>
		</span>';
}

echo '
</div>
</div>';

echo '</body>
</html>';

$display = COM_siteFooter();
echo $display;

?>