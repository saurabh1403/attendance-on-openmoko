<?php

require_once $_SERVER['DOCUMENT_ROOT'] . 'gl/btp/lib-common1.php';
require_once $_SERVER['DOCUMENT_ROOT'] . 'gl/btp/db.php';
//require_once 'db.php';	

global $_CONF1;
$display =  COM_siteHeader('menu','test');
echo $display;


$info['TeacherName'] = $_POST['teacher_name'];
$info['Branch'] = $_POST['branch'];
$info['Section'] = $_POST['section'];
$info['EntryYear'] = $_POST['year_of_entry'];
$info['SubjectCode'] = $_POST['sub_code'];
$info['OpenmokoID'] = 1240;
$info['Date'] = $_POST['date'];
$info['Month'] = $_POST['month'];
$info['Year']= $_POST['year'];
$info['Time'] = $_POST['time_now'];				//time at which remarks are to be added

$time_stamp = $info['Month'] . " ". $info['Date'] . " " . $info['Time'] . " " . $info['Year'];
$info['TimeStamp'] = $time_stamp;

echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>';

//		saurabh -- get the class, subject, code from notes_submit_query.php as you would require it to fill in your database function 
//					you have to send it via url as notes_submit_query send it to notes_submit then to save_notes then here...
// 		$roll_no is the array of roll no of students whose notes are taken, $notes you know
			$roll_list = $_GET['roll_no'];
			$notes = $_POST['notes'];
			$roll_no = split('\*', $roll_list);		
			for($i=0;$i<count($roll_no);$i++)
			{
				$roll_no[$i]."<br/>";
			}

update_notes_database($info, $roll_no, $notes);

$notes_menu_script = $att_menu_script = $_CONF['site_url'] . '/btp/' . 'notes_take_menu.php';

echo '
<span class="info">
<H1>
Notes has been added successfully...
</H1>
</span>
<br />
<br />
		<ul class="bullet-star"><li>
		<strong>
			<a href="'. $notes_menu_script .'">
				<li>Write More remarks....</li>
			</a>
			</strong></li>
		</ul>

';


echo '<body>
</body>
</html>';



//printing of footer of the webpage
$display = COM_siteFooter();
echo $display;
?>