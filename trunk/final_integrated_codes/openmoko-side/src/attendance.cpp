
#include"attendance.h"

using namespace std;
int status_attend = 1;
std::string file_name_attend = get_current_time_sec();
ofstream g_attend((get_local_folder() + file_name_attend + ".txt").c_str(), ios::out); 	

//this func capitalizes the name if it is pressed
static void toggle_button_clicked(GtkWidget *toggle_button,gpointer label) ;


//this is called when the teacher completes taking attendance
static void final_button_clicked(GtkWidget *button,gpointer student);

static void file_head_clicked(GtkWidget *button,gpointer File_ptr);

static void all_selected(GtkWidget *button, gpointer class_ptr);

static void cancel_selected(GtkWidget *button, gpointer class_ptr);

static void file_head_clicked(GtkWidget *button,gpointer sub_selected_ptr)
{
	g_attend<<"ATTENDANCE"<<endl;
	int status = file_head_stamp(g_attend);
	
	istringstream iss(*(string *)sub_selected_ptr);
	string codes;
	iss>>codes;
	g_attend<<"class"<<"\n"<<codes<<endl;
	iss>>codes;
	g_attend<<"sub_code"<<"\n"<<codes<<endl;
	g_attend<<"Roll_no"<<endl;
	gtk_main_quit();	
}


static void final_button_clicked(GtkWidget *button,gpointer student)
{
	//this is called when the attendance is finished.
	int status = file_write(button,student,g_attend);
	gtk_main_quit();
}

static void all_selected(GtkWidget *button, gpointer class_ptr)
{
	string class_selected = *(string *)class_ptr;
	vector<string> current(0);
	vector<string> roll_no(0);
	int no_student;
	read_file((get_data_folder() + class_selected + ".txt"), no_student , current, roll_no);
	int i;
	for(i=0;i < no_student; i++)
		g_attend<<roll_no[i]<<endl<<"PRESENT"<<endl;
	gtk_main_quit();
}

static void cancel_selected(GtkWidget *button, gpointer class_ptr)
{
	status_attend = -1;	
	gtk_main_quit();
}

int create_take_attendance(int argc, char *argv[], std::string &file_name, string RollList, string sub_selected)
{
	GtkWidget * window;
	int no_student;
	file_name_attend += ".txt";
//	gtk_init(&argc, &argv);
	GtkWidget *vbox, *swin, *table1, *table2, *toggle_button[100], *v_separator[100], *roll_label[100];
	GtkAdjustment *horizontal,*vertical;
	
	window = gtk_window_new(GTK_WINDOW_TOPLEVEL);
	gtk_window_set_title(GTK_WINDOW(window),RollList.c_str());
	gtk_container_set_border_width(GTK_CONTAINER(window),10);
	gtk_widget_set_size_request(window,500,400);
	g_signal_connect(G_OBJECT(window),"destroy",G_CALLBACK(gtk_main_quit),NULL);

	vector <string> current(0); vector<string> roll_no(0);
	read_file((get_data_folder() + RollList + ".txt"), no_student , current, roll_no);
	int i;
//	cout<<no_student;
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

	GtkWidget *Button_finish, *Button_all, *Button_cancel;
	//this has been done to limit the size of the button.
/*	table2 = gtk_table_new(2,5,TRUE);
	Button_finish = gtk_button_new_with_label("DONE");
	Button_all = gtk_button_new_with_label("Select All");
	Button_cancel = gtk_button_new_with_label("Cancel");
	gtk_table_attach_defaults(GTK_TABLE(table2),Button_all,1,2,0,1);
	gtk_table_attach_defaults(GTK_TABLE(table2),Button_cancel,3,4,0,1);
	gtk_table_attach_defaults(GTK_TABLE(table2),Button_finish,2,3,1,2);
*/
	table2 = gtk_table_new(2,5,TRUE);
	Button_finish = gtk_button_new_with_label("DONE");
	Button_all = gtk_button_new_with_label("Select All");
	Button_cancel = gtk_button_new_with_label("Cancel");
	gtk_table_attach_defaults(GTK_TABLE(table2),Button_all,0,1,0,1);
	gtk_table_attach_defaults(GTK_TABLE(table2),Button_cancel,4,5,0,1);
	gtk_table_attach_defaults(GTK_TABLE(table2),Button_finish,2,3,1,2);

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
	g_signal_connect(G_OBJECT(Button_all),"clicked",G_CALLBACK(file_head_clicked), &class_code);
	g_signal_connect(G_OBJECT(Button_all),"clicked",G_CALLBACK(all_selected), &RollList);
	g_signal_connect(G_OBJECT(Button_cancel),"clicked",G_CALLBACK(cancel_selected), NULL);
	gtk_container_set_border_width(GTK_CONTAINER(swin),5);
	gtk_scrolled_window_set_policy(GTK_SCROLLED_WINDOW(swin),GTK_POLICY_AUTOMATIC, GTK_POLICY_AUTOMATIC);
	gtk_scrolled_window_add_with_viewport(GTK_SCROLLED_WINDOW(swin),table1);

	vbox= gtk_vbox_new(FALSE,0);
	gtk_box_pack_start((GtkBox *)vbox,swin,TRUE,TRUE,0);
	gtk_box_pack_start((GtkBox *)vbox,table2,FALSE,TRUE,0);

	gtk_container_add(GTK_CONTAINER(window),vbox);
	gtk_widget_show_all(window);
	gtk_main();
//	cout<<"vijay";
	g_attend.close();
	file_name = file_name_attend;	
	return status_attend;
}

