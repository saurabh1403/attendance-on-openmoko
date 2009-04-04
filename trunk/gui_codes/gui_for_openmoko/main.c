
#include "begin_window.h"
#include "include.h"

int main(int argc, char* argv[]) 
{

	UserOptions option_selected;
	int status = begin_window(argc, argv,&option_selected);
	status = attendance_list_window(argc,argv);
	status = create_take_attendance();

	return 0;
}
