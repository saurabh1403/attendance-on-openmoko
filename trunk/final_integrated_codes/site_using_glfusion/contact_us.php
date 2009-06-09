<?php

//require_once ('../lib-common.php');
require_once $_SERVER['DOCUMENT_ROOT'] . 'gl/btp/lib-common1.php';
require_once $_SERVER['DOCUMENT_ROOT'] . 'gl/btp/db.php';
//require_once 'db.php';	

global $_CONF1;
$display =  COM_siteHeader('menu','test');
echo $display;

echo'

<div style="border-bottom: 2px solid rgb(247, 247, 247);" class="yui-g">

<div class="yui-u first">

<span class="idea">
<H1>
Project Guide
</H1>
<ul class="">
<li>
Name: Mr. Dhananjay V. Gadre
</li>
<li>
Email ID: dvgadre@gmail.com
</li></ul>
</span>

<span class="info">
<H1>
Project Developer
</H1>
<ul class="">
<li>
Name: Saurabh Gupta
</li>
<li>
Email ID: saurabhgupta1403@gmail.com
</li></ul>
</span>

<span class="info">
<H1>
Project Developer
</H1>
<ul class="">
<li>
Name: Vijay Majumdar
</li>
<li>
Email ID: majumdar.vijay@gmail.com
</li></ul>
</span>

</div>
</div>
';


echo'
<br />
<br />
<blockquote><p>New ideas and developers are always welcome. Contact any one above for joining this project</p></blockquote>

';



//printing of footer of the webpage
$display = COM_siteFooter();
echo $display;


?>