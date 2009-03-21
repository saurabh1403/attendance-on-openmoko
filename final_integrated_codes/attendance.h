
#pragma once

#include<gtk/gtk.h>
#include<iostream>
#include<fstream>
#include<string>

#include"utils.h"

typedef struct
{
	GtkWidget *label;
	GtkWidget *toggle_button;
}Widgets;


//std::string get_current_time_T();

//this function creates the next window to take attendance
int create_take_attendance(std::string &FileName,const std::string &RollList);



