<?php

require_once $_SERVER['DOCUMENT_ROOT'] . 'gl/btp/lib-common1.php';

$display =  COM_siteHeader('menu','test');
//echo $_CONF['site_url'];


echo '<ul class="arrow"><li>
<blockquote><center><p> Welcome to DASO</p></center></blockquote>
</li></ul>';

USES_lib_widgets();

//call the WIDGET_moorotator function from lib-widgets.php
echo WIDGET_moorotator();
?>


<script type="text/javascript">
	window.addEvent('domready', function() {
		var rotator = new gl_mooRotator('gl_moorotator', {
			controls: true,
			delay: 7000,
			duration: 800,
			autoplay: true
		});
	});
</script>

<?php


echo '
<div id="gl_moorotator">
	<div class="gl_moorotator">
		<div class="gl_moorotatorimage">
			<a href="http://www.glfusion.org/wiki/doku.php?id=glfusion:mission" target="_blank">
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
			<a href="http://www.glfusion.org/wiki/doku.php?id=glfusion:nouveau#custom_header_images" target="_blank">
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
			<a href="http://www.glfusion.org/wiki/doku.php?id=glfusion:language" target="_blank">
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
			<a href="http://tracker.glfusion.org" target="_blank">
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
<center>
<div id="gl_moospring">
	<ul class="gl_moosprings">
		<li>
			<a class="gl_moospring gl_moospring1" href="http://www.glfusion.org/filemgmt/index.php">
				<span>Grab It</span>
			</a>
		</li>
		<li>
			<a class="gl_moospring gl_moospring3" href="http://glfusion.org/wiki/doku.php">
				<span>Grab It</span>
			</a>
		</li>
		<li>
			<a class="gl_moospring gl_moospring2" href="http://www.glfusion.org/forum/">
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

?>

<script type="text/javascript" src="http://localhost/gl-test/javascript/mootools/gl_moorotator-block.js"></script>
<script type="text/javascript">
	window.addEvent('domready', function() {
		var rotator = new gl_mooRotator_block('gl_moorotator_block', {
			controls: false,  //if true, make sure to specify the absolute URL to blankimage var in gl_moorotator-block.js above.
			delay: 4000,
			duration: 800,
			autoplay: true,
			blankimage: 'http://localhost/gl-test/images/speck.gif'
		});
	});
</script>



<script type="text/javascript">
window.addEvent('domready', function() {
//-vertical slide
	var mySlideV = new Fx.Slide('gl_moodrawerV').hide();
		$('toggleV').addEvent('click', function(e){
			e = new Event(e);
			mySlideV.toggle();
			e.stop();
        });
//--horizontal
    var mySlideH = new Fx.Slide('gl_moodrawerH', {mode: 'horizontal'}).hide();
        $('toggleH').addEvent('click', function(e){
            e = new Event(e);
            mySlideH.toggle();
            e.stop();
        });
});
</script>

<div style="width:300px; padding:10px; clear:both;" id="gl_moodrawerV">
<span class="info">Using MooTools, you can place any content you want in drawers!
<p>This is an example of a vertical drawer.</p>
</span>
</div>

<center>
<a href="#" style="float: left;" id="toggleV">Introducing Vertical MooDrawers</a><br />
<a href="#" style="float: left;" id="toggleH">Introducing Horizontal MooDrawers</a><br />
</center>


<div style="width:300px; padding:10px; clear:both;" id="gl_moodrawerH">
<span class="info">Using MooTools, you can place any content you want in drawers!
<p>This is an example of a horizontal drawer.</p>
</span>
</div>













<?php



echo'<img id="gl_moosimplebox_trigger1" src="http://localhost/gl/layout/nouveau/images/pgpkey.png" alt="mooSimpleBox" title="mooSimpleBox"{xhtml}>
<div id="my_gl_moosimpleboxDiv">This is html content in a sample mooSimpleBox</div>';

?>

<script type="text/javascript" src="http://localhost/gl/javascript/mootools/gl_moosimplebox.js"></script>
<script language="javascript" type="text/javascript">
window.addEvent('load',function(){
	var p = new mooSimpleBox({
		width:430,
		height:195,
		btnTitle:'Test',
		closeBtn:'myBtn',
		btnTitle: ' ',
		boxClass:'gl_moosimplebox',
		id:'gl_moosimplebox',
		fadeSpeed:500,
		opacity:'1',
		addContentID:'my_gl_moosimpleboxDiv',
		boxTitle:'My mooSimpleBox Title',
		isDrag:'false'
	});
	$('gl_moosimplebox_trigger1').addEvent('click',function(e){
		e = new Event(e).stop();
		p.fadeIn();
	})
})
</script>






<?php
//USES_lib_widgets();	

/*
echo'

<div id="gl_moorotator_block">
	<div class="gl_moorotator_block">
		<div class="gl_moorotatorimage_block">
			<a href="http://www.glfusion.org/wiki/doku.php?id=glfusion:start" target="_blank">
				<img alt="Documentation Wiki" title="Documentation Wiki" src="http://localhost/gl-test/images/library/Image/moorotatorblock1.jpg" />
			</a>
		</div>
		<div class="gl_moorotatortext_block">&nbsp;</div>
	</div>

	<div class="gl_moorotator_block">
		<div class="gl_moorotatorimage_block">
			<a href="http://www.glfusion.org/wiki/doku.php?id=roadmap" target="_blank">
				<img alt="glFusion Roadmap" title="glFusion Roadmap" src="http://localhost/gl-test/images/library/Image/moorotatorblock2.jpg" />
			</a>
		</div>
		<div class="gl_moorotatortext_block">&nbsp;</div>
	</div>

	<div class="gl_moorotator_block">
		<div class="gl_moorotatorimage_block">
			<a href="http://www.glfusion.org/wiki/doku.php?id=glfusion:mission" target="_blank">
				<img alt="Join Us" title="Join Us" src="http://localhost/gl-test/images/library/Image/moorotatorblock4.jpg" />
			</a>
		</div>
		<div class="gl_moorotatortext_block">&nbsp;</div>
	</div>

<!-- repeat as needed -->
</div>';
*/

// add your static page IDs, order here is order they appear on the mooslide tabs
//$slides = Array('mooslide_whatsnew', 'mooslide_cachetech', 'mooslide_integratedplugins', 'mooslide_mootools', 'mooslide_widgets');
 
//call the WIDGET_mooslide function from lib-widgets.php
// last 3 options below are width, height, and css id
//return WIDGET_mooslide($slides, 560, 160, 'gl_slide');

//echo '<img id="gl_moosimplebox_trigger1" src="http://192.168.1.2/gl-test/layout/nouveau/images/pgpkey.png" alt="mooSimpleBox" title="mooSimpleBox"{xhtml}>';

$display = COM_siteFooter();
echo $display;
?>
