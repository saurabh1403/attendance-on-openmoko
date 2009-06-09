<?php

//this file contains the whole schema of the database structure for DASO (Data acquisition system on Openmoko)

$_SCHEMA['attendance'] = "
			TeacherName varchar(50) NOT NULL, 
			SubjectCode varchar(50) NOT NULL,
			OpenmokoID varchar(50) NOT NULL, 
			Date varchar(50) NOT NULL,
			Month varchar(50) NOT NULL,
			Year varchar(50) NOT NULL,
			Time varchar(50) NOT NULL,
			TimeStamp varchar(50) NOT NULL";


$_SCHEMA['attendance_key'] = "
			PRIMARY KEY (TeacherName,Time,OpenmokoID)";


//if Roll_No is '0', it means that the notes is for whole class. 
//Similarly, if subject code is '0', then the notes is general and not about a particular subject.
$_SCHEMA['notes'] = "
			TeacherName varchar(50) NOT NULL, 
			SubjectCode varchar(50) NOT NULL,
			OpenmokoID varchar(50) NOT NULL, 			
			Date varchar(50) NOT NULL,
			Month varchar(50) NOT NULL,
			Year varchar(50) NOT NULL,
			Time varchar(50) NOT NULL,
			TimeStamp varchar(50) NOT NULL,
			Roll_No varchar(20) NOT NULL,
			Notes TEXT";


$_SCHEMA['notes_key'] = "
			PRIMARY KEY (Time,SubjectCode,Roll_No)";


$_SCHEMA['ODASI'] = "
			Branch varchar(50) NOT NULL, 
			Section varchar(50) NOT NULL,
			Year varchar(50) NOT NULL, 
			name_file TEXT,
			attendance_file TEXT,
			notes_file TEXT,
			PRIMARY KEY(Branch, Section, Year))";


?>
