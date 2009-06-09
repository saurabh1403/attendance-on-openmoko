<?php

require_once $_SERVER['DOCUMENT_ROOT'] . 'gl/btp/lib-common1.php';

global $_CONF1,$_CONF;

$display =  COM_siteHeader('menu','test');
echo $display;


$att_menu_script = $_CONF['site_url'] . '/btp/' . 'att_menu.php';
$remarks_menu_script = $_CONF['site_url'] . '/btp/' . 'remarks_menu.php';
$class_menu_script= $_CONF['site_url'] . '/btp/' . 'class_menu.php';
$student_menu_script = $_CONF['site_url'] . '/btp/' . 'student_menu.php';
$contact_us_script = $_CONF['site_url'] . '/btp/' . 'contact_us.php';


USES_lib_widgets();

echo WIDGET_moospring();

echo '

<center>
<br>
<div class="story-featured"><h1 style="color:green">View Statistics</h1></div>
<br>
<div id="gl_moospring">
	<ul class="gl_moosprings">
		<li>
			<a class="gl_moospring gl_moospring5" href="'.$class_menu_script.'">
				<span>View attendance</span>
			</a>
		</li>
		<li>
			<a class="gl_moospring gl_moospring6" href="'.$remarks_menu_script.'">
				<span>View remarks</span>
			</a>
		</li>
		<li>
			<a class="gl_moospring gl_moospring7" href="'.$student_menu_script.'">
				<span>view student\'s performance</span>
			</a>
		</li>
		<li>
			<a class="gl_moospring gl_moospring4" href="'.$contact_us_script.'">
				<span>view class performance</span>
			</a>
		</li>
	</ul>
</div>
</center>
<br>';



echo '<H1 style="color:green">
<ul class="arrow">

<a href="'.$att_menu_script.'">
<li>
View student\'s attendance data
</li>
</a>
<br>

<a href="'.$remarks_menu_script.'">
<li>
View Remarks for students
</li>
</a>
<br>

<a href="'.$student_menu_script.'">
<li>
View student\'s performance
</li>
</a>
<br>

<a href="'.$class_menu_script.'">
<li>
View Class performance
</li>
</a>
<br>

</ul>
</H1>
<br>
<br>
';
//<span class="note">Warning: Entering any wrong section or subject code will result in different data. Be careful</span>
$display = COM_siteFooter();
echo $display;

?>
