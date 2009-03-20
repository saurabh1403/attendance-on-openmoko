
#include"combo.h"

using namespace std;

void combo_button_clicked(GtkWidget * button,gpointer window1) 
{
	gtk_object_destroy((GtkObject *)window1);
}
void create_first_window(int argc, char* argv[])
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
	vbox= gtk_vbox_new(FALSE,0);int i;
	ifstream class_list("class_list");
	string class_name;
	while(class_list>>class_name)
	{
		gtk_combo_box_append_text((GtkComboBox *)combo,class_name.c_str());
	}
	g_signal_connect(G_OBJECT(button),"clicked",G_CALLBACK(combo_button_clicked),window);
	gtk_box_pack_start((GtkBox *)vbox,label,FALSE,TRUE,35);
	gtk_box_pack_start((GtkBox *)vbox,combo,FALSE,TRUE,70);
	gtk_box_pack_start((GtkBox *)vbox,table,FALSE,TRUE,70);
	gtk_container_add(GTK_CONTAINER(window),vbox);
	gtk_widget_show_all(window);
	gtk_main();
}

