
#include"attendance.h"

using namespace std;
int status_attend = 1;
std::string file_name= get_current_time_sec();
ofstream g((get_local_folder() + file_name + ".txt").c_str(), ios::out); 	

//this func capitalizes the name if it is pressed
static void toggle_button_clicked(GtkWidget *toggle_button,gpointer label) ;


//this is called when the teacher completes taking attendance
static void final_button_clicked(GtkWidget *button,gpointer student);

static void file_head_clicked(GtkWidget *button,gpointer File_ptr);

static void all_selected(GtkWidget *button, gpointer class_ptr);

static void toggle_button_clicked(GtkWidget *toggle_button,gpointer label) 
{
	//this is called when the toggle button is toggled.
	//its use is just to highlight the roll nos that are clicked
	char *a;
	gtk_label_get((GtkLabel *)label,(gchar **)&a);
	char *p=a;
	if(gtk_toggle_button_get_active((GtkToggleButton *)toggle_button))
	{
		gtk_button_set_label((GtkButton *)toggle_button," P ");
		while(isalpha(*p))
		{
			*p=char((*p)+'A'-'a');
			p++;
		}
	}

	else
	{	
		gtk_button_set_label((GtkButton *)toggle_button," A ");
		while(isalpha(*p))
		{
			*p=char((*p)+'a'-'A');
			p++;
		}
	}
	gtk_label_set_text((GtkLabel *)label,a);
}

static void file_head_clicked(GtkWidget *button,gpointer sub_selected_ptr)
{
	g<<"ATTENDANCE"<<endl;
	int status = file_head_stamp(g);
	
	istringstream iss(*(string *)sub_selected_ptr);
	string codes;
	iss>>codes;
	g<<"class"<<"\n"<<codes<<endl;
	iss>>codes;
	g<<"sub_code"<<"\n"<<codes<<endl;
	g<<"Roll_no"<<endl;
	gtk_main_quit();	
}


static void final_button_clicked(GtkWidget *button,gpointer student)
{
	//this is called when the attendance is finished.
	int status = file_write(button,student,g);
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
		g<<roll_no[i]<<endl<<" P "<<endl;
	gtk_main_quit();
}

static void cancel_selected(GtkWidget *button, gpointer class_ptr)
{
	status_attend = -1;	
	gtk_main_quit();
}
int create_take_attendance(std::string &FileName,std::string class_selected, std::string sub_selected)
{
	GtkWidget * window;
	int no_student;
	file_name += ".txt";
	cout<<file_name;
	GtkWidget *vbox,*swin,*table1,*table2,*label[100],*toggle_button[100],*v_separator[100],*roll_label[100];
	GtkAdjustment *horizontal,*vertical;
	window=gtk_window_new(GTK_WINDOW_TOPLEVEL);
	gtk_window_set_title(GTK_WINDOW(window),class_selected.c_str());
	gtk_container_set_border_width(GTK_CONTAINER(window),10);
	gtk_widget_set_size_request(window,500,400);
	g_signal_connect(G_OBJECT(window),"destroy",G_CALLBACK(gtk_main_quit),NULL);


//	ifstream f((get_data_folder() + class_selected).c_str());//THIS FILE CONTAINS THE ATTENDANCE LIST OF THE CLASS.
//	f>>no_student;
	vector<string> current(0);
	vector<string> roll_no(0);
	read_file((get_data_folder() + class_selected + ".txt"), no_student , current, roll_no);
	cout<<current[0]<<" "<<roll_no[0];


	int i;
//	cout<<no_student;
	//CREATING A TABLE OF 50X4.
	table1=gtk_table_new(no_student,4,TRUE);
	gtk_table_set_row_spacings(GTK_TABLE(table1),5);
	gtk_table_set_col_spacings(GTK_TABLE(table1),5);


	//PACKING TABLE WITH LABELS & CHECK BUTTON.& vertical separator	
	for(i=0;i<no_student;i++)
	{
		label[i]=gtk_label_new(current[i].c_str());
		roll_label[i] = gtk_label_new(roll_no[i].c_str());
		v_separator[i]=gtk_vseparator_new();
		toggle_button[i]=gtk_toggle_button_new_with_label(" A ");
		gtk_table_attach_defaults(GTK_TABLE(table1),roll_label[i],0,1,i,i+1);
		gtk_table_attach_defaults(GTK_TABLE(table1),label[i],1,2,i,i+1);
		gtk_table_attach_defaults(GTK_TABLE(table1),v_separator[i],2,3,i,i+1);	
		gtk_table_attach_defaults(GTK_TABLE(table1),toggle_button[i],3,4,i,i+1);	
		g_signal_connect(G_OBJECT(toggle_button[i]),"toggled",G_CALLBACK(toggle_button_clicked),label[i]);
	}


	GtkWidget *Button_finish, *Button_all, *Button_cancel;
	//this has been done to limit the size of the button.
/*	table2 = gtk_table_new(2,5,TRUE);
	Button_finish = gtk_button_new_with_label("DONE");
	Button_all = gtk_button_new_with_label("Select All");
	Button_cancel = gtk_button_new_with_label("Cancel");
	gtk_table_attach_defaults(GTK_TABLE(table2),Button_all, 1, 2, 0, 1);
	gtk_table_attach_defaults(GTK_TABLE(table2),Button_cancel, 3, 4, 0, 1);
	gtk_table_attach_defaults(GTK_TABLE(table2),Button_finish, 2, 3, 1, 2);
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
	Widgets * student[no_student];
	string class_code = class_selected + " " + sub_selected;
	g_signal_connect(G_OBJECT(Button_finish),"clicked",G_CALLBACK(file_head_clicked),&class_code);
	g_signal_connect(G_OBJECT(Button_all),"clicked",G_CALLBACK(file_head_clicked), &class_code);
	g_signal_connect(G_OBJECT(Button_all),"clicked",G_CALLBACK(all_selected), &class_selected);
	g_signal_connect(G_OBJECT(Button_cancel),"clicked",G_CALLBACK(cancel_selected), NULL);
	for(i=0;i<no_student;i++)
	{	
		student[i] = g_slice_new (Widgets);
		student[i]->label = label[i];
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

	FileName = file_name;

	return status_attend;
}

