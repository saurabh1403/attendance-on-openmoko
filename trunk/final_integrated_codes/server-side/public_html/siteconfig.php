<?php

if (strpos(strtolower($_SERVER['PHP_SELF']), 'siteconfig.php') !== false) {
    die('This file can not be used on its own!');
}

global $_CONF;

// To disable your site quickly, simply set this flag to false
$_CONF['site_enabled'] = true;
$_CONF['path'] = './';
$_CONF['path_system'] = $_CONF['path'] . 'system/';
$_CONF['default_charset'] = 'utf-8';
$_CONF['ImageDir'] = $_CONF['path'] . 'images/';
$_CONF['DataDir'] = $_CONF['path'] . 'data/';
$_CONF['LogDir'] = $_CONF['path'] . 'log/';
$_CONF['LocalDir'] = $_CONF['path'] . 'local_dir/';


global $_DB;

$_DB['host'] = 'localhost';
$_DB['name'] = 'my_db1';
$_DB['user'] = 'root';
$_DB['pass'] = 'openmoko';
$_DB['table_prefix'] = 'gl_';
$_DB['dbms'] = 'mysql';

?>


