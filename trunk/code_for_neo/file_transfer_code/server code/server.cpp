
#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <errno.h>
#include <string.h>
#include <sys/types.h>
#include <sys/socket.h>
#include <netinet/in.h>
#include <netdb.h>
#include <arpa/inet.h>
#include <sys/wait.h>
#include <signal.h>
#include <assert.h>

#include<iostream>
#include<fstream>

using namespace std;
//using std::ios;
//using std::ofstream;

#define PORT "3490"  // the port users will be connecting to

#define BACKLOG 10	 // how many pending connections queue will hold

#define MAXDATASIZE 100 // max number of bytes we can get at once 

char term_string[10]= "EOF";

int receive_file(int);
inline int receive_string(int new_fd, char *buff, int max_data_size);


void sigchld_handler(int s)
{
	while(waitpid(-1, NULL, WNOHANG) > 0);
}

// get sockaddr, IPv4 or IPv6:
void *get_in_addr(struct sockaddr *sa)
{
	if (sa->sa_family == AF_INET) {
		return &(((struct sockaddr_in*)sa)->sin_addr);
	}

	return &(((struct sockaddr_in6*)sa)->sin6_addr);
}




int main(void)
{
	int sockfd, new_fd;  // listen on sock_fd, new connection on new_fd
	struct addrinfo hints, *servinfo, *p;
	struct sockaddr_storage their_addr; // connector's address information
	socklen_t sin_size;
	struct sigaction sa;
	int yes=1;
	char s[INET6_ADDRSTRLEN], buff[MAXDATASIZE];
	int rv,pid,numbytes,status,flag;

	memset(&hints, 0, sizeof hints);
	hints.ai_family = AF_UNSPEC;
	hints.ai_socktype = SOCK_STREAM;
	hints.ai_flags = AI_PASSIVE; // use my IP

	if ((rv = getaddrinfo(NULL, PORT, &hints, &servinfo)) == -1) {
		fprintf(stderr, "getaddrinfo: %s\n", gai_strerror(rv));
		return 1;
	}

	// loop through all the results and bind to the first we can
	for(p = servinfo; p != NULL; p = p->ai_next) {
		if ((sockfd = socket(p->ai_family, p->ai_socktype,
				p->ai_protocol)) == -1) {
			perror("server: socket");
			continue;
		}

		if (setsockopt(sockfd, SOL_SOCKET, SO_REUSEADDR, &yes,
				sizeof(int)) == -1) {
			perror("setsockopt");
			exit(1);
		}

		if (bind(sockfd, p->ai_addr, p->ai_addrlen) == -1) {
			close(sockfd);
			perror("server: bind");
			continue;
		}

		break;
	}

	if (p == NULL)  
	{
		fprintf(stderr, "server: failed to bind\n");
		return 2;
	}

	freeaddrinfo(servinfo); // all done with this structure

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

	cout<<"server: waiting for connections...\n";

	new_fd = -1;
	while(1)  // main accept() loop
	{ 
		sin_size = sizeof their_addr;
		new_fd = accept(sockfd, (struct sockaddr *)&their_addr, &sin_size);
		if (new_fd == -1) 
		{
			perror("accept");
			continue;
		}

	inet_ntop(their_addr.ss_family,get_in_addr((struct sockaddr *)&their_addr),s, sizeof s);
	cout<<"server: got connection from"<< s<<endl;

	if(!fork())
	{
		close(sockfd);

		flag=receive_string(new_fd,buff,MAXDATASIZE);

		if(flag==0)
		{
			fcloseall();
			close(new_fd);
			exit(0);
		}

		else if(strcmp(buff,"FILE")==0)
		{
			cout<<"\nfile is coming\n";
			receive_file(new_fd);
		}

		else
			cout<<"wrong signal\n";
			
		fcloseall();
		close(new_fd);
		exit(0);
	}

	close(new_fd);
}
    return 0;

}

/* receives the data string across the socket
 * new_fd: socket descriptor for the listening socket
 * buff: pointer to the data where the recieved data is to be stored
 * max_data_size: maximum length of the buff in bytes 
 * returns 1 on success and -1 on failure */
inline int receive_string(int new_fd, char *buff, int max_data_size)
{
	int numbytes;
	numbytes = recv(new_fd, buff, max_data_size-1, 0);
	buff[numbytes] = '\0';

	if (numbytes == -1||numbytes ==0)
	{
		perror("receive");		
		fcloseall();
		return -1;
	}

	numbytes = send(new_fd, "ok", 2, 0);

	if ( numbytes== -1 || numbytes < 2)
	{
		perror("send");
		fcloseall();
		return -1;
	}

	return 1;
}


/* receives a file across a socket
 * new_fd: socket file descriptor
 * returns 1 on success and -1 on failure */
int receive_file(int new_fd)			//return 0 on failure and 1 on success
{

	char buff[MAXDATASIZE],flag=1;

	int numbytes;

	cout<<"\n*************************file transfer has begun*********************\n";

	receive_string(new_fd, buff, MAXDATASIZE);
	cout<<"\nthe file is "<<buff<<endl;

	ofstream out_file(buff,ios::out);

	if(!out_file)
	{
		cerr<<"error in opening the file\n";
		return -1;
	}

	while(flag)
	{
		flag=receive_string(new_fd,buff,MAXDATASIZE);
		
		if(flag<0)
			return -1;

		if(strcmp(buff,"data")==0)
			flag=1;

		else if(strcmp(buff,term_string)==0)
			flag=0;

		else
		{
			flag = 0;
			return -1;
		}

		if(flag!=0)
		{
			receive_string(new_fd,buff,MAXDATASIZE);
			out_file<<buff[0];
		}

	}		//end of  while

	return 1;
}


