<?php
//require_once ('../lib-common.php');
require_once $_SERVER['DOCUMENT_ROOT'] . 'gl/btp/lib-common1.php';
require_once $_CONF1['path'] . 'db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . 'gl/btp/create-histo.php';
require_once $_SERVER['DOCUMENT_ROOT'] . 'gl/btp/create-linegraph.php';


$display =  COM_siteHeader('menu','test');
//echo $display;
global $_CONF1,$_CONF;

$month_list = array("1"=>"Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");


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
$month_from = $_POST['month_from'] ;
$month_to = $_POST['month_to'] ;
$year = $_POST['year'];

$class_menu_script = $_CONF['site_url'] . '/btp/' . 'class_menu.php';
$print_script = $_CONF['site_url'] . '/btp/' . 'att_print.php';




echo'
<div style="border-bottom: 2px solid rgb(247, 247, 247);" class="yui-g">
	<div class="yui-u first">
	<div class="story-featured"><h1 style="color:green">Class Performance</h1></div>';

	//checking for validity of months range
	if($month_from > $month_to)
	{
		echo '<span class="alert"><strong>Invalid month range.....Please correct it</strong></span>';
		exit;
	}


echo'		<span class="info">
			<ul class="arrow">
						<H2>
				<li>Branch: ' . $branch .'</li>
				<li>Section: ' . $section .'</li>
				<li>Year of Entry: ' . $year_of_entry .'</li>
				<li>Subject Code: ' . $sub_code .'</li>
				<li>Data for the month: ' . $month_list[$month_from] .'  to  '. $month_list[$month_to] . '</li>
				<li>Data for the Year: ' . (($year==0)?' Every year':$year) .'</li>				
				</H2>
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
			<a href="'. $class_menu_script .'">
				<li>View Performance for a different class</li>
			</a>
			</strong></li>
		</ul>

		<!--ul class="bullet-star"><li>
		<strong>
			<a href="'. $att_stats_script .'">
				<li>View overall Statistics of attendance data</li>
			</a>
			</strong></li>
		</ul-->
		<br />

		<form action="'. $_SERVER['PHP_SELF'] .'" method="post">
		<input type="hidden" name="branch" value='. $branch .' />
		<input type="hidden" name="section" value='. $section .' />
		<input type="hidden" name="roll_no" value='. $roll_no .' />
		<input type="hidden" name="year_of_entry" value='. $year_of_entry .' />
		<input type="hidden" name="sub_code" value='. $sub_code .' />
		<input type="hidden" name="month_from" value='. $month_from .' />
		<input type="hidden" name="month_to" value='. $month_to .' />
		<input type="hidden" name="year" value='. $year .' />		
				<ul class="bullet-plus"><li>
		<input type="submit" name="submit" value="Refresh The Result" /></li>
				</ul>		
		</form>
	</div>
</div>';



//*********************retrieval of attendance data from the database********************************

for($i = 0; $i<$no_students; $i++)
{
	$att_roll_percent[$i] = 0;				//stores the number of days for which roll number is present
}

$total_days = 0;


for($j = $month_from; $j<=$month_to; $j++)
{

	$month_percent[$j] = 0;
	unset($date);
	unset($no_present);
	unset($arr_roll);
	unset($arr_name);
	unset($arr_roll_stat);

	calculate_att_day_percent($branch, $section, $year_of_entry, $month_list[$j], $year, $sub_code, $no_students, $date, $no_present, $no_students, $arr_roll, $arr_name, $arr_roll_stat);

	$total_days += count($date);		//total number of classes over the range of month

	//calculating % for every roll number
	for($i = 0; $i<$no_students; $i++)
	{
		$att_roll_percent[$i] += $arr_roll_stat[$i];				//stores the number of days for which roll number is present
		$month_percent[$j]+=$arr_roll_stat[$i];			//stores total number of present student in a month
	}

	$month_percent[$j]= round(floatval($month_percent[$j]/(count($date)*$no_students)),5);

}

for($i = 0; $i<$no_students; $i++)
{
	$att_roll_percent[$i] = round(floatval($att_roll_percent[$i]/$total_days),5);
}



//*************************pie chart for attendance distribution for all given months*************************

unset($data);
for($i=0;$i<$no_students;$i++)
{

	if($att_roll_percent[$i] >= 0.75)	
		$data[3]+=1;
	else if($att_roll_percent[$i]<0.75 && $att_roll_percent[$i] >= 0.5)
		$data[2]+=1;
	else if($att_roll_percent[$i]<0.5 && $att_roll_percent[$i] >= 0.25)
		$data[1]+=1;
	else
		$data[0]+=1;

}



echo'
<br />
<div class="story-featured"><h1><center><i>Distributionof students accpording to their % attendance is</i></center></h1></div>
<br />
';


$data1 = $data[0]."*".$data[1]."*".$data[2]."*".$data[3];
$label = '< 25% attendance *25% to 50% attendance *50% tp 75% attendance *> 75% attendance';

echo'
<ul class="arrow">
<li><H2>Total Number of classes held - '.$total_days.'</H2></li>
<li><H2>Total Number of students in the class - '.$no_students.'</H2></li>
</ul>

<center>
<img src="http://localhost/gl/btp/class-pie.php?data='.$data1.'&label='.$label.'" />
</center>
<br />
<br />';



//************************line graph for attendance distribution for month**************************

$info['title']="% of attendance v/s month";
$info['height']=250;
$info['width']=600;
$label = array("x-axis: month","y-axis: % of present students");

//first column is for graphs
echo '
<div style="border-bottom: 2px solid rgb(247, 247, 247);" class="yui-ge">
	<div class="yui-u first">';

$no_months = ($month_to - $month_from + 1);
$no_points_graph = 5;			//number of points on x-axis in one graph
$max_graphs = (int)( $no_months/ $no_points_graph);
$temp = $no_months % $no_points_graph;

if($temp!=0)
	$max_graphs+=1;		//total number of graphs to be made

//for($i =0;$i<$max_graphs;$i++)
{
	unset($data_l);
	unset($temp);

	for($j=$month_from; $j < $month_to + 1 ; $j++)
	{
	$data_l[$j]=$month_percent[$j]*100;
	}
	$data_l[$j]=0;

	$temp = $data_l;

	$file_temp_name = "temp0.png";

	line_my($info,$temp,$label,$file_temp_name);
	$image_file = $_CONF1['ImageDir'].$file_temp_name;

	echo'
	<img src="'. $image_file .'"/>';

}


echo'
</div>
	<div class="yui-u">	
<span class="down">
<center><strong>x-axis : y-axis values</strong></center>
<ul class="bullet-grey">';

for($i=$month_from;$i<=$month_to;$i++)
{
	echo'<li>('.$i.') '.$month_list[$i] .' : ' . $month_percent[$i]*100 . ' %</li>';
}


echo'
</ul>;
</span>
	</div>
</div>';


//**************************bar graph of student's roll number and their % attendance***************

echo '
<br />
<H1>
<ul class="arrow"><li>
Percentage of attendance for each roll number of students
</li></ul>
</H1>';


$no_bar_graphs = 10;			//number of points on x-axis in one graph
$max_bargraphs = (int)($no_students / $no_bar_graphs);
$temp = $no_students % $no_bar_graphs;
if($temp!=0)
	$max_bargraphs+=1;		//total number of graphs to be made


for($i =0;$i<$max_bargraphs;$i++)
{
	unset($data_l);
	unset($temp);

	for($j=0;$j< $no_bar_graphs && $no_students> $j + $i*$no_bar_graphs ;$j++)
	{
	$data_l["R-".$arr_roll[$i*$no_bar_graphs + $j]]=$att_roll_percent[$i*$no_bar_graphs + $j]*100;
	}

	$temp = $data_l;
	echo'<br /><center>';
	echo draw_my_bar($temp,"Roll number","% of present students");
	echo '</center><br />';

}



//*****************List of students less than 75%**********************

echo'
<div style="border-bottom: 2px solid rgb(247, 247, 247);" class="yui-g">
	<div class="yui-u first">
		<span class="alert">';

echo '<H1>
<ul class="script"><li>
List of Students with attendance less than 75%
</li></ul>
</H1>';

echo '
<ul class="bug">';

//short attendance student's list
$count_short = 0;

for($i=0;$i<$no_students;$i++)
{
	if($att_roll_percent[$i] < 0.75)
	{
		echo'<li>Roll no - '.$arr_roll[$i].' , '. $arr_name[$i].'</li>';
		$count_short+=1;
	}
}

echo'
</ul>
<ul class="arrow"><li><H2>
No. of Students with attendance less than 75% - ' . $count_short . '</H2>
</li></ul>

</div>
</div>	';

$display = COM_siteFooter();
echo $display;

?>