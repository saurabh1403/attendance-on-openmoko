
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

#define PORT "3490" // the port client will be connecting to 

#define MAXDATASIZE 100 // max number of bytes we can get at once 

char term_string[10]= "!exit";

inline void get_string(char *buff, int max_size)
{
	char c;
	int i=0;
	while((c=getc(stdin))!='\n' && ++i<max_size)
		buff[i-1]=c;	

		if(i<max_size)
			buff[i]='\0';
		else
			buff[i-1]='\0';

}

// get sockaddr, IPv4 or IPv6:
void *get_in_addr(struct sockaddr *sa)
{
	if (sa->sa_family == AF_INET) {
		return &(((struct sockaddr_in*)sa)->sin_addr);
	}

	return &(((struct sockaddr_in6*)sa)->sin6_addr);
}

int main(int argc, char *argv[])
{
	int sockfd, numbytes;  
	char buff[MAXDATASIZE]="hello";
	struct addrinfo hints, *servinfo, *p;
	int rv,pid,flag,status;
	char s[INET6_ADDRSTRLEN];

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

	pid = fork();

	if(pid==0)
	{

		flag =1;
		while(flag ==1)
		{
			numbytes = recv(sockfd, buff, MAXDATASIZE-1, 0);
			buff[numbytes] = '\0';
			if (numbytes == -1||numbytes ==0)
			{
				perror("recv");
				flag=0;
			}


			else if(strcmp(buff,term_string)==0)
			{
				printf("\nGood bye: server has exited\n");
				flag=0;
			}
			
			else
			{
				printf("==> %s\n",buff);
			}

		}
	close(sockfd);
	}


	else
	{
		printf("\nType \"%s\" to exit the chat \n",term_string);

		while(strcmp(buff,term_string))
		{
			get_string(buff, MAXDATASIZE);

			numbytes = send(sockfd, buff, strlen(buff), 0);

			if ( numbytes== -1 || numbytes < strlen(buff))
			{
				perror("send");
				printf("\nerror in connection\n");
				close(sockfd);
				exit(0);
			}

		}		//end while

		printf("\nbye(you can't send more msg now) \n");

		close(sockfd);
		waitpid(pid, &status,0);

	}

	return 0;

}


