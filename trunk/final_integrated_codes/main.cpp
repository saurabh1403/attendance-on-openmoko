
#include"include.h"

using namespace std;

int main(int argc, char* argv[]) 
{
	//this is  the main window creating the combo box.
	create_first_window(argc,argv);
	string file_name;
	GtkWidget * window;
	file_name = create_second_window(window);
	return 0;
}
