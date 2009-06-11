
#include "pending.h" 

#pragma once

#include <gtk/gtk.h>
#include <glade/glade.h>
#include <glib.h>
#include <iostream>
#include <vector>
#include <string>
#include "utils.h"	

Comm_Mode pending_data(int argc, char *argv[]);

using namespace std;

Comm_Mode option_select = Via_WiFi;
//int option;

static void wifi_selected(GtkWidget * button, gpointer window)
{
	option_select = Via_WiFi;
	gtk_main_quit();
}

static void wired_selected(GtkWidget * button, gpointer window)
{
	option_select = Via_Wire;
	gtk_main_quit();
}

Comm_Mode pending_data(int argc, char *argv[])
{
	GladeXML *xml;
	GtkWidget *window;
	gtk_init(&argc, &argv);
	xml = glade_xml_new("pending_data.glade", NULL, NULL);
	window = glade_xml_get_widget(xml, "window1");
	gtk_window_set_title(GTK_WINDOW(window),"PENDING DATA");
	GtkWidget *button_wifi = glade_xml_get_widget (xml, "button1");
	GtkWidget *button_wired = glade_xml_get_widget (xml, "button2");
	g_signal_connect (G_OBJECT (button_wifi), "clicked", G_CALLBACK (wifi_selected),window);
	g_signal_connect (G_OBJECT (button_wired), "clicked", G_CALLBACK (wired_selected),window);
	g_signal_connect(G_OBJECT(window),"destroy",G_CALLBACK(gtk_main_quit),NULL);
	gtk_widget_show (window);

	glade_xml_signal_autoconnect(xml);
	gtk_main();
	return option_select;
}
