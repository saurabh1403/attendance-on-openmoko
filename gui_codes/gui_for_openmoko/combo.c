
#include<gtk/gtk.h>
#include<stdio.h>
#include "include.h"

typedef struct 
{
	GtkWidget *window;
	GtkWidget *combo;
	char *p;
}Data;
//this the callback function it is called when the class is selceted using dropdown menu
//This function is called when combo is selected & "DONE" button is clicked
void combo_button_clicked(GtkWidget * button,gpointer window1); 

void combo_button_clicked(GtkWidget *button, gpointer struct_handle) 
{
	Data * gpoint;
	gpoint=(Data *) struct_handle;
	gchar * data=gtk_combo_box_get_active_text((GtkComboBox *)gpoint->combo);
	gpoint->p=data;
	gtk_object_destroy((GtkObject *)gpoint->window);
}

int attendance_list_window(int argc, char* argv[])
{

	GtkWidget *combo,*window,*vbox,*label,*button,*table;
	gtk_init(&argc,&argv);
	window = gtk_window_new(GTK_WINDOW_TOPLEVEL);
	label = gtk_label_new("SELECT THE CLASS");
	button = gtk_button_new_with_label("DONE");
	table = gtk_table_new(1,3,TRUE);
	gtk_table_attach_defaults(GTK_TABLE(table),button,1,2,0,1);

	gtk_window_set_title(GTK_WINDOW(window),"My Attendance");
	gtk_container_set_border_width(GTK_CONTAINER(window),10);
	gtk_widget_set_size_request(window,500,400);
	g_signal_connect(G_OBJECT(window),"destroy",G_CALLBACK(gtk_main_quit),NULL);
	combo = gtk_combo_box_new_text();
	vbox= gtk_vbox_new(FALSE,0);
	
	gtk_combo_box_append_text((GtkComboBox *)combo,"EC-402-2-2008");
	gtk_combo_box_append_text((GtkComboBox *)combo,"COE-210-1-2007");
	gtk_combo_box_append_text((GtkComboBox *)combo,"IC-330-2-2005");
	Data gpoint;
	gpoint.window=(GtkWidget *)window;
	gpoint.combo=(GtkWidget *)combo;
	g_signal_connect(G_OBJECT(button),"clicked",G_CALLBACK(combo_button_clicked),&gpoint);

	gtk_box_pack_start((GtkBox *)vbox,label,FALSE,TRUE,35);
	gtk_box_pack_start((GtkBox *)vbox,combo,FALSE,TRUE,70);
	gtk_box_pack_start((GtkBox *)vbox,table,FALSE,TRUE,70);
	gtk_container_add(GTK_CONTAINER(window),vbox);
	gtk_widget_show_all(window);

	gtk_main();

	return 1;
}


