<?php

//require_once ('../lib-common.php');
require_once $_SERVER['DOCUMENT_ROOT'] . 'gl/btp/lib-common1.php';
require_once $_SERVER['DOCUMENT_ROOT'] . 'gl/btp/db.php';
//require_once 'db.php';	

global $_CONF1;
$display =  COM_siteHeader('menu','test');
echo $display;
?>

<html> 
	<head> 
	    <!-- Source File --> 
	    <link rel="stylesheet" type="text/css" href="reset-fonts-grids.css"> 
	</head> 
	<body> 

	<div style="border-bottom: 2px solid rgb(247, 247, 247);" class="yui-gc">

<div class="yui-u first">
<span class="alert">Create it with the following html:<br />
<strong>&lt;span class=&quot;alert&quot;&gt;....&lt;/span&gt;</strong></span> 
<span class="info">Create it with the following html:<br />
<strong>&lt;span class=&quot;info&quot;&gt;....&lt;/span&gt;</strong></span> 
<span class="down">Create it with the following html:<br />
<strong>&lt;span class=&quot;down&quot;&gt;....&lt;/span&gt;</strong></span>
</div>


<div class="yui-u"><span class="note">Create it with the following html:<br />
<strong>&lt;span class=&quot;note&quot;&gt;....&lt;/span&gt;</strong></span> <span class="idea">Create it with the following html:<br />
<strong>&lt;span class=&quot;idea&quot;&gt;....&lt;/span&gt;</strong></span> <span class="help">Create it with the following html:<br />

<strong>&lt;span class=&quot;help&quot;&gt;...&gt;&lt;/span&gt;</strong></span></div>


</div>
	</body> 
</html> 

<?php
$display = COM_siteFooter();
echo $display;

?>