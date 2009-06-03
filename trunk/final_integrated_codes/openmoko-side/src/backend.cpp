 
#include "backend.h"
	
using namespace std;
	
int backend(int argc, char *argv[])
{	
	GladeXML *xml;
	GtkWidget *window;
	gtk_init(&argc, &argv);
	xml = glade_xml_new("backend.glade", NULL, NULL);
	window = glade_xml_get_widget(xml, "window1");
	gtk_window_set_title(GTK_WINDOW(window),"DASO");
	gtk_widget_show (window);
	glade_xml_signal_autoconnect(xml);
	return 1;
}
