
#pragma once

#include <gtk/gtk.h>
#include <glade/glade.h>
#include <glib.h>

typedef enum UserOptions
{
	TakeAttendance 		= 1,		//for taking attendance for a class
	TakeNotes 			= 2,		//for taking new notes
	UpdateOpenmokoData 	= 3			//for updating the class list and students list on openmoko
}UserOptions;

void attendance_clicked(GtkWidget *object,GtkWidget *window);
void notes_clicked(GtkWidget *object,GtkWidget *window);
void update_clicked(GtkWidget *object, GtkWidget *window);
gboolean update_progress_bar (gpointer data);
void inform_user_of_time_wasted (GtkWidget *widget, GdkEvent * event, gpointer data);
void on_window_destroy (GtkWidget *object, gpointer user_data);
int begin_window(int argc, char *argv[],UserOptions *b);

void show_final_window();
