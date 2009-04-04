
#include"begin_window.h"

UserOptions a;

void attendance_clicked(GtkWidget *object,GtkWidget *window)
{
	a=TakeAttendance;
	gtk_object_destroy((GtkObject *)window);
}

void notes_clicked(GtkWidget *object,GtkWidget *window)
{
	a=TakeNotes;
	gtk_object_destroy((GtkObject *)window);
}

void update_clicked(GtkWidget *object, GtkWidget *window)
{
	a=UpdateOpenmokoData;
	gtk_object_destroy((GtkObject *)window);
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

int begin_window(int argc, char *argv[],UserOptions *b)
{
	GladeXML *xml;
	GtkWidget *window;
	gtk_init(&argc, &argv);
	xml = glade_xml_new("test1.glade", NULL, NULL);
	window = glade_xml_get_widget(xml, "window1");
	GtkWidget *progress_bar = glade_xml_get_widget (xml, "progressbar1");
	gtk_progress_bar_pulse (GTK_PROGRESS_BAR (progress_bar));
	g_assert(progress_bar);

	GtkWidget *button_attendance = glade_xml_get_widget (xml, "button1");
	GtkWidget *button_notes = glade_xml_get_widget (xml, "button2");
	GtkWidget *button_update = glade_xml_get_widget (xml, "button3");
	g_signal_connect (G_OBJECT (button_attendance), "clicked", G_CALLBACK (attendance_clicked),window);
	g_signal_connect (G_OBJECT (button_notes), "clicked", G_CALLBACK (notes_clicked),window);
	g_signal_connect (G_OBJECT (button_update), "clicked", G_CALLBACK (update_clicked),window);
	g_signal_connect(G_OBJECT(window),"destroy",G_CALLBACK(gtk_main_quit),NULL);
	gint func_ref = g_timeout_add (100, update_progress_bar, progress_bar);

	gtk_widget_show (window);
//	GTimer *wasted_time_tracker = g_timer_new ();
//	GtkWidget *widget = glade_xml_get_widget (xml, "WasteTimeWindow");

//	g_signal_connect (G_OBJECT (widget), "delete_event", G_CALLBACK (inform_user_of_time_wasted),wasted_time_tracker);
	glade_xml_signal_autoconnect(xml);
	gtk_main();

	g_source_remove (func_ref);
	*b=a;
	return 1;
}


void show_final_window()
{
	GladeXML *xml;
	GtkWidget *window;
//	gtk_init();
	xml = glade_xml_new("final.glade", NULL, NULL);

	window = glade_xml_get_widget(xml, "window1");

	gtk_widget_show (window);
	glade_xml_signal_autoconnect(xml);
	gtk_main();

	return 1;	
	
}
