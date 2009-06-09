<?php

require_once $_SERVER['DOCUMENT_ROOT'] . 'gl/btp/lib-common1.php';

$display =  COM_siteHeader('menu','test');
//echo $_CONF['site_url'];

// this staticpage needs to have PHP set to execute PHP (return) below
// use lib-widgets.php
USES_lib_widgets();

// add your staticpage IDs, order here is order they appear on the mooslide tabs
$slides = Array('mooslide_whatsnew', 'mooslide_cachetech', 'mooslide_integratedplugins', 'mooslide_widgets');

//call the WIDGET_mooslide function from lib-widgets.php
// last 3 options below are width, height, and css id
echo WIDGET_mooslide($slides, 560, 160, 'gl_slide');


$display = COM_siteFooter();
echo $display;
?>