

#pragma once

#include <gtk/gtk.h>
#include <glade/glade.h>
#include <glib.h>
#include <iostream>
#include <vector>
#include <string>
#include "utils.h"	

//	this function creates the last window asking the user if he wants to take more attendance or not
void final_window_call(int argc, char * argv[], Option &return_code);
