
#include"final.h"

using namespace std;

int final_window(int argc, char *argv[])
{
	GladeXML *xml;
	GtkWidget *window;
	gtk_init(&argc, &argv);
	xml = glade_xml_new("final.glade", NULL, NULL);
	window = glade_xml_get_widget(xml, "window1");
	gtk_window_set_title(GTK_WINDOW(window),"Sending Data");
	GtkWidget *progress_bar = glade_xml_get_widget (xml, "progressbar1");
	gtk_progress_bar_pulse (GTK_PROGRESS_BAR (progress_bar)); 
	gtk_widget_show (window);
	glade_xml_signal_autoconnect(xml);
	cout<<"vijay Kuamr majumdar";
	gtk_main();
	return 1;
	
}
