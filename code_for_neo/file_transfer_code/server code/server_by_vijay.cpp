/*
** server.c -- a stream socket server demo
*/
#include <iostream>
#include <string>
#include <fstream>
#include <algorithm>
#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <errno.h>
#include <string.h>
#include <sys/types.h>
#include <sys/socket.h>
#include <netinet/in.h>
#include <arpa/inet.h>
#include <sys/wait.h>
#include <signal.h>

#define MYPORT 3490 // the port users will be connecting to
#define BACKLOG 10   // how many pending connections queue will hold
#define MAXDATASIZE 100 // max number of bytes we can get at once 

using namespace std;

void sigchld_handler(int s)
{
    while(waitpid(-1, NULL, WNOHANG) > 0);
}
int main(void)
{
    int sockfd, new_fd;  // listen on sock_fd, new connection on new_fd
    struct sockaddr_in my_addr; // my address information
    struct sockaddr_in their_addr; // connector's address information
    char buf[MAXDATASIZE-1];
    int numbytes;
    socklen_t sin_size;
    struct sigaction sa;
    char ch;
    string vijay;	
    int yes=1;
    if ((sockfd = socket(AF_INET, SOCK_STREAM, 0)) == -1) {
        perror("socket");
        exit(1);
    }
    if (setsockopt(sockfd, SOL_SOCKET, SO_REUSEADDR, &yes, sizeof(int)) == -1) {
        perror("setsockopt");
        exit(1);
    }
    my_addr.sin_family = AF_INET;        // host byte order
    my_addr.sin_port = htons(MYPORT);    // short, network byte order
    my_addr.sin_addr.s_addr = INADDR_ANY; // automatically fill with my IP
    memset(my_addr.sin_zero, '\0', sizeof my_addr.sin_zero);
    if (bind(sockfd, (struct sockaddr *)&my_addr, sizeof my_addr) == -1) {
        perror("bind");
        exit(1);
    }
    if (listen(sockfd, BACKLOG) == -1) {
        perror("listen");
        exit(1);
    }
    sa.sa_handler = sigchld_handler; // reap all dead processes
    sigemptyset(&sa.sa_mask);
    sa.sa_flags = SA_RESTART;
    if (sigaction(SIGCHLD, &sa, NULL) == -1) {
        perror("sigaction");
        exit(1);
    }

    while(1) 
    { 
        sin_size = sizeof their_addr;
        if ((new_fd = accept(sockfd, (struct sockaddr *)&their_addr,&sin_size)) == -1) 
        {
            perror("accept");
            continue;
        }

        printf("server: got connection from %s\n",inet_ntoa(their_addr.sin_addr));
	if (!fork())
        {
            close(sockfd);
	    string ver_name;
	    ifstream version_handle("current.txt");
	    version_handle>>ver_name;
	    version_handle.close();
	    ofstream from((ver_name+".txt").c_str());
	    ofstream version("current.txt");
	    ver_name[ver_name.length()-1]=ver_name[ver_name.length()-1]++;
	    version<<ver_name;		
	    version.close();
	    //cout<<"vijay";getchar();
	    vijay="start";

            while(vijay!="term")
	    {
		if ((numbytes=recv(new_fd, buf, MAXDATASIZE-1, 0)) == -1) 
		{
        		perror("recv");
        		exit(1);
		}

		buf[numbytes] = '\0';
		ch=buf[0];
		vijay=buf;
		from.put(ch);
		printf("Received: %c\n",ch);
		//getchar();
	   }
	   cout<<"Terminator found: ";
	   from.close();
	   close(new_fd);
           exit(0);
        }
        close(new_fd);  // parent doesn't need this
    }
    return 0;
}




