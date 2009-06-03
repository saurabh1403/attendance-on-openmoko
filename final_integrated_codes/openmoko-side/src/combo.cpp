
#include"combo.h"

using namespace std;

//this the callback function it is called when the class is selceted using dropdown menu
//This function is called when combo is selected & "DONE" button is clicked

int status = 1;

static void combo_button_clicked(GtkWidget * button,gpointer window1); 

static void combo_cancel_button_clicked(GtkWidget *button, gpointer struct_handle); 

static void combo_button_clicked(GtkWidget *button, gpointer struct_handle) 
{
	Data * gpoint;
	gpoint = (Data *) struct_handle;
	gchar * data = gtk_combo_box_get_active_text((GtkComboBox *)gpoint->combo_class);
	gpoint->Class= data;
	
	data = gtk_combo_box_get_active_text((GtkComboBox *)gpoint->combo_sub);
	gpoint->Sub= data;
	if(gpoint->Sub == "GENERAL")
	{
			gpoint->Sub = "0" ;
	}
	gtk_object_destroy((GtkObject *)gpoint->window);
}

static void combo_cancel_button_clicked(GtkWidget *button, gpointer struct_handle) 
{
	status = -1;
	gtk_main_quit(); 
}

int class_list_window(int argc, char* argv[], string &class_code, string &sub_code)
{

	GtkWidget *combo_class,*combo_sub,*window,*vbox,*label_class,*label_sub,*button_done,*button_cancel,*table;
	gtk_init(&argc,&argv);
	window = gtk_window_new(GTK_WINDOW_TOPLEVEL);
	label_class = gtk_label_new("SELECT THE CLASS");
	label_sub = gtk_label_new("SELECT THE SUBJECT CODE");
	button_done = gtk_button_new_with_label("DONE");
	button_cancel= gtk_button_new_with_label("CANCEL");
	table = gtk_table_new(1,3,TRUE);
	gtk_table_attach_defaults(GTK_TABLE(table),button_done,0,1,0,1);
	gtk_table_attach_defaults(GTK_TABLE(table),button_cancel,2,3,0,1);

	gtk_window_set_title(GTK_WINDOW(window),"Class Selection");
	gtk_container_set_border_width(GTK_CONTAINER(window),10);
//	gtk_widget_set_size_request(window,500,400);
	g_signal_connect(G_OBJECT(window),"destroy",G_CALLBACK(gtk_main_quit),NULL);
	combo_class = gtk_combo_box_new_text();
	combo_sub = gtk_combo_box_new_text();
	vbox = gtk_vbox_new(FALSE,0);

	int i;
	string class_file_name = get_data_folder();
	class_file_name += CLASS_LIST_FILE;
	string sub_file_name = get_data_folder();
	sub_file_name += SUB_LIST_FILE;
	ifstream class_list(class_file_name.c_str());
	ifstream sub_list(sub_file_name.c_str());
	string class_name;
	string sub_name;
	
	while(sub_list>>sub_name)
	{
		gtk_combo_box_append_text((GtkComboBox *)combo_sub,sub_name.c_str());
	}
	
	while(class_list>>class_name)
	{
		gtk_combo_box_append_text((GtkComboBox *)combo_class,class_name.c_str());
	}
	
	Data gpoint;
	gpoint.window=(GtkWidget *)window;
	gpoint.combo_class=(GtkWidget *)combo_class;
	gpoint.combo_sub=(GtkWidget *)combo_sub;
	g_signal_connect(G_OBJECT(button_done),"clicked",G_CALLBACK(combo_button_clicked),&gpoint);
	g_signal_connect(G_OBJECT(button_cancel),"clicked",G_CALLBACK(combo_cancel_button_clicked),NULL);
	//string class_selected=gpoint.p;
	gtk_box_pack_start((GtkBox *)vbox,label_class,FALSE,TRUE,30);
	gtk_box_pack_start((GtkBox *)vbox,combo_class,FALSE,TRUE,30);
	gtk_box_pack_start((GtkBox *)vbox,label_sub,FALSE,TRUE,30);
	gtk_box_pack_start((GtkBox *)vbox,combo_sub,FALSE,TRUE,30);
	gtk_box_pack_start((GtkBox *)vbox,table,FALSE,TRUE,20);
	gtk_container_add(GTK_CONTAINER(window),vbox);
	gtk_widget_show_all(window);

	gtk_main();
	class_code=gpoint.Class;
	sub_code=gpoint.Sub;
	return status;

}


