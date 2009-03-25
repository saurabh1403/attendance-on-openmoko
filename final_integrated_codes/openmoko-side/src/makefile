GCC = g++
GCC_OM = /home/saurabhg/moko/build/tmp/cross/arm-angstrom-linux-gnueabi/bin/gcc
GCC_OM_TOOLCHAIN = /usr/local/openmoko/arm/arm-angstrom-linux-gnueabi/bin/gcc

OBJ = attendance.o combo.o main.o utils.o send_file.o begin_window.o

MY_FLAGS =  `pkg-config --cflags --libs gtk+-2.0 libglade-2.0` -export-dynamic
MY_FLAGS_C = `pkg-config --cflags gtk+-2.0 libglade-2.0` -export-dynamic


OM_FLAGS= -L /home/saurabhg/moko/build/tmp/staging/arm-angstrom-linux-gnueabi/lib/ -Wl, \
 	 /home/saurabhg/moko/build/tmp/staging/arm-angstrom-linux-gnueabi/usr/lib/ -Wl, \
	 `/home/saurabhg/moko/build/tmp/staging/i686-linux/usr/bin/pkg-config --cflags --libs gtk+-2.0` 

OM_FLAGS_TOOLCHAIN = \
	`pkg-config --cflags --libs gtk+-2.0`

INCLUDE_DIR = ../include/

test: $(OBJ)
	$(GCC) $(MY_FLAGS) -o $@ $(OBJ)

attendance.o: attendance.cpp 
	$(GCC) -I$(INCLUDE_DIR) $(MY_FLAGS_C) -c  attendance.cpp 

combo.o: combo.cpp
	$(GCC) -I$(INCLUDE_DIR) $(MY_FLAGS_C) -c  combo.cpp

main.o: main.cpp
	$(GCC) -I$(INCLUDE_DIR) $(MY_FLAGS_C) -c  main.cpp

utils.o: utils.cpp
	$(GCC) -I$(INCLUDE_DIR) $(MY_FLAGS_C) -c  utils.cpp

send_file.o: send_file.cpp
	$(GCC) -I$(INCLUDE_DIR) -lm -c send_file.cpp

begin_window.o: begin_window.cpp
	$(GCC) -I$(INCLUDE_DIR) $(MY_FLAGS) -c begin_window.cpp

neo_gui: main.cpp
	. /usr/local/openmoko/arm/setup-env
	$(GCC_OM_TOOLCHAIN) -o neo_gui main.c $(OM_FLAGS_TOOLCHAIN)

clean:
	rm *.o test neo_gui