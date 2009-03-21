
#include"include.h"

using namespace std;

void take_new_attendance(string class_selected)
{

	string file_name, ErrMsg;
	int status = create_take_attendance(file_name,class_selected);
	cout<<file_name<<endl;//<<status<<endl;

	if(status<0)
	{
		update_log_file("failed to take attendance");
	}

	else
	{
		update_config_file(file_name, ADD_ENTRY);
//		status = send_file(file_name, "192.168.1.2", "3490", ErrMsg);
		status = send_file(file_name, "127.0.0.1", "3490", ErrMsg);

		if(status<0)
		{
			update_log_file(ErrMsg);
		}

		else
		{
			ErrMsg = file_name;
			ErrMsg+= "sent to server";
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
	string class_selected;
	class_selected=attendance_list_window(argc,argv);
//	cout<<class_selected<<endl;

	UserOptions option_selected = TakeAttendance;

	switch (option_selected)
	{

		case TakeAttendance:
			take_new_attendance(class_selected);
//			update_config_file("vijay12.txt", ADD_ENTRY);
//			update_config_file("vijay12.txt", DELETE_ENTRY);
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




