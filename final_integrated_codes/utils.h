
#pragma once

#include<gtk/gtk.h>
#include<iostream>
#include<fstream>
#include<sstream>
#include<string>
#include<stdio.h>

#include <list> // list class-template definition
//#include <algorithm> // copy algorithm
#include <iterator> // ostream_iterator


using std::ofstream;
using std::ifstream;
using std::ios;

#define LOG_FILE_NAME		"log.txt"
#define CONFIG_FILE_NAME	"config.txt"

typedef enum ConfigFileActions
{
	ADD_ENTRY	=	1,
	DELETE_ENTRY =	2,
	MODIFY_ENTRY = 3
}ConfigFileActions;


std::string get_current_time_T();

//returns the folder path where database files are stored
std::string get_data_folder();

//updates the config file stored in the database folder
int update_config_file(std::string data, ConfigFileActions action);

//Add the file entry in the config file
int remove_data_config_file(std::string data);

//Enter the status message in the log file
int update_log_file(std::string LogMsg);

//retrieves the list of files stored in config.txt
int Get_file_list(int &no_files, char **list);


