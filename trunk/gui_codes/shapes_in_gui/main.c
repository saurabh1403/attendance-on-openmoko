# include <gtk/gtk.h>
int expose_event ( GtkWidget *widget, GdkEventExpose *event )
{
     GdkGC* p ;
     GdkPoint arr [ 5] = { 250, 150, 250, 300, 300, 350, 400, 300, 320, 190 } ;
     p = gdk_gc_new ( widget -> window ) ;
     gdk_draw_line ( widget -> window, p, 10, 10, 200, 10 ) ;
     gdk_draw_rectangle ( widget -> window, p, TRUE, 10, 20, 200, 100 ) ;
     gdk_draw_arc ( widget -> window, p, TRUE, 200, 10, 200, 200,
                     2880, -2880*2 ) ;
     gdk_draw_polygon ( widget -> window, p, TRUE , arr, 5 ) ;
     gdk_gc_unref ( p ) ;
     return TRUE ;
}



int main( int argc, char *argv[ ] )
{
     GtkWidget *p ;
     gtk_init ( &argc, &argv ) ;
  p = gtk_window_new ( GTK_WINDOW_TOPLEVEL ) ;
  gtk_window_set_title ( p, "Sample Window" ) ;
  g_signal_connect ( p, "destroy", gtk_main_quit, NULL ) ;
  g_signal_connect ( p , "expose_event", expose_event, NULL ) ;
  gtk_widget_set_size_request ( p, 500, 500 ) ;
  gtk_widget_show ( p ) ;
  gtk_main( ) ;
  return 0 ;
}

