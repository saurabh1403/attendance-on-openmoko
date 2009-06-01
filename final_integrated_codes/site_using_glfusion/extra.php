<?php

require_once $_SERVER['DOCUMENT_ROOT'] . 'gl/btp/lib-common1.php';
//require_once $_CONF1['path'] . 'db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . 'gl/btp/create-histo.php';
require_once $_SERVER['DOCUMENT_ROOT'] . 'gl/btp/create-linegraph.php';

global $_CONF1;
//echo'<H2>this is sheghe</H2>';
$display =  COM_siteHeader('menu','test');
echo $display;
//echo $_CONF['site_url'];
USES_lib_widgets();

echo WIDGET_moospring();

echo '
<center>
<div id="gl_moospring">
	<ul class="gl_moosprings">
		<li>
			<a class="gl_moospring gl_moospring5" href="http://www.glfusion.org/filemgmt/index.php">
				<span>Grab It</span>
			</a>
		</li>
		<li>
			<a class="gl_moospring gl_moospring6" href="http://glfusion.org/wiki/doku.php">
				<span>Grab It</span>
			</a>
		</li>
		<li>
			<a class="gl_moospring gl_moospring3" href="http://www.glfusion.org/forum/">
				<span>Say It</span>
			</a>
		</li>
		<li>
			<a class="gl_moospring gl_moospring4" href="http://www.glfusion.org/wiki/doku.php?id=glfusion:mission">
				<span>Join Us</span>
			</a>
		</li>
	</ul>
</div>
</center>';




$data = array(10,12,23,44);
$label = array('ds','dfgdfdfd','sdfsaadasa','gfhdfdsfdsghg');

$data1='10*54*23*12';

echo'<center><H1>this is sheghe</H1>
<img src="http://localhost/gl/btp/class-pie.php?data='.$data1.'&label=Denmark*Germany*USA*Sweden" /></center>';

//the following lines are working for bar graph
$vals = Array("January" => 25,"February" => 20,"March" => 22,"April" => 23,"May" => 21,"June" => 14,"July" => 21,"August" => 18,"September" => 14,"October" => 12,"November" => 28,"December" => 22);

echo'<center>';
echo draw_my_bar($vals,"date","% of present students");
echo '</center>';

	$info['title']="sunny";
	$info['height']=250;
	$info['width']=750;

	$data = array(0=>10,1=>25);
	$label = array("x-axis: date","y-axis: % of present students");

line_my($info,$data,$label,"temp.png");

$image_file = $_CONF1['ImageDir'].'temp.png';
//$image_file = $_CONF1['path']."images/temp1.png";
echo '<center>';
echo'<H2>this is sheghe</H2>
<img src="'. $image_file .'"/>';


$data = array(0=>67,1=>125,2=>75,3=>12,5=>45,6=>12);
line_my($info,$data,$label,"temp1.png");
$image_file = $_CONF1['ImageDir'].'temp1.png';

echo'<H2>this is another figure</H2>
<img src="'. $image_file .'"/>';
echo '</center>';

echo '<H1>
<ul class="arrow"><li>
List of Students with attendance less than 75%
</li></ul>
</H1>';


$display = COM_siteFooter();
echo $display;

?>