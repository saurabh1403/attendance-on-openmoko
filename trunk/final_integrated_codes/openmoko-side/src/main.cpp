
#include"include.h"

using namespace std;

Comm_Mode Current_mode = Via_WiFi;			//default communication mode

void send_pending_files(Comm_Mode Current_Mode = Via_WiFi)
{

	int status;
	string ErrMsg;

	//sending of all previous files should be done here. TO DO
	string config_file = get_data_folder();
	config_file+= CONFIG_FILE_NAME;

	vector<string> list_files;
	int no_file;

	read_file(config_file, no_file,list_files);

	for(int i =0;i<no_file;i++)
	{
		if(Current_Mode == Via_WiFi)
			status = send_file(get_local_folder(), list_files[i], IP_LOCAL_LOOPBACK, PORT, ErrMsg);

		else if(Current_Mode == Via_Wire)
			status = send_file(get_local_folder(), list_files[i], IP_USB, PORT, ErrMsg);

		if(status<0)
		{
			update_log_file(ErrMsg);
		}

		else
		{
			ErrMsg = list_files[i];
			ErrMsg+= " sent to server";
			update_log_file(ErrMsg);
			update_config_file(list_files[i], DELETE_ENTRY);
		}
	}

}


void take_new_attendance(string class_selected, string sub_selected)
{

	string file_name, ErrMsg;
	int status = 1;
	status = create_take_attendance(file_name, class_selected, sub_selected);

	if(status<0)
	{
		update_log_file("failed to take attendance");
	}

	else
	{
		update_config_file(file_name, ADD_ENTRY);
		send_pending_files(Current_mode);
	}

}


void enter_new_notes(int argc, char * argv[],string RollList, string sub_selected)
{
	string file_name, ErrMsg;
	Option return_code;
	int status = create_take_notes(argc, argv, file_name, RollList, sub_selected,return_code);
	cout<<"notes file is "<<file_name.c_str();

	if(return_code == NO)
	{
		update_log_file("failed to take notes");	
		cout<<"failed to take notes";
	}

	else
	{
		status = take_notes_individual(argc, argv, file_name, sub_selected);
		cout<<"notes file later is "<<file_name.c_str();
		if(status<0)
		{
			update_log_file("failed to take attendance");
		}

		else
		{
			update_config_file(file_name, ADD_ENTRY);
			send_pending_files(Current_mode);
		}

	}

}


void update_openmoko_data()
{
	
	
	
}


int main(int argc, char* argv[]) 
{

//	this is  the main window creating the combo box.
	string class_selected, sub_selected, ErrMsg;
	
	UserOptions option_selected;
	int status;Option return_code = YES;
//	while(return_code == YES)
	{
		status = backend(argc, argv); 
		status = begin_window(argc, argv,option_selected);
		cout<<option_selected;
		switch (option_selected)
		{

			case TakeAttendance:
					status = class_list_window(argc,argv, class_selected, sub_selected);
					if(status > 0)
						take_new_attendance(class_selected, sub_selected);
//					cout<<class_selected<<" "<<sub_selected;
					break;

			case TakeNotes:
					status = class_list_window(argc, argv, class_selected, sub_selected); 
					if(status > 0)
						enter_new_notes(argc, argv, class_selected ,sub_selected);
//					cout<<"\n\nreturn code is"<<(return_code==YES);
					break;

			case Pending_data:
					Current_mode = pending_data( argc, argv);
					send_pending_files(Current_mode);
					break;

			default:
					break;

		}
//		final_window_call(argc, argv, return_code);
	}
	return 0;	
}


