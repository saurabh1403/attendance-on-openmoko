<?php

//if (strpos(strtolower($_SERVER['PHP_SELF']), 'siteconfig.php') !== false) {
//    die('This file can not be used on its own!');
//}

//echo "\nfor siteconfig" . $_SERVER['DOCUMENT_ROOT'] . "\n\n";

global $_CONF1;

// To disable your site quickly, simply set this flag to false
$_CONF1['site_enabled'] = true;
//$_CONF1['path'] = '/var/www/gl/btp/';				//for use of php..should be absolute path
$_CONF1['path'] = $_SERVER['DOCUMENT_ROOT'] . 'gl/btp/';				//for use of php..should be absolute path
$_CONF1['path_system'] = $_CONF1['path'] . 'system/';
$_CONF1['default_charset'] = 'utf-8';

//as images are used in html and javascript, hence site URL is used and not $_CONF1['path']

require_once $_CONF1['path']. '../lib-common.php';
$_CONF1['ImageDir'] = $_CONF['site_url'] . '/btp/' . 'images/';			


//for use in php for storing of files and other local data
$_CONF1['DataDir'] = $_CONF1['path'] . 'data/';
$_CONF1['LogDir'] = $_CONF1['path'] . 'logs/';
$_CONF1['LocalDir'] = $_CONF1['path'] . 'local_dir/';


global $_DB1;
global $_DB_host, $_DB_name, $_DB_user, $_DB_pass, $_DB_table_prefix, $_DB_dbms;
/*
$_DB1['host'] = 'localhost';
$_DB1['name'] = 'glfusion';
$_DB1['user'] = 'root';
$_DB1['pass'] = 'openmoko';
$_DB1['table_prefix'] = 'gl_btp_';
$_DB1['dbms'] = 'mysql';
*/

$_DB1['host'] = $_DB_host;
$_DB1['name'] = $_DB_name;
$_DB1['user'] = $_DB_user;
$_DB1['pass'] = $_DB_pass;
$_DB1['table_prefix'] = 'gl_btp_';
$_DB1['dbms'] = $_DB_dbms;

global $_FILE_NAMES;

$_FILE_NAMES['class_list'] = 'class_list.txt';

?>
