
<?php


require_once 'lib-common.php';	
require_once $_CONF['path'] . 'schema_database.php';

define("DB_NAME","my_db1");




function connect_database(&$con)
{
	
	global $_DB;
	$con = mysql_connect($_DB['host'],$_DB['user'],$_DB['pass']);

	if (!$con)
	{
//		die('Could not connect: ' . mysql_error());
		return -1;
	}
	return 1;
}



function create_database($db_name, $con)
{
	$sql_query=	"CREATE DATABASE ". $db_name;
	if (mysql_query($sql_query,$con))
	{
		echo $db_name ."Database created";
	}

	else
	{
		echo "Error creating database: " . mysql_error();
	}
}




//create a class information having roll numbers and names of the student
function create_class_names($db_name, $con, $class_name)
{

	$sql_query=	"DROP table " . $class_name;
	execute_query_NR($_DB['name'],$con,$sql_query);	

	$sql_query=	"CREATE TABLE  $class_name (roll_number INT NOT NULL AUTO_INCREMENT, name TEXT NOT NULL, PRIMARY KEY(roll_number) )";

	mysql_select_db($db_name, $con);

	mysql_query	("FLUSH TABLES");

	if (mysql_query($sql_query))
	{
		echo "Class created";
	}

	else
	{
		echo "Error creating table: " . mysql_error();
	}

}


/*
 * 
 * name: update_class_names
 * @param
 * @return
 */
function update_class_names($db_name, $con, $class_name, $roll, $names)
{

	$i = 0;
	
	$no_students = count($roll);

	while($i<$no_students)
	{
		$sql_query = "INSERT INTO " . $class_name . " VALUES('" . $roll[$i] . "', '" . $names[$i] . "')";
		execute_query_NR($db_name, $con, $sql_query);
		$i++;
	}

}


//creates an attendance table for storing the attendance data of a class
/*
 * 
 * name: unknown
 * @param $table_name: name of the table to be created
 * @param $class_name: name of the class file name where all the names are stored
 * @return
 */
function create_attendance_table($db_name, $con, $table_name, $class_name)
{

	mysql_select_db($db_name, $con);
	
	$sql_query=	"DROP table " . $table_name;
	execute_query_NR($_DB['name'],$con,$sql_query);	


	global $_SCHEMA;

	$sql_query = "SELECT * from $class_name";

	$result = mysql_query($sql_query);

	$sql_query = "CREATE TABLE ". $table_name ."(". $_SCHEMA['attendance']  ;

	while($row  = mysql_fetch_array($result))
	{
//		$sql_query.= ", ". $row['name'] . "  varchar(5) DEFAULT 'A'";
		$sql_query.= ", ". "roll_". $row['roll_number']. "  varchar(5) ";
	}

	$sql_query.= ", ". $_SCHEMA['attendance_key'] . ")";

	if (mysql_query($sql_query))
	{
		echo "attendance table for class $table_name created \n";
	}

	else
	{
		echo "Error creating table: " . mysql_error();
	}

}


function update_database($info, $attendance)
{
	global $_DB;

	connect_database($con);

	update_attendance_table($_DB['name'], $con, $info['ClassName'],$info, $attendance);

	mysql_close($con);

}


//update an attendance for a class in the corresponding table
function update_attendance_table($db_name, $con, $table_name, $info_array, $attendance)
{

	global $_DB;

	print_r($info_array);
	$sql_query = "SELECT attendance_file from " . $_DB['table_prefix'] . "ODASI where Branch = '". $info_array['Branch'] . "' and Section = '". $info_array['Section']. "' and Year = '". $info_array['EntryYear'] . "'";
	echo "\nquery is $sql_query\n";
	$i = execute_query_single($db_name,$con,$sql_query, &$table_name);

	echo "\n\ntable name is $i \t $table_name\n";

	$sql_query  = "INSERT INTO $table_name values('". $info_array['TeacherName']. "', '" . $info_array['SubjectCode']. "', '" . $info_array['OpenmokoID']. "', '" . $info_array['Date']. "', '" . $info_array['Month']. "', '" . $info_array['Year']. "', '" . $info_array['Time'] . "', '" . $info_array['TimeStamp']."'";

//	echo "\n month is \t".$info_array['Month']."\n\n";
	$i=0;

	$no_students = count($attendance);

	echo $no_students;

	while($i<$no_students)
	{
		$sql_query.=", ' $attendance[$i]' ";
		$i++;
	}

	$sql_query.=")";
//	echo $sql_query;

	return execute_query_NR($db_name, $con, $sql_query);

}


function create_notes_table($db_name, $con, $table_name, $class_name)
{

	mysql_select_db($db_name, $con);

	$sql_query=	"DROP table " . $table_name;
	execute_query_NR($_DB['name'],$con,$sql_query);	

	global $_SCHEMA;

	$sql_query = "SELECT * from $class_name";

	$result = mysql_query($sql_query);

	$sql_query = "CREATE TABLE ". $table_name ."(". $_SCHEMA['attendance']  ;

	while($row  = mysql_fetch_array($result))
	{
//		$sql_query.= ", ". $row['name'] . "  varchar(5) DEFAULT 'A'";
		$sql_query.= ", ". "roll_". $row['roll_number']. "  TEXT ";
	}

	$sql_query.= ", ". $_SCHEMA['attendance_key'] . ")";

	if (mysql_query($sql_query))
	{
		echo "attendance table for class $table_name created \n";
	}

	else
	{
		echo "Error creating table: " . mysql_error();
	}

}




function create_ODASI_table($db_name, $con)
{
	global $_SCHEMA;
	return execute_query_NR($db_name, $con, $_SCHEMA['ODASI']);

}


function update_ODASI_table($db_name, $con, $info_array)
{
	$sql_query  = "INSERT INTO " . $_DB['table_prefix'] . "ODASI values('". $info_array['Branch']. "', '" . $info_array['Section']. "', '" . $info_array['Year']. "', '" . $info_array['name_file']. "', '" . $info_array['attendance_file']. "')";
	return execute_query_NR($db_name, $con, $sql_query);

}


/*
 * 
 * name: retrieve_attendance_data
 * @param
 * @return
 */
function retrieve_attendance_data($branch, $section, $year, $month, $subject_code, $no_students, $time_stamp, $attend_stats, $student_names, $students_roll_no)
{

	global $_DB;
	$db_name = $_DB['name'];
	connect_database($con);

	$sql_query = "SELECT name_file, attendance_file from ". $_DB['table_prefix'] . "ODASI where Branch = '". $branch . "' and Section = '". $section. "' and Year = '". $year . "'";

	execute_query_list($db_name, $con, $sql_query, &$no_rows, &$no_col, &$file_names);

	if($no_col == 2 && $no_rows ==1)
	{

		$attend_file_name = $file_names[0][1];
		$name_file = $file_names[0][0];

		$sql_query = "SELECT * from ". $name_file;
		execute_query_list($db_name, $con, $sql_query, &$no_rows, &$no_col, &$names_list);

		for($i = 0;$i<$no_rows;$i++)
		{
			$student_names[$i] = $names_list[$i][1];
			$students_roll_no[$i] = $names_list[$i][0];
		}

		mysql_select_db($db_name, $con);
		$sql_query = "SELECT * from ". $attend_file_name . " where SubjectCode = '". $subject_code . "' and Month = '" . $month . "'";

		$result = mysql_query($sql_query);

		$no_col =mysql_num_fields($result) ;
		$no_rows = mysql_num_rows($result);

		$no_students = $no_col -8;

		$row_no = 0;

		while($row = mysql_fetch_array($result))
		{
			$time_stamp[] = $row['TimeStamp'];

			for($i = 8; $i<$no_col; $i++)
			{
				$attend_stats[$row_no][$i-8]= $row[$i];
			}

			$row_no++;

		}

		mysql_free_result($result);
		mysql_close($con);
		
		return 1;
	
	}

	else
	{
		mysql_close($con);
		return -1;
	}

}

/*
 * name: execute_query_NR
 * @param $db_name: name of the database to be selected
 * @param $con: handler for MY_SQL connection
 * @param $sql_query: sql query in the form of string to be executed
 * @return : 1 on success and -1 on failure
 */
function execute_query_NR($db_name, $con, $sql_query)
{

	mysql_select_db($db_name, $con);

	if (mysql_query($sql_query))
	{
		echo "query executed\n";
		return 1;
	}

	else
	{
		echo "Error executing command: " . mysql_error();
		return -1;
	}

}


/*
 * name: execute_query_list
 * @param $db_name: name of the database to be selected
 * @param $con: handler for MY_SQL connection
 * @param $sql_query: sql query in the form of string to be executed
 * @return : 1 on success and -1 on failure
 */
function execute_query_list($db_name, $con, $sql_query,  $no_rows, $no_col, $op)	
{

	mysql_select_db($db_name, $con);

	$result = mysql_query($sql_query);

	$no_col =(mysql_num_fields($result)) ;
	$no_rows = mysql_num_rows($result);

	while($row = mysql_fetch_row($result))		//$row contains an array of full fetched row
	{
		$op[] = $row;							//$op is a 2-D array
	}

	mysql_free_result($result);

}


/*
 * name: execute_query_single
 * @param $db_name: name of the database to be selected
 * @param $con: handler for MY_SQL connection
 * @param $sql_query: sql query in the form of string to be executed
 * @return : 1 on success and -1 on failure
 */
function execute_query_single($db_name, $con, $sql_query, $op)	
{

	mysql_select_db($db_name, $con);
	
	if ($result = mysql_query($sql_query))
	{
		echo "query executed\n";
		$row = mysql_fetch_array($result);
		$op = $row[0];
		echo "\nrsult is $op\n\n";
		return 1;
	}

	else
	{
		echo "Error executing command: " . mysql_error();
		return -1;
	}

}


function populate_table ($db_name, $con, $no_students, $names1)
{
	mysql_select_db($db_name, $con);

	$i;

	$sql_query="INSERT INTO student_attendance (name) values('";

	for($i = 0;$i<$no_students;$i++)
	{
		if($i!=0)
			$sql_query = $sql_query. "'),('";

		$sql_query = $sql_query. $names1[$i];
	}

	$sql_query = $sql_query."')";

	echo $sql_query."\n";

	if (mysql_query($sql_query))
	{
		echo "value inserted\n";
	}

	else
	{
		echo "Error inserting value: " . mysql_error();
	}

}


?>
