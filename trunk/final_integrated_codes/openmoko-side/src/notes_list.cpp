
#include "notes_list.h"

using namespace std;
Option option_notes = YES;

std::string file_name_notes= get_current_time_sec();
ofstream g_notes((get_local_folder() + file_name_notes + ".txt").c_str(), ios::out);

static void file_head_clicked(GtkWidget *button,gpointer File_ptr);

static void final_button_clicked(GtkWidget *button,gpointer student);
static void file_head_clicked(GtkWidget *button,gpointer sub_selected_ptr)
{
	g_notes<<"NOTES"<<endl;
	int status = file_head_stamp(g_notes);

	istringstream iss(*(string *)sub_selected_ptr);
	string codes;
	iss>>codes;
	g_notes<<"class"<<"\n"<<codes<<endl;
	iss>>codes;
	g_notes<<"sub_code"<<"\n"<<codes<<endl;
	g_notes<<"Roll_no"<<endl;
	gtk_main_quit();	
}

static void final_button_clicked(GtkWidget *button,gpointer student)
{
	//this is called when the attendance is finished.
	int status = notes_file_write(button,student,g_notes);
	gtk_main_quit();
}

static void gui_destroy(GtkWidget *window, gpointer _null)
{
	option_notes = NO;
	gtk_main_quit();
}


int create_take_notes(int argc, char *argv[], std::string &file_name, string RollList, string sub_selected, Option &return_code)
{
	GtkWidget * window;
	int no_student;
	file_name_notes += ".txt";
	gtk_init(&argc, &argv);
	GtkWidget *vbox, *swin, *table1, *table2, *toggle_button[100], *v_separator[100], *roll_label[100];
	GtkAdjustment *horizontal,*vertical;
	
	window = gtk_window_new(GTK_WINDOW_TOPLEVEL);
	gtk_window_set_title(GTK_WINDOW(window),RollList.c_str());
	gtk_container_set_border_width(GTK_CONTAINER(window),10);
	gtk_widget_set_size_request(window,500,400);
	g_signal_connect(G_OBJECT(window),"destroy",G_CALLBACK(gui_destroy),NULL);

	vector <string> current(0); vector<string> roll_no(0);
	read_file((get_data_folder() + RollList + ".txt"), no_student , current, roll_no);
	int i;
	cout<<no_student;
	//CREATING A TABLE OF 50X3.
	table1 = gtk_table_new(no_student,3,FALSE);
	gtk_table_set_row_spacings(GTK_TABLE(table1),5);
	gtk_table_set_col_spacings(GTK_TABLE(table1),5);

	//PACKING TABLE WITH LABELS & CHECK BUTTON.& vertical separator	
	for(i = 0; i < no_student; i++)
	{
		roll_label[i] = gtk_label_new(roll_no[i].c_str());
		v_separator[i]=gtk_vseparator_new();
		toggle_button[i]=gtk_toggle_button_new_with_label(current[i].c_str());
		
		gtk_table_attach_defaults(GTK_TABLE(table1),roll_label[i],0,1,i,i+1);
		gtk_table_attach_defaults(GTK_TABLE(table1),v_separator[i],1,2,i,i+1);	
		gtk_table_attach_defaults(GTK_TABLE(table1),toggle_button[i],2,3,i,i+1);	
	}

	GtkWidget *Button_finish;
	//this has been done to limit the size of the button.
	table2 = gtk_table_new(1,3,TRUE);
	Button_finish = gtk_button_new_with_label("DONE");
	gtk_table_attach_defaults(GTK_TABLE(table2),Button_finish,1,2,0,1);


	//Creating a new scrolled window
	swin= gtk_scrolled_window_new(NULL,NULL);
	horizontal=gtk_scrolled_window_get_hadjustment(GTK_SCROLLED_WINDOW(swin)) ;
	vertical=gtk_scrolled_window_get_vadjustment(GTK_SCROLLED_WINDOW(swin));
	Toggle_Widgets * student[no_student];
	string class_code = RollList + " " + sub_selected;
	g_signal_connect(G_OBJECT(Button_finish),"clicked",G_CALLBACK(file_head_clicked), &class_code);
	for(i=0;i<no_student;i++)
	{	
		student[i] = g_slice_new (Toggle_Widgets);
		student[i]->roll_label = roll_label[i];
		student[i]->toggle_button = toggle_button[i];
		g_signal_connect(G_OBJECT(Button_finish),"clicked",G_CALLBACK(final_button_clicked),student[i]);
	}

	gtk_container_set_border_width(GTK_CONTAINER(swin),5);
	gtk_scrolled_window_set_policy(GTK_SCROLLED_WINDOW(swin),GTK_POLICY_AUTOMATIC, GTK_POLICY_AUTOMATIC);
	gtk_scrolled_window_add_with_viewport(GTK_SCROLLED_WINDOW(swin),table1);

	vbox= gtk_vbox_new(FALSE,0);
	gtk_box_pack_start((GtkBox *)vbox,swin,TRUE,TRUE,0);
	gtk_box_pack_start((GtkBox *)vbox,table2,FALSE,TRUE,0);

	gtk_container_add(GTK_CONTAINER(window),vbox);
	gtk_widget_show_all(window);
	gtk_main();
	g_notes.close();
	file_name = file_name_notes;	
	return_code = option_notes;
	return 1;
}

