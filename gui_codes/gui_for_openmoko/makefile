
GCC = gcc
GCC_OM = /home/saurabhg/moko/build/tmp/cross/arm-angstrom-linux-gnueabi/bin/gcc
GCC_OM_TOOLCHAIN = /usr/local/openmoko/arm/arm-angstrom-linux-gnueabi/bin/gcc

OBJ = main.o begin_window.o attendance.o combo.o
OBJ_OM = main_OM.o begin_window_OM.o attendance_OM.o combo_OM.o


MY_FLAGS =  `pkg-config --cflags --libs gtk+-2.0 libglade-2.0` -export-dynamic
MY_FLAGS_C = `pkg-config --cflags gtk+-2.0 libglade-2.0` -export-dynamic


OM_FLAGS= -L /home/saurabhg/moko/build/tmp/staging/arm-angstrom-linux-gnueabi/lib/ -Wl, \
 	 /home/saurabhg/moko/build/tmp/staging/arm-angstrom-linux-gnueabi/usr/lib/ -Wl, \
	 `/home/saurabhg/moko/build/tmp/staging/i686-linux/usr/bin/pkg-config --cflags --libs gtk+-2.0` 

OM_FLAGS_TOOLCHAIN = \
	`pkg-config --cflags --libs gtk+-2.0 libglade-2.0` -export-dynamic

INCLUDE_DIR = ./

test: $(OBJ)
	$(GCC) $(MY_FLAGS) -o $@ $(OBJ)

main.o: main.c
	$(GCC) -I$(INCLUDE_DIR) $(MY_FLAGS_C) -c  main.c

begin_window.o: begin_window.c
	$(GCC) -I$(INCLUDE_DIR) $(MY_FLAGS) -c begin_window.c


attendance.o: attendance.c
	$(GCC) -I$(INCLUDE_DIR) $(MY_FLAGS_C) -c  attendance.c


combo.o: combo.c
	$(GCC) -I$(INCLUDE_DIR) $(MY_FLAGS_C) -c  combo.c


#compile options for openmoko
neo_gui: $(OBJ_OM)
	. /usr/local/openmoko/arm/bin/setup-env
	$(GCC_OM_TOOLCHAIN) -o $@ $(OBJ_OM) $(OM_FLAGS_TOOLCHAIN)

main_OM.o: main.c
	$(GCC_OM_TOOLCHAIN) -I$(INCLUDE_DIR) $(OM_FLAGS_TOOLCHAIN) -c  main.c -o $@

begin_window_OM.o: begin_window.c
	$(GCC_OM_TOOLCHAIN) -I$(INCLUDE_DIR) $(OM_FLAGS_TOOLCHAIN) -c begin_window.c -o $@


attendance_OM.o: attendance.c
	$(GCC_OM_TOOLCHAIN) -I$(INCLUDE_DIR) $(OM_FLAGS_TOOLCHAIN) -c  attendance.c -o $@


combo_OM.o: combo.c
	$(GCC_OM_TOOLCHAIN) -I$(INCLUDE_DIR) $(OM_FLAGS_TOOLCHAIN) -c  combo.c -o $@


clean:
	rm *.o test neo_gui
 
