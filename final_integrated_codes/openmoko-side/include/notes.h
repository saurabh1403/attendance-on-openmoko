#pragma once

#include <gtk/gtk.h>
#include <glade/glade.h>
#include <glib.h>
#include <iostream>
#include <string>
#include <vector>

#include "utils.h"
#define MAX_SIZE 6

const string Template[6] = {"The Class is Mass Bunked. ", "He was ABUSING. ", "He was MISBEHAVIING. ", "He did PROXY. " , "He is a GOOD PERFORMER. " ,"He is a BACK BENCHER. "};

typedef struct TextBundle
{
	GtkWidget * text_view;
	string file_name;	
}text_bundle;

int take_notes_individual(int argc, char *argv[], string file_name, string sub_selected );
