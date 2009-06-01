<?php

require_once $_SERVER['DOCUMENT_ROOT'] . 'gl/btp/lib-common1.php';

global $_CONF1,$_CONF;

$display =  COM_siteHeader('menu','test');
echo $display;

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
</center>
<br>';


$att_menu_script = $_CONF['site_url'] . '/btp/' . 'att_menu.php';

echo '<H1 style="color:green">
<ul class="arrow">

<a href="'.$att_menu_script.'">
<li>
View student\'s attendance data
</li>
</a>
<br>

<a href="http://www.nsit.com">
<li>
View Remarks
</li>
</a>
<br>

<a href="http://www.nsit.com">
<li>
View student\'s performance
</li>
</a>
<br>

<a href="http://www.nsit.com">
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