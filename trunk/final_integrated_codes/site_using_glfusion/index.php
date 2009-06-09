<?php

require_once $_SERVER['DOCUMENT_ROOT'] . 'gl/btp/lib-common1.php';

$display =  COM_siteHeader('menu','test');
//echo $_CONF['site_url'];



USES_lib_widgets();

//call the WIDGET_moorotator function from lib-widgets.php
echo WIDGET_moorotator();
?>


<script type="text/javascript">
	window.addEvent('domready', function() {
		var rotator = new gl_mooRotator('gl_moorotator', {
			controls: true,
			delay: 4000,
			duration: 800,
			autoplay: true
		});
	});
</script>

<?php

global $_CONF1,$_CONF;

echo '
<div id="gl_moorotator">
	<div class="gl_moorotator">
		<div class="gl_moorotatorimage">
			<a href="http://nsit.ac.in" target="_blank">
				<img src="' . $_CONF1['ImageDir'] . 'moorotator1.jpg" alt="Welcome to NSIT" title="Welcome to NSIT" />
			</a>
		</div>
		<div class="gl_moorotatortext">
					<b>Welcome to NSIT!</b>
				<p>
				Know more about NSIT!!
				</p>
		</div>
	</div>

	<div class="gl_moorotator">
		<div class="gl_moorotatorimage">
			<a href="http://nsit.ac.in" target="_blank">
				<img src="' . $_CONF1['ImageDir'] . 'moorotator3.jpg" alt="ECE,NSIT" title="ECE,NSIT" />
			</a>
		</div>
		<div class="gl_moorotatortext">
					<b>Welcome to ECE block</b>
				<p>
				Electronics and Communication Engineering!
				</p>
		</div>
	</div>

	<div class="gl_moorotator">
		<div class="gl_moorotatorimage">
			<a href="'.$_CONF['site_url'] . '/btp/about_daso.php" target="_blank">
				<img src="' . $_CONF1['ImageDir'] . 'moorotator2.jpg" alt="glFusion Mission" title="glFusion Mission" />
			</a>
		</div>
		<div class="gl_moorotatortext">
					<b>Automatic time management</b>
				<p>
				Take attendance and notes at any time!!
				</p>
		</div>
	</div>


	<div class="gl_moorotator">
		<div class="gl_moorotatorimage">
			<a href="http://localhost/wiki/" target="_blank">
				<img src="' . $_CONF1['ImageDir'] . 'moorotator4.jpg" alt="glFusion Mission" title="glFusion Mission" />
			</a>
		</div>
		<div class="gl_moorotatortext">
					<b>Bugs Belong in Nature, not DASO</b>
				<p>
				Features will continue to be added
				</p>
		</div>
	</div>

	<!-- repeat as needed -->
</div>';


?>


<?php

echo WIDGET_moospring();

echo '
<br />
<br />
<center>
<div id="gl_moospring">
	<ul class="gl_moosprings">
		<li>
			<a class="gl_moospring gl_moospring9" href="'.$_CONF['site_url'] . '/btp/view_stats.php">
				<span>Grab It</span>
			</a>
		</li>
		<li>
			<a class="gl_moospring gl_moospring11" href="'.$_CONF['site_url'] . '/btp/work_online.php">
				<span>Grab It</span>
			</a>
		</li>
		<li>
			<a class="gl_moospring gl_moospring2" href="http://localhost/wiki/">
				<span>Say It</span>
			</a>
		</li>
		<li>
			<a class="gl_moospring gl_moospring4" href="'.$_CONF['site_url'] . '/btp/contact_us.php">
				<span>Join Us</span>
			</a>
		</li>
	</ul>
</div>
</center>';

?>




<?php

echo '
<br />
<br />
<br />
<br />
<i><blockquote><center><p>Proper Education is More Important Than Mere Education.........</p></center></blockquote></i>
';

$display = COM_siteFooter();
echo $display;
?>
