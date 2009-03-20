
#pragma once

#include<gtk/gtk.h>
#include<iostream>
#include<fstream>
#include<string>

#include"utils.h"

//this function creates the dropdown menu to select the class
void create_first_window(int argc, char* argv[]);


//this the callback function it is called when the class is selceted using dropdown menu
//This function is called when combo is selected & "DONE" button is clicked
void combo_button_clicked(GtkWidget * button,gpointer window1); 
