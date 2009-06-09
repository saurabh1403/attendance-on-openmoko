<?php


//require_once ('../lib-common.php');
require_once $_SERVER['DOCUMENT_ROOT'] . 'gl/btp/lib-common1.php';
require_once $_SERVER['DOCUMENT_ROOT'] . 'gl/btp/db.php';
//require_once 'db.php';	

global $_CONF1;
$display =  COM_siteHeader('menu','test');
echo $display;

echo '
<span class="note">
<H1>
This page can be viewed when you are logged in as administrator
</H1>
</span>';

//printing of footer of the webpage
$display = COM_siteFooter();
echo $display;


?>