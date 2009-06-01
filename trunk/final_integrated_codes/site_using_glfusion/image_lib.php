<?php

require_once $_SERVER['DOCUMENT_ROOT'] . 'gl/btp/lib-common1.php';
require_once $_CONF1['path'] . 'db.php';

$display =  COM_siteHeader('menu','test');
//echo $display;
//echo $_CONF['site_url'];

	$data = array(10,12,23,44);
	$label = array('ds','dfgdfdfd','sdfsaadasa','gfhdfdsfdsghg');


echo'<H1>this is sheghe</H1>
<img src="http://localhost/gl/btp/extra.php?data=10*9*11*10&label=Denmark*Germany*USA*Sweden" />';


echo'<H2>this is sheghe</H2>
<img src="http://localhost/gl/btp/extra.php" />';

$display = COM_siteFooter();
echo $display;


?>
