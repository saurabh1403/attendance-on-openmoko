
//client code

#include <stdio.h>
//#include <stdlib.h>
#include <unistd.h>
#include <errno.h>
//#include <string.h>
#include <netdb.h>
#include <sys/types.h>
#include <netinet/in.h>
#include <sys/socket.h>
#include <arpa/inet.h>

#include <assert.h>
#include<iostream>
#include <fstream>

using namespace std;

int send_char(int sockfd, char buff);
int send_file(int sockfd);
int send_string(int sockfd, const char *buff, int max_data_size);

#define PORT "3490" // the port client will be connecting to 

#define MAXDATASIZE 100 // max number of bytes we can get at once 

const char term_string[]= "EOF";

void delay()
{
	int i = 100000;
	
	while(i--);
}


// get sockaddr, IPv4 or IPv6:
void *get_in_addr(struct sockaddr *sa)
{
	if (sa->sa_family == AF_INET) {
		return &(((struct sockaddr_in*)sa)->sin_addr);
	}

	return &(((struct sockaddr_in6*)sa)->sin6_addr);
}


int send_string(int, char* , int);

int main(int argc, char *argv[])
{
	int sockfd, numbytes;  

	struct addrinfo hints, *servinfo, *p;
	int rv,pid,flag,status;
	char s[INET6_ADDRSTRLEN];

	if (argc != 2) {
	    cerr<<"usage: client hostname\n";
	    exit(1);
	}

	memset(&hints, 0, sizeof hints);
	hints.ai_family = AF_UNSPEC;
	hints.ai_socktype = SOCK_STREAM;

	if ((rv = getaddrinfo(argv[1], PORT, &hints, &servinfo)) != 0) {
		fprintf(stderr, "getaddrinfo: %s\n", gai_strerror(rv));
		return 1;
	}

	// loop through all the results and bind to the first we can
	for(p = servinfo; p != NULL; p = p->ai_next) {
		if ((sockfd = socket(p->ai_family, p->ai_socktype,
				p->ai_protocol)) == -1) {
			perror("client: socket");
			continue;
		}

		if (connect(sockfd, p->ai_addr, p->ai_addrlen) == -1) {
			close(sockfd);
			perror("client: connect");
			continue;
		}

		break;
	}

	if (p == NULL) {
		fprintf(stderr, "client: failed to connect\n");
		return 2;
	}

	inet_ntop(p->ai_family, get_in_addr((struct sockaddr *)p->ai_addr),
			s, sizeof s);
	printf("client: connecting to %s\n", s);

	freeaddrinfo(servinfo); // all done with this structure
	
	
	send_file(sockfd);

    close(sockfd);
    return 0;
}


int send_file(int sockfd)
{

	string buff("");
	string file_name;
	FILE *fp;

	cout<<"\nenter the name of the file\n";
	cin>>file_name;

	ifstream filehandle(file_name.c_str(),ios::in);

	buff+="FILE";

	send_string(sockfd,buff.c_str(),MAXDATASIZE);
	send_string(sockfd, file_name.c_str(), file_name.length());


	while(!filehandle.eof())
	{
		char data;
		send_string(sockfd,"data",4);
		filehandle.get(data);
		cout<<data;
		send_char(sockfd, data);
	}

	send_string(sockfd,term_string,3);
//	send_char(sockfd, 4);
//	send_char(sockfd,0);

	fcloseall();

}


int send_char(int sockfd, const char data)
{
	int numbytes;
	char buff[5];

	numbytes = send(sockfd,&data,1 , 0);

	if ( numbytes== -1 || numbytes < 1)
	{
		perror("send");
		close(sockfd);
		fcloseall();
		exit(0);
	}

	numbytes = recv(sockfd, buff, 5, 0);

	buff[numbytes] = '\0';
	if (numbytes == -1||numbytes ==0)
	{
		perror("receive");		
		close(sockfd);
		fcloseall();
		exit(0);
	}


	return 1;
}


int send_string(int sockfd, const char *buff, int max_data_size)
{
	int numbytes;
	char buff_t[5];
	
	numbytes = send(sockfd, buff, strlen(buff), 0);

	if ( numbytes== -1 || numbytes < strlen(buff))
	{
		perror("send");
		close(sockfd);
		fcloseall();
		exit(0);
	}

	numbytes = recv(sockfd, buff_t, 5, 0);
	buff_t[numbytes] = '\0';
	if (numbytes == -1||numbytes ==0)
	{
		perror("receive");		
		close(sockfd);
		fcloseall();
		exit(0);
	}
	

	return 1;
}



