
#include <gtk/gtk.h>
#include <iostream>
#include <string>

/*
int main( int   argc,char *argv[] )
{
    GtkWidget *window;
    
    gtk_init (&argc, &argv);
    
    window = gtk_window_new(GTK_WINDOW_TOPLEVEL);
    gtk_widget_show(window);
    
    gtk_main ();
    
    return 0;
}
*/

gchar *hello = "Hello";
gchar *world = "World";
GtkWidget *label;
gchar *labeltext;

void buttoncb(GtkWidget *widget, gpointer data)
{
	printf("clicked %d\n",*(gint*)data);
	if (labeltext == hello)
	   {
	   labeltext = world;
	   gtk_label_set_text(GTK_LABEL(label), labeltext);
	   }
	else if (labeltext == world)
	   gtk_main_quit();
}

int main(int argc, char *argv[])
{
GtkWidget *window;
GtkWidget *button;

gint a = 23;
std::string name("saurabh gupta");
std::cout<<"haha, this is now working\n";
std::cout<<name.c_str();

gtk_init(&argc, &argv);
window = gtk_window_new(GTK_WINDOW_TOPLEVEL);
button = gtk_button_new();
labeltext = hello;
label = gtk_label_new(labeltext);
gtk_container_add(GTK_CONTAINER(button), label);
g_signal_connect(G_OBJECT(button), "clicked", G_CALLBACK(buttoncb),&(a));
gtk_container_add(GTK_CONTAINER(window), button);
gtk_widget_set_size_request ( window, 300, 300 ) ;
gtk_widget_show_all(window);
gtk_main();

return 0;
}

/*

int main()
{
	
	std::cout<<"hello world\n";
	return 0;
}

*/
