
#pragma once

#include "combo.h"
#include "attendance.h"
#include "utils.h"
#include "send_file.h"

//functions protoype for main.cpp

//std::string get_current_time(void);

typedef enum UserOptions
{
	TakeAttendance 		= 1,		//for taking attendance for a class
	TakeNotes 			= 2,		//for taking new notes
	UpdateOpenmokoData 	= 3			//for updating the class list and students list on openmoko
}UserOptions;
	




