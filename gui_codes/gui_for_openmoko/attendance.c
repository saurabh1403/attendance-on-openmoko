
#include<gtk/gtk.h>
#include<stdio.h>

typedef struct
{
	GtkWidget *label;
	GtkWidget *toggle_button;
}Widgets;
//this func capitalizes the name if it is pressed
void toggle_button_clicked(GtkWidget *toggle_button,gpointer label) ;
//this is called when the teacher completes taking attendance
void final_button_clicked(GtkWidget *button,gpointer student);
void toggle_button_clicked(GtkWidget *toggle_button,gpointer label) 
{
//this is called when the toggle button is toggled.
	if(gtk_toggle_button_get_active((GtkToggleButton *)toggle_button))
	{
		gtk_button_set_label((GtkButton *)toggle_button,"PRESENT");
	}

	else
	{	
		gtk_button_set_label((GtkButton *)toggle_button,"ABSENT");
	}
}

void final_button_clicked(GtkWidget *button,gpointer student)
{
	show_final_window();
	gtk_main_quit();
}


int create_take_attendance()
{
	GtkWidget * window;
	int no_student=20;
	
	GtkWidget *vbox,*swin,*table1,*table2,*label[100],*toggle_button[100],*v_separator[100];
	GtkAdjustment *horizontal,*vertical;
	window=gtk_window_new(GTK_WINDOW_TOPLEVEL);
	gtk_window_set_title(GTK_WINDOW(window),"Take Attendance");
	gtk_container_set_border_width(GTK_CONTAINER(window),10);
	gtk_widget_set_size_request(window,500,400);
	g_signal_connect(G_OBJECT(window),"destroy",G_CALLBACK(gtk_main_quit),NULL);
	int i;
	table1=gtk_table_new(no_student,3,TRUE);
	gtk_table_set_row_spacings(GTK_TABLE(table1),5);
	gtk_table_set_col_spacings(GTK_TABLE(table1),5);
	char *current[20]={"Saurabh", "Vijay","Praveen","Lamba","Nimit","Varun", "Pramod","Quadri","Rohit","Nanam","Nishant", "Sumit","Nehra","Divyansh","Nirbhay","Ankit", "Vishal","Nipun","Anubhav","Anurag"};
	for(i=0;i<20;i++)
	{
		label[i]=gtk_label_new(current[i]);
		v_separator[i]=gtk_vseparator_new();
		toggle_button[i]=gtk_toggle_button_new_with_label("ABSENT");
		gtk_table_attach_defaults(GTK_TABLE(table1),label[i],0,1,i,i+1);
		gtk_table_attach_defaults(GTK_TABLE(table1),v_separator[i],1,2,i,i+1);	
		gtk_table_attach_defaults(GTK_TABLE(table1),toggle_button[i],2,3,i,i+1);	
		g_signal_connect(G_OBJECT(toggle_button[i]),"toggled",G_CALLBACK(toggle_button_clicked),label[i]);
	}

	GtkWidget *Button_f;
	table2=gtk_table_new(1,3,TRUE);
	Button_f=gtk_button_new_with_label("DONE");
	gtk_table_attach_defaults(GTK_TABLE(table2),Button_f,1,2,0,1);


	//Creating a new scrolled window
	swin= gtk_scrolled_window_new(NULL,NULL);
	horizontal=gtk_scrolled_window_get_hadjustment(GTK_SCROLLED_WINDOW(swin)) ;
	vertical=gtk_scrolled_window_get_vadjustment(GTK_SCROLLED_WINDOW(swin));
	Widgets * student[no_student];
	g_signal_connect(G_OBJECT(Button_f),"clicked",G_CALLBACK(final_button_clicked),NULL);

	gtk_container_set_border_width(GTK_CONTAINER(swin),5);
	gtk_scrolled_window_set_policy(GTK_SCROLLED_WINDOW(swin),GTK_POLICY_AUTOMATIC, GTK_POLICY_AUTOMATIC);
	gtk_scrolled_window_add_with_viewport(GTK_SCROLLED_WINDOW(swin),table1);
	
	vbox= gtk_vbox_new(FALSE,0);
	gtk_box_pack_start((GtkBox *)vbox,swin,TRUE,TRUE,0);
	gtk_box_pack_start((GtkBox *)vbox,table2,FALSE,TRUE,0);
	
	gtk_container_add(GTK_CONTAINER(window),vbox);
	gtk_widget_show_all(window);
	gtk_main();
	return 1;
}











