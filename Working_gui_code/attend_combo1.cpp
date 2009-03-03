// THIS PROGRAM IS NOW THE COMPLETE ONE.
#include<gtk/gtk.h>
#include<iostream>
#include<fstream>
#include<string>

using namespace std; 

ofstream g("roll_get");//THE FINAL LIST OF PRESENT STUDENT IS PRESENT IN THIS LIST.

typedef struct 
{
	GtkWidget *label;
	GtkWidget *check_button;
}Widgets;

//void button_clicked(GtkWidget *check_button,gpointer label) //this is called when the check button is toggled.
void button_clicked(GtkWidget *check_button,int roll_no) //this is called when the check button is toggled.
{
	char *a;
	gtk_label_get((GtkLabel *)label,(gchar **)&a);
	char *p=a;
	if(gtk_toggle_button_get_active((GtkToggleButton *)check_button))
	{
		while(isalpha(*p))
		{
			*p=char((*p)+'A'-'a');
			p++;
		}
	
	}
	else
	{
		while(isalpha(*p))
		{
			*p=char((*p)+'a'-'A');
			p++;
		}
	}
	
	gtk_label_set_text((GtkLabel *)label,a);
}

void final_button_clicked(GtkWidget *button,gpointer student)//this is called when the attendance is finished.
{
	Widgets *a=(Widgets *)student;
	GtkWidget *check_button=a->check_button;
	GtkWidget *label=a->label;
	char *b;
	gtk_label_get((GtkLabel *)label,(gchar **)&b);
	string vijay=b;
	if(gtk_toggle_button_get_active((GtkToggleButton *)check_button))
	{
		g<<vijay<<"\tYES"<<endl;
	}
	else
	{
		g<<vijay<<"\tNO"<<endl;
	}
	gtk_main_quit();
}


void button_clicked_on(GtkWidget * button,gpointer window1) //this is called by the first window buton.
{
	gtk_object_destroy((GtkObject *)window1);
	GtkAdjustment *horizontal,*vertical;
	GtkWidget *label[50],*vbox,*swin,*window,*table1,*table2,*check_button[50],*v_separator[50];
	ifstream f("roll_list");//THIS FILE CONTAINS THE ATTENDANCE LIST OF THE CLASS.
	string current;
	int i;
	//CREATING WINDOW & SEETING ITS DEFAULT SIZES.
	window=gtk_window_new(GTK_WINDOW_TOPLEVEL);
	gtk_window_set_title(GTK_WINDOW(window),"My Attendance");
	gtk_container_set_border_width(GTK_CONTAINER(window),10);
	gtk_widget_set_size_request(window,500,400);
	g_signal_connect(G_OBJECT(window),"destroy",G_CALLBACK(gtk_main_quit),NULL);
	//CREATING A TABLE OF 50X3.
	table1=gtk_table_new(50,3,TRUE);
	gtk_table_set_row_spacings(GTK_TABLE(table1),5);
	gtk_table_set_col_spacings(GTK_TABLE(table1),5);
	//PACKING TABLE WITH LABELS & CHECK BUTTON.& vertical separator
	for(i=0;i<50;i++)
	{
		f>>current;
		label[i]=gtk_label_new(current.c_str());
		v_separator[i]=gtk_vseparator_new();
		check_button[i]=gtk_check_button_new_with_label("YES");
		gtk_table_attach_defaults(GTK_TABLE(table1),label[i],0,1,i,i+1);
		gtk_table_attach_defaults(GTK_TABLE(table1),v_separator[i],1,2,i,i+1);	
		gtk_table_attach_defaults(GTK_TABLE(table1),check_button[i],2,3,i,i+1);	
		g_signal_connect(G_OBJECT(check_button[i]),"toggled",G_CALLBACK(button_clicked),label[i]);
	}
	f.close();
	GtkWidget *Button_f;
	//this has been done to limit the size of the button.
	table2=gtk_table_new(1,3,TRUE);
	Button_f=gtk_button_new_with_label("DONE");
	gtk_table_attach_defaults(GTK_TABLE(table2),Button_f,1,2,0,1);
	//Creating a new scrolled window
	swin= gtk_scrolled_window_new(NULL,NULL);
	horizontal=gtk_scrolled_window_get_hadjustment(GTK_SCROLLED_WINDOW(swin)) ;
	vertical=gtk_scrolled_window_get_vadjustment(GTK_SCROLLED_WINDOW(swin));
	Widgets * student[i];
	for(i=0;i<50;i++)
	{	
		student[i] = g_slice_new (Widgets);
		student[i]->label = label[i];
		student[i]->check_button = check_button[i];
		g_signal_connect(G_OBJECT(Button_f),"clicked",G_CALLBACK(final_button_clicked),student[i]);
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
}
int main(int argc, char* argv[]) //this is  the main window creating the combo box.
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
	for(i=0;i<10;i++)
	{
		gtk_combo_box_append_text((GtkComboBox *)combo,"Vijay");
	}
	g_signal_connect(G_OBJECT(button),"clicked",G_CALLBACK(button_clicked_on),window);
	gtk_box_pack_start((GtkBox *)vbox,label,FALSE,TRUE,35);
	gtk_box_pack_start((GtkBox *)vbox,combo,FALSE,TRUE,70);
	gtk_box_pack_start((GtkBox *)vbox,table,FALSE,TRUE,70);
	gtk_container_add(GTK_CONTAINER(window),vbox);
	gtk_widget_show_all(window);
	gtk_main();
	return 0;
}
