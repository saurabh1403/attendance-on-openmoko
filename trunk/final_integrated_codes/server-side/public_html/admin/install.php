

<?php

//load the whole schema and create the database and update it with initial names

require_once '../lib-common.php';
require_once $_CONF['path'] . 'db.php';
require_once $_CONF['path'] . 'schema_database.php';


function install_DASO()
{
	global $_DB,$_CONF, $_FILE_NAMES, $_SCHEMA;

	//connecting to mysql database
	connect_database($con);
	mysql_select_db($_DB['name'], $con);

	//***********************creating table ODASI************************
	$sql_query=	"DROP table " . $_DB['table_prefix'] . "ODASI";	
	execute_query_NR($_DB['name'],$con,$sql_query);	

	$sql_query = "CREATE TABLE " . $_DB['table_prefix'] . "ODASI(" . $_SCHEMA['ODASI'];	
	execute_query_NR($_DB['name'],$con,$sql_query);	


	//********************updating table ODASI and creating tables for names, attendance and notes***************************
	$class_list = $_CONF['DataDir'] . $_FILE_NAMES['class_list'];
	file_read_linewise($class_list, $class_names, $no_items);

	for($i = 0; $i < $no_items; $i++)
	{
		list($info['Branch'],$info['SubjectCode'],$info['Section'],$info['Year']) = split('_',$class_names[$i]);
		$info['name_file']  =  $_DB['table_prefix'] . "names_" . $class_names[$i];
		$info['attendance_file']  =  $_DB['table_prefix'] . "att_" . $class_names[$i];
		$info['notes_file']  =  $_DB['table_prefix'] . "notes_" . $class_names[$i];
		$sql_query  = "INSERT INTO " . $_DB['table_prefix']. "ODASI (Branch, Section, Year, name_file, attendance_file, notes_file) VALUES('". $info['Branch']. "', '" . $info['Section']. "', '" . $info['Year']. "', '" . $info['name_file']. "', '" . $info['attendance_file']. "', '" . $info['notes_file']. "')";
		execute_query_NR($_DB['name'],$con,$sql_query);	

		create_class_names($_DB['name'],$con, $info['name_file']);

		$class_names_file = $_CONF['DataDir'] . $class_names[$i].".txt";
		file_read_linewise($class_names_file, $names,$no_students);
		$roll_no = range(1,$no_students);
		update_class_names($_DB['name'],$con, $info['name_file'], $roll_no, $names);
		
		create_attendance_table($_DB['name'],$con,$info['attendance_file'],$info['name_file']);
		create_notes_table($_DB['name'],$con,$info['notes_file'],$info['name_file']);

	}


}


install_DASO();



?>
