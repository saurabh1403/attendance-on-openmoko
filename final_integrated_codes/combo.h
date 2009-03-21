
#pragma once

#include<gtk/gtk.h>
#include<iostream>
#include<fstream>
#include<string>

#include"utils.h"

#define CLASS_LIST_FILE		"class_list.txt"


typedef struct 
{
	GtkWidget *window;
	GtkWidget *combo;
	char *p;
}Data;
//this function creates the dropdown menu to select the class & returns the char * to the name of the class selected
std::string attendance_list_window(int argc, char* argv[]);


