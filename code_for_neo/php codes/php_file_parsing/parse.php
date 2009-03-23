
<?php

define("DATABASE_DIR","../database/");

$_SQL[] = "
CREATE TABLE {$_TABLES['access']} (
  acc_ft_id mediumint(8) NOT NULL default '0',
  acc_grp_id mediumint(8) NOT NULL default '0',
  PRIMARY KEY  (acc_ft_id,acc_grp_id)
) TYPE=MyISAM
";

$_SQL[] = "
CREATE TABLE {$_TABLES['article_images']} (
  ai_sid varchar(40) NOT NULL,
  ai_img_num tinyint(2) unsigned NOT NULL,
  ai_filename varchar(128) NOT NULL,
  PRIMARY KEY (ai_sid,ai_img_num)
) TYPE=MyISAM
";

function test()
{
//	$user = "bob";
//	$DATABASE_DIR = "user";
//	print "${$DATABASE_DIR} \n";
//	$$DATABASE_DIR = "sauarbh";
//	print $user;
//	print DATABASE_DIR;
	print __FILE__;

}


//parses the file send by the openmoko
function parse_file($file_name, $no_students, $roll_list, $attendance_list)
{
	$file_handle=fopen($file_name,'r');
	$data=fgets($file_handle);

	print $data;	
	return;
	$no_students=fgets($file_handle);
	for($i=0;$i<$no_students;$i++)
	{
		$attend=chop(fgets($file_handle));
		print $attend;
		if($attend=="yes")
		{
			$roll_list[$i] = $i+1;
			$attendance_list[$i]=1;
		}
		else
		{
			$roll_list[$i] = $i+1;
			$attendance_list[$i]=0;

		}
	}
	fclose($file_handle);

}

print $_SQL[1][2];

//test();

//parse_file("test_file.txt", &$no, &$roll, &$attend);

//echo "no of students are ".$no."\n";

/*
for($i = 0; $i < $no; $i++)
{
	echo $roll[$i]."\t". $attend[$i]."\n";
}
*/



?>

