
#include<signal.h>
#include<stdio.h>
#include<stdlib.h>

void MySignal_handler(int a)
{
	printf("haha, you can't kill it simply\n");
	exit(3);
}

int main()
{
	signal(SIGINT, (void *)MySignal_handler);
	signal(SIGTERM, (void*)MySignal_handler);
	signal(SIGCONT, (void*)MySignal_handler);
	printf("\n main has started\n");
	while(1);
	return 0;
}


