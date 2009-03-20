
#pragma once

#include<gtk/gtk.h>
#include<iostream>
#include<fstream>
#include<string>

//#include"combo.h"
#include"utils.h"

typedef struct 
{
	GtkWidget *label;
	GtkWidget *toggle_button;
}Widgets;


//std::string get_current_time_T();

//this function creates the next window to take attendance
const std::string create_second_window(GtkWidget * window);


//this func capitalizes the name if it is pressed
void toggle_button_clicked(GtkWidget *toggle_button,gpointer label) ;


//this is called when the teacher completes taking attendance
void final_button_clicked(GtkWidget *button,gpointer student);


