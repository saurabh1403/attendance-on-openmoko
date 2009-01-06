/*
** server.c -- a stream socket server demo
*/

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

#define PORT "3490"  // the port users will be connecting to

#define BACKLOG 10	 // how many pending connections queue will hold

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
	char s[INET6_ADDRSTRLEN], buff[MAXDATASIZE]="hello";
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

	if (p == NULL)  {
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

	printf("server: waiting for connections...\n");

	new_fd = -1;
	while(new_fd==-1)  // main accept() loop
	{ 
		sin_size = sizeof their_addr;
		new_fd = accept(sockfd, (struct sockaddr *)&their_addr, &sin_size);
		if (new_fd == -1) 
		{
			perror("accept");
		}
	}

	inet_ntop(their_addr.ss_family,get_in_addr((struct sockaddr *)&their_addr),s, sizeof s);
	printf("server: got connection from %s\n", s);

	pid = fork();

	if (pid)		//parent process: for sending the data
	{
		close(sockfd); 			// no more listening is required
		printf("\nType \"%s\" to exit the chat \n",term_string);

		while(strcmp(buff,term_string))
		{
			get_string(buff,MAXDATASIZE);

			numbytes = send(new_fd, buff, strlen(buff), 0);

			if ( numbytes== -1 || numbytes < strlen(buff))
			{
				perror("send");
				printf("\nerror in connection\n");
				close(new_fd);
				exit(0);
			}
			
		}		//end while

		printf("\nBye(you can't send more msg now) \n");

		close(new_fd);
		waitpid(pid, &status,0);

	}


	else			//child process: for receiving the data
	{
		close(sockfd);
		flag =1;

		while(flag ==1)
		{
			numbytes = recv(new_fd, buff, MAXDATASIZE-1, 0);
			buff[numbytes] = '\0';
			if (numbytes == -1||numbytes ==0)
			{
				perror("recv");
				flag=0;
			}

			else if(strcmp(buff,term_string)==0)
			{
				printf("\nGood bye: client has exited\n");
				flag=0;
			}
			
			else
			{
				printf("==> %s\n",buff);
			}

		}

	close(new_fd);
	}

	return 0;

}



