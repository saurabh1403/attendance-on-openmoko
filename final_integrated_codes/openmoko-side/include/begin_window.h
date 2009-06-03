
#pragma once

#include <gtk/gtk.h>
#include <glade/glade.h>
#include <glib.h>
#include <iostream>
#include "utils.h"

using namespace std;

void attendance_clicked(GtkWidget *object,GtkWidget *window);
void notes_clicked(GtkWidget *object,GtkWidget *window);
void pending_clicked(GtkWidget *object, GtkWidget *window);
gboolean update_progress_bar (gpointer data);
void inform_user_of_time_wasted (GtkWidget *widget, GdkEvent * event, gpointer data);
void on_window_destroy (GtkWidget *object, gpointer user_data);
int begin_window(int argc, char *argv[],UserOptions &b);
