<?php


//require_once ('../lib-common.php');
require_once $_SERVER['DOCUMENT_ROOT'] . 'gl/btp/lib-common1.php';
require_once $_SERVER['DOCUMENT_ROOT'] . 'gl/btp/db.php';
//require_once 'db.php';	

global $_CONF1;
$display =  COM_siteHeader('menu','test');
echo $display;


$notes_menu_script = $_CONF['site_url'] . '/btp/' . 'notes_take_menu.php';
$att_take_menu_script = $_CONF['site_url'] . '/btp/' . 'att_take_menu.php';

/*echo '
<H1>
This feature is under construction. It will be soon released.
</H1>';
*/


echo '<H1 style="color:green">
<ul class="arrow">
<br />
<a href="'.$notes_menu_script.'">
<li>
Take notes
</li>
</a>
<br>
<br />
<a href="'.$att_take_menu_script.'">
<li>
Mark attendance
</li>
</a>

</ul>';


//printing of footer of the webpage
$display = COM_siteFooter();
echo $display;


?>