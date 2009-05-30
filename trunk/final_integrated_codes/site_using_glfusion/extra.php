<?php

require_once $_SERVER['DOCUMENT_ROOT'] . 'gl/btp/lib-common1.php';
require_once $_CONF1['path'] . 'db.php';

$display =  COM_siteHeader('menu','test');
//echo $_CONF['site_url'];

//show1("this is error", $err);
//echo $err;

//retrieve_notes_data_student("ECE", "2", "2008", "May", "2009", "412", "51", $student_name, $time_stamp, $notes_stats, $ErrMsg, $Teacher_name);
//print_r($time_stamp);
//print_r($notes_stats);

//get_class_info("ECE", "2", "2008", &$student_names,&$students_roll_no);
//print_r($students_roll_no);

//calculate_att_day_percent("COE", "1", "2007", "May", "2009", "301", $no_students, $date, $no_present, $no_students, $arr_roll, $arr_name, $arr_roll_stat);
//print_r($date);

get_available_classes($branch, $section, $year_of_entry);
print_r($year_of_entry);

$display = COM_siteFooter();
echo $display;

?>
