
#pragma once

#include <stdio.h>
#include <unistd.h>
#include <errno.h>
#include <netdb.h>
#include <sys/types.h>
#include <netinet/in.h>
#include <sys/socket.h>
#include <arpa/inet.h>
#include <assert.h>
#include <iostream>
#include <fstream>
//#include "utils.h"
//#include "include.h"


#define PORT_N "3490" // the port client will be connecting to 

#define MAXDATASIZE 100 // max number of bytes we can get at once 

/*API for sending the file by creating a socket
 * file_name: name of the file to be sent
 * ip_address: ip address of the server whom to connect to
 * PORT: port number */
int send_file(const std::string file_path, const std::string file_name, const char* ip_address, const char *PORT, std::string &ErrMsg);

const char term_string[]= "EOF";





