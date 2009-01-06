
#include <stdio.h>
#include <sys/socket.h>
#include <netinet/in.h>
#include <arpa/inet.h>

int var = 0;


void get_string(char *buff, int max_size)
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

int main()
{
//	long i=inet_addr("192.168.1.2");
	int i;
	struct in_addr m;
	char s[21],c,flag;
	int k,pid,status;
	FILE *fp = fopen("new.txt","r");

//	pid = fork();

//	if(pid!=0)
	{

		flag=1;
		while(flag)
		{
			s[0]='\0';					
			fscanf(fp,"%s",s);

			if(s[0]=='\0')
			{
			printf("\n******file has ended*********\n");
			flag=0;
			}
			else
			printf("%s\n",s);

		}

		fclose(fp);

	}

	return 0;
}





