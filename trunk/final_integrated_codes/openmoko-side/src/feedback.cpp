
#include "feedback.h"

using namespace std;

int feedback_window(int argc, char *argv[], int result)
{
		GladeXML *xml;
		GtkWidget *window;
		gtk_init(&argc, &argv);
		xml = glade_xml_new("feedback.glade", NULL, NULL);	
		window = glade_xml_get_widget(xml, "window1");
		GtkWidget *button = glade_xml_get_widget(xml, "button1");
		GtkWidget *label = glade_xml_get_widget(xml, "label1");
		if(result < 0)
			gtk_label_set_label((GtkLabel *)label, "Sending Failed :(");
		else
			gtk_label_set_label((GtkLabel *)label, "Sending Successful!!!");
		gtk_window_set_title(GTK_WINDOW(window),"DONE !!!");
		g_signal_connect(G_OBJECT(window),"destroy",G_CALLBACK(gtk_main_quit),NULL);		
		g_signal_connect(G_OBJECT(button),"clicked",G_CALLBACK(gtk_main_quit),NULL);
		gtk_widget_show (window);
		glade_xml_signal_autoconnect(xml);
		gtk_main();
		return 1;
}
