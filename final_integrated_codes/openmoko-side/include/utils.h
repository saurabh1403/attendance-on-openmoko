
#pragma once

#include<gtk/gtk.h>
#include<iostream>
#include<fstream>
#include<sstream>
#include<string>
#include<vector>
#include<stdio.h>
#include <list> 
#include <iterator> 


using std::ofstream;
using std::ifstream;
using std::ios;
using namespace std;

#define LOG_FILE_NAME		"log.txt"
#define CONFIG_FILE_NAME	"config.txt"

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
	UpdateOpenmokoData 	= 3			//for updating the class list and students list on openmoko
}UserOptions;


//returns the current time in seconds elapsed since 00:00 hours, Jan 1, 1970 UTC
std::string get_current_time_sec();

//returns the current time in string form
std::string get_current_time_str();

//returns the folder path where database files are stored
std::string get_data_folder();

//It reads the file in the form of vector<string> & read the file linewise
int read_file(string file_path,int &file_size,vector< string > &line_data );

//updates the config file stored in the database folder
int update_config_file(std::string data, ConfigFileActions action);

//Add the file entry in the config file
int remove_data_config_file(std::string data);

//Enter the status message in the log file
int update_log_file(std::string LogMsg);

//retrieves the list of files stored in config.txt
int Get_file_list(int &no_files, char **list);




