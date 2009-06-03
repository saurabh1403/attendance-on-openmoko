<?php

//require_once ('../lib-common.php');
require_once $_SERVER['DOCUMENT_ROOT'] . 'gl/btp/lib-common1.php';
require_once $_SERVER['DOCUMENT_ROOT'] . 'gl/btp/db.php';
//require_once 'db.php';	

global $_CONF1;
$display =  COM_siteHeader('menu','test');
echo $display;




//printing of Header of the webpage
echo '
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

<body> ';



//printing of heading of this page

echo'
<div class="story-featured">
<h1 style="color:green">Class Performance over a period of months</h1>
</div>';



//printing of central data of webpage
echo '
<div style="border-bottom: 2px solid rgb(247, 247, 247);" class="yui-gc">

<div class="yui-u first">

<form id="form1" name="form1" method="post" action="class_check.php">

<table width="673" border="1">
        <tr>
          <td width="315" height="359"><img src="' . $_CONF1['ImageDir'] . 'attendance.jpg" /></td> 
                    <td width="362"><table width="367" border="1">
            <!--tr>
              <td width="176" height="42">TEACHER NAME </td>
              <td width="175"><input type="text" name="teacher_name" /></td>
            </tr-->
            <tr>
              <td height="43">BRANCH</td>
              <td><input type="text" name="branch" /></td>
            </tr>
            <tr>
              <td height="42">SECTION</td>
              <td><input type="text" name="section" /></td>
            </tr>
            <tr>
              <td height="43">YEAR OF ENTRY</td>
              <td><input type="text" name="year_of_entry" /></td>
            </tr>
            <tr>
              <td height="41">SUBJECT CODE </td>
              <td><input type="text" name="sub_code" /></td>
            </tr>
            <tr>
              <td height="39">FROM</td>

              <td><select name="month_from">
                <option value= 1>JAN</option>
                <option value=2>FEB</option>
                <option value=3>MAR</option>
                <option value=4>APR</option>
                <option value=5>MAY</option>
                <option value=6>JUN</option>
                <option value=7>JUL</option>
                <option value=8>AUG</option>
                <option value=9>SEP</option>
                <option value=10>OCT</option>
                <option value=11>NOV</option>
                <option value=12>DEC</option>
                            </select></td>
            </tr>

            <tr>
              <td height="39">TO</td>
              <td><select name="month_to">
                <option value= 1>JAN</option>
                <option value=2>FEB</option>
                <option value=3>MAR</option>
                <option value=4>APR</option>
                <option value=5>MAY</option>
                <option value=6>JUN</option>
                <option value=7>JUL</option>
                <option value=8>AUG</option>
                <option value=9>SEP</option>
                <option value=10>OCT</option>
                <option value=11>NOV</option>
                <option value=12>DEC</option>
				</select></td>
            </tr>
            <tr>
              <td height="41">YEAR </td>
              <td><input type="text" name="year" /></td>
            </tr>

          </table>
            <table width="371" height="40" border="1">
              <tr>
                <td width="137">&nbsp;</td>
                <td width="94"><input type="submit" name="Submit" value="Submit Query" /></td>
                <td width="118">&nbsp;</td>
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
<strong>Warning: Entering any wrong section or subject code will result in different data. Be careful!!</strong>
</span> 
</div>

</div>
';


//printing of footer of the webpage

$display = COM_siteFooter();
echo $display;
?>