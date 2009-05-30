
#pragma once

#include<gtk/gtk.h>
#include<iostream>
#include<fstream>
#include<string>

#include"utils.h"

#define SUB_LIST_FILE		"sub_list.txt"
#define CLASS_LIST_FILE		"class_list.txt"

typedef struct 
{
	GtkWidget *window;
	GtkWidget *combo_class;
	GtkWidget *combo_sub;
	string Class;
	string Sub;
	
}Data;

//this function creates the dropdown menu to select the class & returns the char * to the name of the class selected
int class_list_window(int argc, char* argv[], string &class_code, string &sub_code);


