
//client code

#include "send_file.h"

using namespace std;

/* sends the data across the socket 
 * sockfd: socket descriptor for the socket made
 * data: pointer to the data to be sent
 * size: size of the data in bytes. default is for char i.e. size = 1*/
static int send_data(int sockfd, const void * data, int size=1 );


/* sends a file across a socket
 * sockfd: socket file descriptor
 * returns 1 on success and -1 on failure */
static int transfer_file(int sockfd,const std::string file_name);


/* sends a string across the socket 
 * sockfd: socket descriptor for the socket made
 * buff: pointer to the string to be sent */
static int send_string(int sockfd, const char *buff);


//overloaded function to send the string. not used currently
static int send_string(int, char* , int);



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


int send_file(const std::string file_name,const char* ip_address, const char *PORT)
{
	int sockfd, numbytes;  

	struct addrinfo hints, *servinfo, *p;
	int rv,pid,flag,status;
	char s[INET6_ADDRSTRLEN];


	if(NULL == PORT)
	{
	    cerr<<"usage: client hostname\n";
	    return -1;
	}

	memset(&hints, 0, sizeof hints);
	hints.ai_family = AF_UNSPEC;
	hints.ai_socktype = SOCK_STREAM;

	if ((rv = getaddrinfo(ip_address, PORT_N, &hints, &servinfo)) != 0) {
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

	transfer_file(sockfd, file_name);

    close(sockfd);
    return 0;
}


static int transfer_file(int sockfd, const std::string file_name)
{

	string buff("");

	ifstream filehandle(file_name.c_str(),ios::in);

	if(!filehandle)
	{
		cerr<<"error in opening the file\n";
		return -1;
	}

	buff+="FILE";

	send_string(sockfd,buff.c_str());
	send_string(sockfd, file_name.c_str());

	char data;
	int data_i;

	while(!filehandle.eof())
	{

		send_string(sockfd,"data");
		filehandle.get(data);
//		cout<<data;
//		data_i = data;
		send_data(sockfd, &data);
	}

	send_string(sockfd,term_string);

	return 1;

}


static int send_data(int sockfd, const void * data, int size )
{
	int numbytes;
	char buff[5];

	numbytes = send(sockfd,data,size , 0);

	if ( numbytes== -1 || numbytes < 1)
	{
		perror("send");
		close(sockfd);
		fcloseall();
		exit(0);
	}

	numbytes = recv(sockfd, buff, 5, 0);

	if (numbytes == -1||numbytes ==0)
	{
		perror("receive");		
		close(sockfd);
		fcloseall();
		exit(0);
	}
	buff[numbytes] = '\0';

	return 1;
}


static int send_string(int sockfd, const char *buff)
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


