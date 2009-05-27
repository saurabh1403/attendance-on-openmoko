
#pragma once

#include<gtk/gtk.h>
#include<iostream>
#include<fstream>
#include<string>

#include"utils.h"


//std::string get_current_time_sec();

//this function creates the next window to take attendance
//FileName : file name of the file which is created by this function in the database folder
//RollList : The file name of the class whose attendance is to be taken
int create_take_attendance(std::string &FileName, std::string RollList);



