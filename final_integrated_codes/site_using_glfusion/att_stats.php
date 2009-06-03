<?php

require_once $_SERVER['DOCUMENT_ROOT'] . 'gl/btp/lib-common1.php';
require_once $_CONF1['path'] . 'db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . 'gl/btp/create-histo.php';
require_once $_SERVER['DOCUMENT_ROOT'] . 'gl/btp/create-linegraph.php';

global $_CONF1;
//echo'<H2>this is sheghe</H2>';
$display =  COM_siteHeader('menu','test');
echo $display;
//echo $_CONF['site_url'];


$branch = $_GET["branch"];
$section = $_GET["section"];
$year_of_entry = $_GET['year'];
$sub_code = $_GET['sub_code'];
$month = $_GET['month'];

/*
echo'
<br />
<center><blockquote><p>This page shows all the statistics of attendance of students for a class for a particular month</p></blockquote></center>
<br />
';

*/

echo'
<div style="border-bottom: 2px solid rgb(247, 247, 247);" class="yui-g">
	<div class="yui-u first">
	<div class="story-featured"><h1 style="color:green">Attendance Statistics</h1></div>
		<span class="info">
			<!--H2>
				<center><strong>Attendance Statistics</strong>
				</center>
			</H2-->
						<H2>
			<ul class="arrow">
				<li>Branch :  ' . $branch .'</li>
				<li>Section :  ' . $section .'</li>
				<li>Year of Entry :  ' . $year_of_entry .'</li>
				<li>Subject Code :  ' . $sub_code .'</li>
				<li>Data for the month :  ' . $month .'</li>
			</ul>
						</H2>
			<br />
		</span> 
	</div>';

$print_script = $_CONF['site_url'] . '/btp/' . 'att_print.php';
$self_script = $_SERVER['PHP_SELF'];
$self_script.="?branch=".$branch."&section=".$section."&year=".$year_of_entry."&sub_code=".$sub_code."&month=".$month;
$class_stats_script = $_CONF['site_url'] . '/btp/' . 'class_menu.php';
$att_menu_script = $_CONF['site_url'] . '/btp/' . 'att_menu.php';

echo'	<div class="yui-u">	
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
			<a href="'. $att_menu_script .'">
				<li>View Attendance data for a different month</li>
			</a>
			</strong></li>
		</ul>
		<br />
		
		
		<ul class="bullet-star"><li>
		<strong>
			<a href="'. $class_stats_script .'">
				<li>View class performance over a semester</li>
			</a>
			</strong></li>
		</ul>
		<br />

		<ul class="bullet-plus"><li>
		<strong>
			<a href="'. $self_script .'">
				<li>Refresh the Result</li>
			</a>
			</strong></li>
		</ul>
		<br />

	</div>
</div>';




//*********************retrieval of attendance data from the database********************************
calculate_att_day_percent($branch, $section, $year_of_entry, $month, $year, $sub_code, $no_students, $date, $no_present, $no_students, $arr_roll, $arr_name, $arr_roll_stat);

$data = array(0,0,0,0);

for($i=0;$i<count($date);$i++)
{
	$att_percent[$i] = (float)($no_present[$i]/$no_students);

	if($att_percent[$i] >= 0.75)	
		$data[3]+=1;
	else if($att_percent[$i]<0.75 && $att_percent[$i] >= 0.5)
		$data[2]+=1;
	else if($att_percent[$i]<0.5 && $att_percent[$i] >= 0.25)
		$data[1]+=1;
	else
		$data[0]+=1;

}

//print_r($no_present);
//print_r($day_date);



//*************************pie chart for attendance distribution for days*************************

echo'
<br />
<div class="story-featured"><h1><center><i>Number of Classes when the attendance distribution in % is</i></center></h1></div>
<br />
';


$data1 = $data[0]."*".$data[1]."*".$data[2]."*".$data[3];
$label = '< 25% attendance *25% to 50% attendance *50% tp 75% attendance *> 75% attendance';

echo'
<ul class="arrow">
<li><H2>Total Number of classes held - '.count($date).'</H2></li>
<li><H2>Total Number of students in the class - '.$no_students.'</H2></li>
</ul>

<center>
<img src="http://localhost/gl/btp/class-pie.php?data='.$data1.'&label='.$label.'" />
</center>
<br />
<br />';




//************************line graph for attendance distribution for days**************************

$info['title']="% of present students v/s date";
$info['height']=250;
$info['width']=600;
$label = array("x-axis: date","y-axis: % of present students");

//first column is for graphs
echo '
<div style="border-bottom: 2px solid rgb(247, 247, 247);" class="yui-ge">
	<div class="yui-u first">';


$no_points_graph = 10;			//number of points on x-axis in one graph
$max_graphs = (int)(count($date) / $no_points_graph);
$temp = count($date) % $no_points_graph;
if($temp!=0)
	$max_graphs+=1;		//total number of graphs to be made

for($i =0;$i<$max_graphs;$i++)
{
//	$temp1=0;
	unset($data_l);
	unset($temp);

	for($j=0;$j< $no_points_graph && count($date)> $j + $i*$no_points_graph ;$j++)
	{
//	$data_l[$i][$i*$no_points_graph + $j+1]=$att_percent[$i*$no_points_graph + $j]*100;
	$data_l[$i*$no_points_graph + $j+1]=$att_percent[$i*$no_points_graph + $j]*100;
	}

	for(;$j<$no_points_graph;$j++)
	{
//		$data_l[$i][$i*$no_points_graph + $j+1]=$att_percent[$i*$no_points_graph + $j]*100;
		$data_l[$i*$no_points_graph + $j+1]=$att_percent[$i*$no_points_graph + $j]*100;
	}

//	$temp = $data_l[$i];
	$temp = $data_l;
//	print_r($temp);

	$file_temp_name = "temp".$i.".png";

	line_my($info,$temp,$label,$file_temp_name);
	$image_file = $_CONF1['ImageDir'].$file_temp_name;

	echo'
	<img src="'. $image_file .'"/>';

}


echo'
</div>
	<div class="yui-u">	
<span class="down">
<center><strong>x-axis values</strong></center>
<ul class="bullet-grey">';

for($i=1;$i<=count($date);$i++)
{
	echo'<li>'.$i.' - '.$date[$i-1] .'</li>';
}


echo'
</ul>;
</span>
	</div>
</div>';


//****************************pie chart for student's performance**************************

echo'
<br />
<br />
<div class="story-featured"><h1><center><i>Number of students according to their attendance % is</i></center></h1></div>
<br />
';


unset($data);
$total_days = count($date);
for($i=0;$i<$no_students;$i++)
{
	$att_roll_percent[$i] = round((float)($arr_roll_stat[$i]/$total_days),4);

	if($att_roll_percent[$i] >= 0.75)	
		$data[3]+=1;
	else if($att_roll_percent[$i]<0.75 && $att_roll_percent[$i] >= 0.5)
		$data[2]+=1;
	else if($att_roll_percent[$i]<0.5 && $att_roll_percent[$i] >= 0.25)
		$data[1]+=1;
	else
		$data[0]+=1;
}


$data1 = $data[0]."*".$data[1]."*".$data[2]."*".$data[3];
$label = '< 25% attendance *25% to 50% attendance *50% tp 75% attendance *> 75% attendance';

echo'
<ul class="arrow">
<li><H2>Total Number of Classes held - '.count($date).'</H2></li>
<li><H2>Total Number of students in the class - '.$no_students.'</H2></li>
</ul>

<center>
<img src="http://localhost/gl/btp/class-pie.php?data='.$data1.'&label='.$label.'" />
</center>
<br />
<br />';



//**************************bar graph of student's roll number and their %***************

echo '<H1>
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