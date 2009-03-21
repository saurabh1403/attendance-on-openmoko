
#pragma once

#include<gtk/gtk.h>
#include<iostream>
#include<fstream>
#include<string>

#include"utils.h"

typedef struct 
{
	GtkWidget *window;
	GtkWidget *combo;
	char *p;
}Data;
//this function creates the dropdown menu to select the class & returns the char * to the name of the class selected
std::string attendance_list_window(int argc, char* argv[]);


//this the callback function it is called when the class is selceted using dropdown menu
//This function is called when combo is selected & "DONE" button is clicked
void combo_button_clicked(GtkWidget * button,gpointer window1); 
