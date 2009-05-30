<?php

//load the whole schema and create the database and update it with initial names
require_once $_SERVER['DOCUMENT_ROOT'] . 'gl/btp/lib-common1.php';

require_once $_CONF1['path'] . 'schema_database.php';
require_once $_CONF1['path'] . 'db.php';

function install_DASO()
{
	global $_DB1,$_CONF1, $_FILE_NAMES, $_SCHEMA;

	//connecting to mysql database
	connect_database($con);
	mysql_select_db($_DB1['name'], $con);

	//***********************creating table ODASI************************
	$sql_query=	"DROP table " . $_DB1['table_prefix'] . "ODASI";	
	execute_query_NR($_DB1['name'],$con,$sql_query);	

	$sql_query = "CREATE TABLE " . $_DB1['table_prefix'] . "ODASI(" . $_SCHEMA['ODASI'];	
	execute_query_NR($_DB1['name'],$con,$sql_query);	

	//********************updating table ODASI and creating tables for names, attendance and notes***************************
	$class_list = $_CONF1['DataDir'] . $_FILE_NAMES['class_list'];
	file_read_linewise($class_list, $class_names, $no_items);

	for($i = 0; $i < $no_items; $i++)
	{
		list($info['Branch'],$info['Section'],$info['Year']) = split('_',$class_names[$i]);
		$info['name_file']  =  $_DB1['table_prefix'] . "names_" . $class_names[$i];
		$info['attendance_file']  =  $_DB1['table_prefix'] . "att_" . $class_names[$i];
		$info['notes_file']  =  $_DB1['table_prefix'] . "notes_" . $class_names[$i];

		$sql_query  = "INSERT INTO " . $_DB1['table_prefix']. "ODASI (Branch, Section, Year, name_file, attendance_file, notes_file) VALUES('". $info['Branch']. "', '" . $info['Section']. "', '" . $info['Year']. "', '" . $info['name_file']. "', '" . $info['attendance_file']. "', '" . $info['notes_file']. "')";
		execute_query_NR($_DB1['name'],$con,$sql_query);	

		create_class_names($_DB1['name'],$con, $info['name_file']);

		$class_names_file = $_CONF1['DataDir'] . $class_names[$i].".txt";

		read_file_names($class_names_file,$names,$roll_no,$no_students);

//		print_r($names);

//		file_read_linewise($class_names_file, $names,$no_students);
//		$roll_no = range(1,$no_students);
		update_class_names($_DB1['name'],$con, $info['name_file'], $roll_no, $names);

		create_attendance_table($_DB1['name'],$con,$info['attendance_file'],$info['name_file']);
		create_notes_table($_DB1['name'],$con,$info['notes_file'],$info['name_file']);

	}
}


function uninstall_DASO()
{
	global $_DB1,$_CONF1, $_FILE_NAMES, $_SCHEMA;

	//connecting to mysql database
	connect_database($con);
	mysql_select_db($_DB1['name'], $con);

	//***********************creating table ODASI************************
	$sql_query=	"DROP table " . $_DB1['table_prefix'] . "ODASI";	
	execute_query_NR($_DB1['name'],$con,$sql_query);	

	//********************updating table ODASI and creating tables for names, attendance and notes***************************
	$class_list = $_CONF1['DataDir'] . $_FILE_NAMES['class_list'];
	file_read_linewise($class_list, $class_names, $no_items);

	for($i = 0; $i < $no_items; $i++)
	{
		list($info['Branch'],$info['Section'],$info['Year']) = split('_',$class_names[$i]);
		$info['name_file']  =  $_DB1['table_prefix'] . "names_" . $class_names[$i];
		$info['attendance_file']  =  $_DB1['table_prefix'] . "att_" . $class_names[$i];
		$info['notes_file']  =  $_DB1['table_prefix'] . "notes_" . $class_names[$i];

		$sql_query=	"DROP table " . $info['name_file'];
		execute_query_NR($_DB1['name'],$con,$sql_query);	
		echo "table dropped";

		$sql_query=	"DROP table " . $info['attendance_file'];
		execute_query_NR($_DB1['name'],$con,$sql_query);	

		$sql_query=	"DROP table " . $info['notes_file'];
		execute_query_NR($_DB1['name'],$con,$sql_query);
	}

}

install_DASO();

echo "\n\n\n Installation Successful\n\n";
echo "\n". $_CONF['site_url'];


?>
