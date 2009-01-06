
//client code

#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <errno.h>
#include <string.h>
#include <netdb.h>
#include <sys/types.h>
#include <netinet/in.h>
#include <sys/socket.h>
#include <arpa/inet.h>
#include <assert.h>

#define PORT "3490" // the port client will be connecting to 

#define MAXDATASIZE 100 // max number of bytes we can get at once 

char term_string[10]= "EOF";

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
	char buff[MAXDATASIZE]="hello";
	struct addrinfo hints, *servinfo, *p;
	int rv,pid,flag,status;
	char s[INET6_ADDRSTRLEN];
	char file_name[20];
	FILE *fp;

	if (argc != 2) {
	    fprintf(stderr,"usage: client hostname\n");
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

	printf("\nenter the name of the file\n");
	scanf("%s",file_name);

	fp= fopen(file_name,"r");	

	assert(fp!=NULL);

	strcpy(buff,"FILE");

	send_string(sockfd,buff,MAXDATASIZE);
	send_string(sockfd, file_name, 20);

	flag=1;
	while(flag)
	{
		buff[0]='\0';					
		fscanf(fp,"%s",buff);

		if(buff[0]=='\0')
		{
			strcpy(buff,term_string);
			flag=0;				

		printf("\n******file has ended*********\n");
		flag=0;
		}
		send_string(sockfd,buff,MAXDATASIZE);

	}
	fcloseall();
    close(sockfd);
    return 0;
}



int send_string(int sockfd, char *buff, int max_data_size)
{
	int numbytes;
	numbytes = send(sockfd, buff, strlen(buff), 0);

	if ( numbytes== -1 || numbytes < strlen(buff))
	{
		perror("send");
		close(sockfd);
		fcloseall();
		exit(0);
	}

	numbytes = recv(sockfd, buff, max_data_size-1, 0);
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
