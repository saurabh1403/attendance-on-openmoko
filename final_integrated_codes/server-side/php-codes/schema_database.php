
<?php

//this file contains the whole schema of the database structure for DASO (Data acquisition system on Openmoko)

$_SCHEMA['attendance'] = "
			TeacherName varchar(20) NOT NULL, 
			SubjectCode varchar(20) NOT NULL,
			OpenmokoID varchar(20) NOT NULL, 
			Date INT NOT NULL,
			Month INT NOT NULL,
			Year INT NOT NULL,
			Time varchar(20) NOT NULL,
			TimeStamp varchar(20) NOT NULL";


$_SCHEMA['attendance_key'] = "
			PRIMARY KEY (TeacherName,Time,OpenmokoID)";


$_SCHEMA['ODASI'] = "
			CREATE TABLE ODASI(
			Branch varchar(20) NOT NULL, 
			Section varchar(20) NOT NULL,
			Year varchar(20) NOT NULL, 
			name_file TEXT,
			attendance_file TEXT,
			PRIMARY KEY(Branch, Section, Year))";

?>

