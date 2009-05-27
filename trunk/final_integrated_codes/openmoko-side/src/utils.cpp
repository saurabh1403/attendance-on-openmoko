
#include"utils.h"

using namespace std;

std::string get_current_time_sec()
{
	time_t seconds;
	seconds=time(NULL);
	std::string s;
	std::stringstream out;
	out << seconds;
	s = out.str();
	return s;
}


std::string get_current_time_str()
{
	time_t seconds;
	seconds=time(NULL);
	std::string time_str(ctime(&seconds));
	cout<<time_str.c_str()<<endl;
	return time_str.substr(0,time_str.length()-1);
}

int file_write(GtkWidget *button,gpointer student,std::ofstream &g)
{
	//this is called when the attendance is finished.
	Widgets *a=(Widgets *)student;
	GtkWidget *toggle_button=a->toggle_button;
	GtkWidget *roll_label=a->roll_label;
	char *b;
	gtk_label_get((GtkLabel *)roll_label,(gchar **)&b);
	string vijay=b;
	if(gtk_toggle_button_get_active((GtkToggleButton *)toggle_button))
	{
		g<<vijay<<endl<<"PRESENT"<<endl;
	}
	else
	{
		g<<vijay<<endl<<"ABSENT"<<endl;
	}
	return 1;
}

int notes_file_write(GtkWidget *button,gpointer student,std::ofstream &g)
{
	//this is called when the attendance is finished.
	Toggle_Widgets *a=(Toggle_Widgets *)student;
	GtkWidget *toggle_button=a->toggle_button;
	GtkWidget *roll_label= a->roll_label;
	char *b;
//	gtk_label_get((GtkLabel *)label,(gchar **)&b);
//	string name = b;
	gtk_label_get((GtkLabel *)roll_label,(gchar **)&b);
	string roll_no = b;
	if(gtk_toggle_button_get_active((GtkToggleButton *)toggle_button))
	{
		g<<roll_no<<endl;
	}
	return 1;
}

int file_head_stamp(std::ofstream &g)
{
/*	this file is copying the ID.txt into the header of the returned file;
	for example
	Device
	Openmoko
	id_code
	#1234
	Teacher
	Teacher_name
	Year-of-Issue
	2008*/

	ifstream h((get_data_folder()+ INFO_USER_FILE_NAME ).c_str());
	string temp;
	while(getline(h,temp))
	{
		g<<temp<<endl;
	}

	temp=get_current_time_str();
	g<<temp<<endl;
	h.close();
	return 1;
}


std::string get_data_folder()
{
//	return string("/media/D/BTP/test_codes/attendance-on-openmoko/final_integrated_codes/database/");	
	return string("../database/");				//relative database path
}


std::string get_local_folder()
{

	return string("../local_dir/");				
	
}


//function overloading used here.
//this function will only read the file line by line and store in line_data vector
int read_file(const std::string &file_path,int &file_size,vector<string> &line_data)
{

	ifstream f(file_path.c_str());
	string temp;
	while(getline(f,temp))
		line_data.push_back(temp);
	file_size=line_data.size();
	return 1;

}

//this file reads the roll number and name line by line
int read_file(std::string file_path,int &file_size,vector<string> &name_list, vector<string> &roll_list)
{
	ifstream f(file_path.c_str());
	string temp;
	while(getline(f,temp))
	{
		roll_list.push_back(temp);
		getline(f,temp);
		name_list.push_back(temp);
	}

	file_size=name_list.size();
	return 1;
}


int update_config_file(std::string file_name, ConfigFileActions action)
{
	std::string config_file = get_data_folder();
	config_file+=CONFIG_FILE_NAME;

	
	if(ADD_ENTRY==action)
	{
		ofstream configFile;
		
		configFile.open(config_file.c_str(), ios::app);

		if(NULL == configFile)
		{
			cerr<<"File couldn't be opened"<<endl;
			return -1;
		}

		configFile.seekp(0,ios::end);		//seeking the pointer to the end of the file

		configFile<<file_name.c_str()<<endl;
		configFile.close();

	}

	else if(DELETE_ENTRY==action)
	{
		ifstream InconfigFile;
		ofstream OutconfigFile;

		//Reading of data from the config file
		InconfigFile.open(config_file.c_str(), ios::in);

		if(NULL == InconfigFile)
		{
			cerr<<"File couldn't be opened"<<endl;
			return -1;
		}

		std::list<std::string> list_files;
		std::string data_st;

		while(!InconfigFile.eof())
		{
			getline(InconfigFile,data_st);

			if(data_st != string(""))
			{
				cout<<data_st.c_str()<<endl;
				list_files.push_back(data_st);
		}
		}

		list_files.remove(file_name.c_str());
		InconfigFile.close();

		//Writing of modified data to the config file			
		OutconfigFile.open(config_file.c_str(), ios::out);

		if(NULL == OutconfigFile)
		{
			cerr<<"File couldn't be opened"<<endl;
			return -1;
		}

		std::list<std::string>::const_iterator constIterator;

		for ( constIterator = list_files.begin(); constIterator != list_files.end(); ++constIterator )
		{
//			cout << *constIterator << endl;
			OutconfigFile<<constIterator->c_str()<<endl;
		}

		OutconfigFile.close();
	}
	
	else
	{
	}

	return 1;
}


int update_log_file(std::string LogMsg)
{
	std::string log_file = get_data_folder();
	log_file+=LOG_FILE_NAME;

	ofstream logFile(log_file.c_str(), ios::app);
	
	if(!logFile)
	{
		cerr<<"File couldn't be opened"<<endl;
		return -1;
	}

//	logFile.seekp(0,ios::beg);		//seeking the pointer to the end of the file

//	cout<<get_current_time_str().c_str()<<" : "<<LogMsg<<endl;
	logFile<<get_current_time_str().c_str()<<" : "<<LogMsg<<endl;

	return 1;
	
}



