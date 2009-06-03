
#pragma once

#include<gtk/gtk.h>
#include<iostream>
#include<fstream>
#include<sstream>
#include<string>
#include<vector>
#include<stdio.h>
#include<list> 
#include<iterator> 


using std::ofstream;
using std::ifstream;
using std::ios;
using namespace std;

#define LOG_FILE_NAME		"log.txt"
#define CONFIG_FILE_NAME	"config.txt"
#define INFO_USER_FILE_NAME "id.txt"

typedef enum ConfigFileActions
{
	ADD_ENTRY	=	1,
	DELETE_ENTRY =	2,
	MODIFY_ENTRY = 3
}ConfigFileActions;


typedef enum UserOptions
{
	TakeAttendance 		= 1,		//for taking attendance for a class
	TakeNotes 			= 2,		//for taking new notes
	Pending_data 		= 3			//for updating the class list and students list on openmoko
}UserOptions;


/* 
 * the communication mode between openmoko and target device
 */
typedef enum comm_mode
{
	Via_WiFi = 1,	//data is sent via wifi
	Via_Wire = 2	//data is sent via wired connection
}Comm_Mode;


typedef struct
{
	GtkWidget *label;
	GtkWidget *roll_label;
	GtkWidget *toggle_button;
}Widgets;


typedef struct
{
	GtkWidget *roll_label;
	GtkWidget *toggle_button;
}Toggle_Widgets;


typedef enum Option
{
	YES	=	1,
	NO =	2,
}Option;

//returns the current time in seconds elapsed since 00:00 hours, Jan 1, 1970 UTC
std::string get_current_time_sec();

//returns the current time in string form
std::string get_current_time_str();

//returns the folder path where database files are stored. 
std::string get_data_folder();

//returns the folder path where local storage of file are kept.
std::string get_local_folder();

//It reads the file in the form of vector<string> & read the file linewise
//int read_file(string file_path,int &file_size,vector< string > &line_data );
int read_file(const std::string &file_path,int &file_size,vector<string> &line_data);

//this file reads the roll number and name line by line
int read_file(string file_path,int &file_size,vector<string> &name_list, vector<string> &roll_list);

//updates the config file stored in the database folder
int update_config_file(std::string data, ConfigFileActions action);

//Add the file entry in the config file
int remove_data_config_file(std::string data);

//Enter the status message in the log file
int update_log_file(std::string LogMsg);

//retrieves the list of files stored in config.txt
int Get_file_list(int &no_files, char **list);

//write the data of each student 
int file_write(GtkWidget *button,gpointer student,std::ofstream &g);
//write the notes in a file
int notes_file_write(GtkWidget *button,gpointer student,std::ofstream &g);
//write the head on the file
int file_head_stamp(std::ofstream &g);

