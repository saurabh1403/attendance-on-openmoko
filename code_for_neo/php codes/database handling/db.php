
<?php

//phpinfo();

$names = array("saurabh","vijay","sunny");

$con = mysql_connect("localhost","root","openmoko");

if (!$con)
{
  	die('Could not connect: ' . mysql_error());
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

function make_table($db_name, $con)
{

	$sql_query=	"CREATE TABLE student_attendance ( roll_number INT NOT NULL AUTO_INCREMENT, name TEXT NOT NULL, PRIMARY KEY(roll_number) )";

	mysql_select_db($db_name, $con);
	
	mysql_query	("FLUSH TABLES");

	if (mysql_query($sql_query))
	{
		echo "Table created";
	}

	else
	{
		echo "Error creating table: " . mysql_error();
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

function show_data($db_name, $con, $table_name)
{
	mysql_select_db($db_name, $con);

	$sql_query="SELECT * FROM ". $table_name;
	$result = mysql_query($sql_query);

	while($row = mysql_fetch_array($result))
	{
	  echo $row['roll_number'] . "\n";
	  echo $row['name'] . "\n";

	}

}


//returns nothing
function execute_query_NR($$db_name, $con, $sql_query)	
{
	
	mysql_select_db($db_name, $con);

	if (mysql_query($sql_query))
	{
		echo "value inserted\n";
		return 1;
	}

	else
	{
		echo "Error executing command: " . mysql_error();
		return -1;
	}

	
}


//returns a single field
function execute_query_single($$db_name, $con, $sql_query)	
{


}


//returns a list with interleaved values
function execute_query_list($$db_name, $con, $sql_query)	
{




}



create_database("my_db", $con);
make_table("my_db",$con);
populate_table("my_db",$con, 3, $names);
show_data("my_db",$con, "student_attendance");

mysql_close($con);

?>


