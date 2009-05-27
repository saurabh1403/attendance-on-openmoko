 
#include "final_window.h"

using namespace std;

Option option_final = NO;
static void attendance_again(GtkWidget *button, GtkWidget * window);

static void attendance_done(GtkWidget *button, GtkWidget * window);

static void attendance_again(GtkWidget *button, GtkWidget * window)
{
	option_final = YES;
	gtk_main_quit();	
}

static void attendance_done(GtkWidget *button, GtkWidget * window)
{
	option_final = NO;
	gtk_main_quit();
}

void final_window_call(int argc, char * argv[], Option &return_code)
{
	GladeXML *xml;
	GtkWidget *window;
	gtk_init(&argc, &argv);
	xml = glade_xml_new("final_window.glade", NULL, NULL);
	window = glade_xml_get_widget(xml, "window1");
	gtk_window_set_title(GTK_WINDOW(window),"DASO");
	//GtkWidget *label1 = glade_xml_get_widget (xml, "label1");
	GtkWidget *label2 = glade_xml_get_widget (xml, "label2");
	GtkWidget *button_yes = glade_xml_get_widget (xml, "button1");
	GtkWidget *button_no = glade_xml_get_widget (xml, "button2");		
	g_signal_connect (G_OBJECT (button_yes), "clicked", G_CALLBACK (attendance_again),window);
	g_signal_connect (G_OBJECT (button_no), "clicked", G_CALLBACK (attendance_done),window);
	g_signal_connect(G_OBJECT(window),"destroy",G_CALLBACK(gtk_main_quit),NULL);
	gtk_widget_show (window);
	glade_xml_signal_autoconnect(xml);
	gtk_main();
	return_code = option_final;
//	return;
}

