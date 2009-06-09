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
<title>DASO</title>
<style type="text/css">
<!--
.style3 {font-size: 36px}
-->
</style>
</head>

<body>';


echo'
<div class="story-featured">
<h1 style="color:green">
Write Remarks about a student or whole class
</h1>
</div>';

echo'

<div style="border-bottom: 2px solid rgb(247, 247, 247);" class="yui-gc">

<div class="yui-u first">

<form id="form1" name="form1" method="post" action="notes_select_roll.php">

<table width="601" border="1">
        <tr>
          <td width="400" height="309"><img src="' . $_CONF1['ImageDir'] . 'notes.jpg" /></td> 
                    <td width="362"><table width="367" border="1">
            <tr>
              <td width="192" height="42">TEACHER NAME(without space) </td>
              <td width="215"><input type="text" name="teacher_name" /></td>
            </tr>
            <tr>
              <td height="43">BRANCH</td>
              <td><input type="text" name="branch" /></td>
            </tr>
            <tr>
              <td height="42">SECTION</td>
              <td><input type="text" name="section" /></td>
            </tr>
            <tr>
              <td height="43">YEAR of ENTRY (of class)</td>
              <td><input type="text" name="year_of_entry" /></td>
            </tr>
            <tr>
              <td height="41">SUBJECT CODE </td>
              <td><input type="text" name="sub_code" /></td>
            </tr>
            <tr>
              <td height="41">Date </td>
              <td><input type="text" name="date" /></td>
            </tr>
            <tr>
              <td height="42">MONTH</td>
              <td><select name="month">
                <option value="Jan">JAN</option>
                <option value="Feb">FEB</option>
                <option value="Mar">MAR</option>
                <option value="Apr">APR</option>
                <option value="May">MAY</option>
                <option value="Jun">JUN</option>
                <option value="Jul">JUL</option>
                <option value="Aug">AUG</option>
                <option value="Sep">SEP</option>
                <option value="Oct">OCT</option>
                <option value="Nov">NOV</option>
                <option value="Dec">DEC</option>
              </select></td>
            </tr>
            <tr>
              <td height="41">Year </td>
              <td><input type="text" name="year" /></td>
            </tr>
            <tr>
              <td height="41">Time (hh:mm:ss) </td>
              <td><input type="text" name="time_now" /></td>
            </tr>

          </table>
            <table width="368" height="34" border="1">
              <tr>
                <td width="137" height="28">&nbsp;</td>
                <td width="94"><input type="submit" name="Submit" value="Submit Query" /></td>
                <td width="171">&nbsp;</td>
              </tr>
            </table></td>
        </tr>
      </table></td>
    </tr>
  </table>
</form>
</div>';

get_available_classes($branch,$section,$year_of_entry);


echo'
<div class="yui-u">
<br />
<span class="down">
<center><strong>Available Classes</strong></center>
<ul class="bullet-grey">';

for($i = 0;$i<count($branch);$i++)
{
	$temp = $branch[$i] . " -".$section[$i]. " , ".$year_of_entry[$i];
	echo '<li>'.$temp.'</li>';
}

echo'</ul>

</span> 
<br />
<span class="note">
<strong>Enter "0" for fields whom you want to get the general information.E.g. subject code 0 will mean for all subjects.
</strong>
</span> 
</div>

</div>
</body>
</html>';


//printing of footer of the webpage

$display = COM_siteFooter();
echo $display;
?>