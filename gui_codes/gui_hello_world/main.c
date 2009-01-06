
#include <gtk/gtk.h>

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

void buttoncb(GtkWidget *widget, gint data)
{
	
	printf("clicked %d\n",data);
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

gtk_init(&argc, &argv);
window = gtk_window_new(GTK_WINDOW_TOPLEVEL);
button = gtk_button_new();
labeltext = hello;
label = gtk_label_new(labeltext);
gtk_container_add(GTK_CONTAINER(button), label);
g_signal_connect(G_OBJECT(button), "clicked", G_CALLBACK(buttoncb), 23);
gtk_container_add(GTK_CONTAINER(window), button);
gtk_widget_show_all(window);
gtk_main();

return 0;
}
