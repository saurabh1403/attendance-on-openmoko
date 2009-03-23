
#include"include.h"

using namespace std;

void take_new_attendance(string class_selected)
{

	string file_name("config.txt"), ErrMsg;
	int status = 1;
	status = create_take_attendance(file_name,class_selected);
	cout<<file_name<<endl;//<<status<<endl;

	if(status<0)
	{
		update_log_file("failed to take attendance");
	}

	else
	{
		update_config_file(file_name, ADD_ENTRY);
		
		//sending of all previous files should be done here. TO DO
		status = send_file(get_data_folder(), file_name, "192.168.1.5", "34175", ErrMsg);

		if(status<0)
		{
			update_log_file(ErrMsg);
		}

		else
		{
			ErrMsg = file_name;
			ErrMsg+= " sent to server";
			update_log_file(ErrMsg);
		}

	}

}


void enter_new_notes()
{
	
	
	
}


void update_openmoko_data()
{
	
	
	
}


int main(int argc, char* argv[]) 
{

//	this is  the main window creating the combo box.
	string class_selected, ErrMsg;
//	class_selected=attendance_list_window(argc,argv);
//	cout<<class_selected<<endl;

	UserOptions option_selected;
	int status = begin_window(argc, argv,option_selected);
	switch (option_selected)
	{

		case TakeAttendance:
			class_selected=attendance_list_window(argc,argv);
			take_new_attendance(class_selected);
//			update_config_file("vijay12.txt", ADD_ENTRY);
//			update_config_file("vijay12.txt", DELETE_ENTRY);
//			update_log_file("working and dsfdfdtesting string");
//			send_file((get_data_folder() + "config.txt"), "192.168.1.5", "34191", ErrMsg);
//			send_file(("config.txt"), "192.168.1.5", "34175", ErrMsg);
			break;

		case TakeNotes:
			enter_new_notes();
			break;

		case UpdateOpenmokoData:
			update_openmoko_data();
			break;

		default:
			break;
		
	}

	return 0;
}




