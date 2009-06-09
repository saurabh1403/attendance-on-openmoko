<?php

require_once $_SERVER['DOCUMENT_ROOT'] . 'gl/btp/lib-common1.php';
require_once $_SERVER['DOCUMENT_ROOT'] . 'gl/btp/db.php';
//require_once 'db.php';	

global $_CONF1;
$display =  COM_siteHeader('menu','test');
echo $display;

echo $teacher_name = $_POST['teacher_name'];
echo $branch = $_POST['branch'];
echo $section = $_POST['section'];
echo $year_of_entry = $_POST['year_of_entry'];
echo $sub_code = $_POST['sub_code'];
echo $month = $_POST['month'];
echo $date = $_POST['date'];
echo $year= $_POST['year'];
echo $time_now = $_POST['time_now'];				//time at which remarks are to be added


echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Notes Sheet</title>
</head>
<body>';

		get_class_info($branch, $section, $year_of_entry, &$arr_name,&$arr_roll_no);
		$no_students = count($arr_name);

echo'
	<form id="form1" name="form1" method="post" action="notes_enter.php">
	<H1>Take Notes</H1>
		<input type="hidden" name="teacher_name" value='. $teacher_name .' />
		<input type="hidden" name="branch" value='. $branch .' />
		<input type="hidden" name="section" value='. $section .' />
		<input type="hidden" name="year_of_entry" value='. $year_of_entry .' />
		<input type="hidden" name="sub_code" value='. $sub_code .' />
		<input type="hidden" name="month" value='. $month .' />
		<input type="hidden" name="date" value='. $date .' />
		<input type="hidden" name="year" value='. $year .' />
		<input type="hidden" name="time_now" value='. $time_now .' />
		<input type="hidden" name="no_students" value='. $no_students .' />

		<table width="400" border="1">
		<tr>
			<td width="63">Roll No.</td>
			<td width="263">Name</td>
			<td width="52">Select</td>
		</tr>';



//		$arr_name = array("Vijay", "Kumar", "Majumdar");
//		$arr_roll_no = array(1,2,3);
		for($i = 0; $i < count($arr_name); $i++)
		{
			echo'<tr>';
			echo'<td>';
			echo $arr_roll_no[$i];
			echo "</td>\n";
			echo'<td>';
			echo $arr_name[$i];
			echo "</td>\n";
			echo'<td>';
			echo '<input type="checkbox" name="checkbox'.$i.'" value="'.$arr_roll_no[$i].'">';
			echo "</td>\n";
			echo"</tr>\n";
		}

echo'		</table>
		<table width="400" border="0">
  <tr>
    <td width="161">&nbsp;</td>
    <td width="56">&nbsp;</td>
    <td width="161">&nbsp;</td>
  </tr>
  <tr>
  
    <td height="30">
			<input type="submit" name="Submit" value="SUBMIT" />
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
</body>
</html>';

//printing of footer of the webpage
$display = COM_siteFooter();
echo $display;
?>