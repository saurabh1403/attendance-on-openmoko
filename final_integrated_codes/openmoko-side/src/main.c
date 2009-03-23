
#include <gtk/gtk.h>
#include <glade/glade.h>
#include <glib.h>
#include <iostream>
using namespace std;
enum
{
	COLUMN_NAME = 0,
	COLUMN_LEN
};

UserOptions a;

void attendance_clicked(GtkWidget *object, gpointer data)
{
	cout<<"ATTEND";
	a=TakeAttendance;
	gtk_main_quit();
}

void notes_clicked(GtkWidget *object, gpointer data)
{
	cout<<"NOTES";
	a=TakeNotes;
	gtk_main_quit();
}

void update_clicked(GtkWidget *object, gpointer data)
{
	cout<<"UPDATE";
	a=UpdateOpenmokoData;
	gtk_main_quit();
}

gboolean update_progress_bar (gpointer data)
{
  gtk_progress_bar_pulse (GTK_PROGRESS_BAR (data));

  /* Return true so the function will be called again; returning false removes
   * this timeout function.
   */
  return TRUE;
}
/* This is the callback for the delete_event, i.e. window closing */

void inform_user_of_time_wasted (GtkWidget *widget, GdkEvent * event, gpointer data)
{
  /* Get the elapsed time since the timer was started */
  GTimer * timer = (GTimer*) data;
  gulong dumb_API_needs_this_variable;
  gdouble time_elapsed = g_timer_elapsed (timer, &dumb_API_needs_this_variable);

  /* Tell the user how much time they used */
  printf ("You wasted %.2f seconds with this program.\n", time_elapsed);

  /* Free the memory from the timer */
  g_timer_destroy (timer);

  /* Make the main event loop quit */
  gtk_main_quit ();
}



void on_window_destroy (GtkWidget *object, gpointer user_data)
{
    gtk_main_quit ();
}

//int begin_window(int argc, char *argv[],UserOptions b) 
int main(int argc, char *argv[])
{
	GladeXML *xml;
	GtkWidget *window;
	gtk_init(&argc, &argv);
	xml = glade_xml_new("test1.glade", NULL, NULL);
	window = glade_xml_get_widget(xml, "window");
	GtkWidget *progress_bar = glade_xml_get_widget (xml, "progressbar1");
	gtk_progress_bar_pulse (GTK_PROGRESS_BAR (progress_bar));
	g_assert(progress_bar);
	GtkWidget *button_attendance = glade_xml_get_widget (xml, "button1");
	GtkWidget *button_notes = glade_xml_get_widget (xml, "button2");
	GtkWidget *button_update = glade_xml_get_widget (xml, "button3");
	g_signal_connect (G_OBJECT (button_attendance), "pressed", G_CALLBACK (attence_clicked),&a);
	g_signal_connect (G_OBJECT (button_notes), "pressed", G_CALLBACK (notes_clicked),&a);
	g_signal_connect (G_OBJECT (button_update), "pressed", G_CALLBACK (update_clicked),&a);
	gint func_ref = g_timeout_add (100, update_progress_bar, progress_bar);
	gtk_widget_show (window);
	GTimer *wasted_time_tracker = g_timer_new ();
	GtkWidget *widget = glade_xml_get_widget (xml, "WasteTimeWindow");
	g_signal_connect (G_OBJECT (widget), "delete_event", G_CALLBACK (inform_user_of_time_wasted),wasted_time_tracker);
	glade_xml_signal_autoconnect(xml);
	gtk_main();
	g_source_remove (func_ref);
	b=a;
	return 1;
}



