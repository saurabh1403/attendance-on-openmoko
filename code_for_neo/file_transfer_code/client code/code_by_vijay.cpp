/*
** client.c -- a stream socket client demo
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
#include <netdb.h>
#include <sys/types.h>
#include <netinet/in.h>
#include <sys/socket.h>
#define PORT 3490 // the port client will be connecting to 

using namespace std;

int main(int argc, char *argv[])
{
    int sockfd, numbytes;  
    //char buf[MAXDATASIZE];
    char ch;
    struct hostent *he;
    struct sockaddr_in their_addr; // connector's address information 
    if (argc != 3) 
    {
        fprintf(stderr,"usage: client hostname\n");
        exit(1);
    }
    if ((he=gethostbyname(argv[1])) == NULL) 
    {
        herror("gethostbyname");
        exit(1);
    }
    if ((sockfd = socket(PF_INET, SOCK_STREAM, 0)) == -1) {
        perror("socket");
        exit(1);
    }

    their_addr.sin_family = AF_INET;    // host byte order 
    their_addr.sin_port = htons(PORT);  // short, network byte order 
    their_addr.sin_addr = *((struct in_addr *)he->h_addr);
    memset(their_addr.sin_zero, '\0', sizeof their_addr.sin_zero);
    if (connect(sockfd, (struct sockaddr *)&their_addr,sizeof their_addr) == -1) 
    {
        perror("connect");
        exit(1);
    }

    ifstream file_handle(argv[2]);
    while(file_handle.get(ch))
    {
	if (send(sockfd, &ch, 1, 0) == -1)
                perror("send");
	cout<<ch<<endl;	
    }

    if (send(sockfd,"term", 4, 0) == -1)
                perror("send");
    close(sockfd);
    return 0;
} 
