
#include <gtk/gtk.h>
#include <glade/glade.h>
#include <glib.h>
#include<stdio.h>

enum
{
	COLUMN_NAME = 0,
	COLUMN_LEN
};

#define butt	"button"

//static GtkWidget *treeview = 0;

/*(static void init_list(GtkWidget *list)
{
	GtkCellRenderer *renderer;
	GtkTreeViewColumn *column;
	GtkListStore *store;

	renderer = gtk_cell_renderer_text_new();
	column = gtk_tree_view_column_new_with_attributes("Available gestures",renderer, "text", COLUMN_NAME, NULL);
	gtk_tree_view_append_column(GTK_TREE_VIEW(list), column);

	gtk_tree_view_append_column(gtk_tree_(list), column);
	store = gtk_list_store_new(COLUMN_LEN, G_TYPE_STRING);
	gtk_tree_view_set_model(GTK_TREE_VIEW(list), GTK_TREE_MODEL(store));

	g_object_unref(store);
}
*/


void button_clicked(GtkWidget *object, gpointer data)
{
	int *a = (int*)data;

	g_print("clicked %d\n",*a);

	if(*a==1)
		printf("1st one pressed\n");
	
	else if(*a==2)
		printf("2nd one pressed\n");

}



void on_new_menu_item_activate(GtkWidget *object, gpointer user_data)
{
	g_print("hello, i have won\n");
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

int main(int argc, char *argv[]) {
    GladeXML *xml;
	GtkWidget *window1;
	int a=1;
	
    gtk_init(&argc, &argv);

    /* load the interface */
    xml = glade_xml_new("test.glade", NULL, NULL);

	window1 = glade_xml_get_widget(xml, "window");
//		treeview = glade_xml_get_widget(xml, "treeview");
//	init_list(treeview);

	GtkWidget *progress_bar = glade_xml_get_widget (xml, "progressbar1");
  	gtk_progress_bar_pulse (GTK_PROGRESS_BAR (progress_bar));
	g_assert(progress_bar);

	GtkWidget *my_button = glade_xml_get_widget (xml, butt "1");
  	g_signal_connect (G_OBJECT (my_button), "pressed", G_CALLBACK (button_clicked),&a);

	g_assert(my_button);

	gint func_ref = g_timeout_add (100, update_progress_bar, progress_bar);

	gtk_widget_show (window1);
	
	GTimer *wasted_time_tracker = g_timer_new ();
	
  	GtkWidget *widget = glade_xml_get_widget (xml, "WasteTimeWindow");
  	g_signal_connect (G_OBJECT (widget), "delete_event", G_CALLBACK (inform_user_of_time_wasted),wasted_time_tracker);
 
    /* connect the signals in the interface */
    glade_xml_signal_autoconnect(xml);

    /* start the event loop */
    gtk_main();
  g_source_remove (func_ref);
    return 0;
}



