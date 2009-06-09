<?php

require_once $_SERVER['DOCUMENT_ROOT'] . 'gl/btp/lib-common1.php';
require_once $_SERVER['DOCUMENT_ROOT'] . 'gl/btp/db.php';
//require_once 'db.php';	

global $_CONF1;
$display =  COM_siteHeader('menu','test');
echo $display;

echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>';

echo $teacher_name = $_POST['teacher_name'];
 $branch = $_POST['branch'];
 $section = $_POST['section'];
 $year_of_entry = $_POST['year_of_entry'];
 $sub_code = $_POST['sub_code'];
 $month = $_POST['month'];
 $date = $_POST['date'];
 $year= $_POST['year'];
 $time_now = $_POST['time_now'];				//time at which remarks are to be added
 $no_students = $_POST['no_students'];
			$j=0;
			$string = "notes_check.php?roll_no=";
			for($i=0;$i<$no_students;$i++)
			{

				$checkbox[$i] = $_POST['checkbox'.$i];
				if($checkbox[$i])
				{
					$roll_no[$j++] = $checkbox[$i];			//roll_no is basically the index at which student roll number is present in class info
				}
			}

			for($i=0; $i<$j-1 ;$i++)
			{
				$string = $string.$roll_no[$i].'*';			
			}
				$string = $string.$roll_no[$i];			

echo '<form id="form1" name="form1" method="post" action="'.$string.'">';

echo'
		<input type="hidden" name="teacher_name" value='. $teacher_name .' />
		<input type="hidden" name="branch" value='. $branch .' />
		<input type="hidden" name="section" value='. $section .' />
		<input type="hidden" name="year_of_entry" value='. $year_of_entry .' />
		<input type="hidden" name="sub_code" value='. $sub_code .' />
		<input type="hidden" name="month" value='. $month .' />
		<input type="hidden" name="date" value='. $date .' />
		<input type="hidden" name="year" value='. $year .' />
		<input type="hidden" name="time_now" value='. $time_now .' />

<table width="385" height="358" border="1">	
<td>
	<label><table width="385" height="358" border="0">
      <tr>
        <td height="66">
			<h1>TAKE NOTES</h1>		
		</td>
      </tr>
      <tr>
		<td height="200">
			<textarea name="notes" cols="100" rows="10" ></textarea>
		</td>
      </tr>
      <tr>
        <td height="33"><table width="622" border="0">
          <tr>
            <td width="10">&nbsp;</td>
			<td width="88"><input type="submit" name="Submit" value="SUBMIT" /></td>
			</form>
            <td width="59">&nbsp;</td>
            <form id="form1" name="form1" method="post" action="notes_take_menu.php">
			<td width="206"><input type="submit" name="Submit2" value="CANCEL" /></td>
			</form>
            <td width="237">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table>
</td>
</table>
</body>
</html>';

//printing of footer of the webpage
$display = COM_siteFooter();
echo $display;
?>