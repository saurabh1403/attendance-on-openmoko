
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
	return time_str.substr(0,time_str.length()-1);
}




std::string get_data_folder()
{
//	return string("/media/D/BTP/test_codes/attendance-on-openmoko/final_integrated_codes/database/");	
	return string("../database/");				//relative database path
}

int read_file(string file_path,int &file_size,vector<string> &line_data)
{
	ifstream f(file_path.c_str());
	string temp;
	while(getline(f,temp))
		line_data.push_back(temp);
	file_size=line_data.size();
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







