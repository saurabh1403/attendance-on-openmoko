
#include"notes.h"

using namespace std;

int return_code = -1;

static void notes_submit(GtkWidget *button, gpointer Text_bundle)
{
	text_bundle *p = (text_bundle *) Text_bundle;
	GtkTextIter start,end;
	GtkTextBuffer* Buffer;
	Buffer = gtk_text_view_get_buffer ((GtkTextView *)p->text_view);
	gtk_text_buffer_get_start_iter (Buffer, &start);
	gtk_text_buffer_get_end_iter (Buffer, &end);
	gchar *text = gtk_text_buffer_get_text (Buffer, &start, &end, TRUE);
	string data = text;
	ofstream file_handle((get_local_folder() + p->file_name).c_str(), ios::app);
	file_handle<<"Comment"<<endl;
	file_handle<<data;
	cout<<data;
	return_code = 1;
	gtk_main_quit();

}


static void notes_cancel(GtkWidget *button, GtkWidget* window)
{
	return_code = -1;
	gtk_main_quit ();
}


static void on_window_destroy (GtkWidget *object, gpointer user_data)
{
	return_code = -1;
    gtk_main_quit ();
}


static void combo_box_selected(GtkWidget *combo_box, gpointer text_view)
{
	GtkTextBuffer* Buffer;
	GtkTextIter iter;
	Buffer = gtk_text_view_get_buffer ((GtkTextView *)text_view);
	gtk_text_buffer_get_end_iter (Buffer, &iter);
	gchar * data = gtk_combo_box_get_active_text((GtkComboBox *)combo_box);
	gtk_text_buffer_insert(Buffer, &iter, data, -1);
}


int take_notes_individual(int argc, char *argv[], string file_name, string sub_selected )
{
	GladeXML *xml;
	GtkWidget *window;
	gtk_init(&argc, &argv);
	xml = glade_xml_new("notes.glade", NULL, NULL);
	window = glade_xml_get_widget(xml, "window1");
	gtk_window_set_title(GTK_WINDOW(window),"DASO");
	gtk_widget_set_size_request(window,500,400);
	GtkWidget *button_submit = glade_xml_get_widget (xml, "button1");
	GtkWidget *button_cancel = glade_xml_get_widget (xml, "button2");
	GtkWidget *text_view = glade_xml_get_widget (xml, "textview1");
	GtkWidget *label = glade_xml_get_widget (xml, "label1");
	GtkWidget *hbox = glade_xml_get_widget (xml, "hbox3");
	GtkWidget *combobox = gtk_combo_box_new_text();
	int i;
	for(i=0; i < MAX_SIZE; i++)
	{
		gtk_combo_box_append_text ((GtkComboBox *)combobox,Template[i].c_str());
	}

	gtk_box_pack_end(GTK_BOX(hbox), combobox, TRUE, TRUE, 0);
	gtk_widget_show(combobox);
	gtk_box_reorder_child(GTK_BOX(hbox), combobox, 1);
	GtkTextBuffer* Buffer = gtk_text_view_get_buffer ((GtkTextView *)text_view);
	g_signal_connect (G_OBJECT (combobox), "changed", G_CALLBACK (combo_box_selected), text_view);
	gtk_label_set_text ((GtkLabel *)label, "Enter Notes");
	text_bundle p;
	p.text_view = text_view;
	p.file_name = file_name;
	g_signal_connect (G_OBJECT (button_submit), "clicked", G_CALLBACK (notes_submit),&p);
	g_signal_connect (G_OBJECT (button_cancel), "clicked", G_CALLBACK (notes_cancel),window);
	g_signal_connect(G_OBJECT(window),"destroy",G_CALLBACK(gtk_main_quit),NULL);

	gtk_widget_show (window);
	glade_xml_signal_autoconnect(xml);
	gtk_main();
	return return_code;

}
