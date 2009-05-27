
GCC = g++
GCC_OM = /home/saurabhg/moko/build/tmp/cross/arm-angstrom-linux-gnueabi/bin/g++
#GCC_OM_TOOLCHAIN = ${CXX}
GCC_OM_TOOLCHAIN = /usr/local/openmoko/arm/arm-angstrom-linux-gnueabi/bin/g++


OM_COMPILER_USED = $(GCC_OM_TOOLCHAIN)
OM_FLAGS_USED = $(OM_FLAGS_TOOLCHAIN)
OM_FLAGS_USED_C = $(MY_FLAGS_C)


OBJ = attendance.o combo.o main.o utils.o send_file.o begin_window.o notes.o notes_list.o final_window.o
OBJ_OM = attendance_OM.o combo_OM.o main_OM.o utils_OM.o send_file_OM.o begin_window_OM.o


MY_FLAGS =  `pkg-config --cflags --libs gtk+-2.0 libglade-2.0` -export-dynamic
MY_FLAGS_C = `pkg-config --cflags gtk+-2.0 libglade-2.0` -export-dynamic


OM_FLAGS= -L /home/saurabhg/moko/build/tmp/staging/arm-angstrom-linux-gnueabi/lib/ -Wl, \
 	 /home/saurabhg/moko/build/tmp/staging/arm-angstrom-linux-gnueabi/usr/lib/ -Wl, \
	 `/home/saurabhg/moko/build/tmp/staging/i686-linux/usr/bin/pkg-config --cflags --libs gtk+-2.0` 


OM_FLAGS_TOOLCHAIN = \
	`pkg-config --cflags --libs gtk+-2.0 libglade-2.0` -export-dynamic

INCLUDE_DIR = ../include/

test: $(OBJ)
	$(GCC) $(MY_FLAGS) -o $@ $(OBJ)

attendance.o: attendance.cpp $(INCLUDE_DIR)attendance.h
	$(GCC) -I$(INCLUDE_DIR) $(MY_FLAGS_C) -c  attendance.cpp 

combo.o: combo.cpp $(INCLUDE_DIR)combo.h
	$(GCC) -I$(INCLUDE_DIR) $(MY_FLAGS_C) -c  combo.cpp

main.o: main.cpp $(INCLUDE_DIR)include.h
	$(GCC) -I$(INCLUDE_DIR) $(MY_FLAGS_C) -c  main.cpp

utils.o: utils.cpp $(INCLUDE_DIR)utils.h
	$(GCC) -I$(INCLUDE_DIR) $(MY_FLAGS_C) -c  utils.cpp

notes.o: notes.cpp $(INCLUDE_DIR)notes.h
	$(GCC) -I$(INCLUDE_DIR) $(MY_FLAGS_C) -c  notes.cpp
	
notes_list.o: notes_list.cpp $(INCLUDE_DIR)notes_list.h
	$(GCC) -I$(INCLUDE_DIR) $(MY_FLAGS_C) -c  notes_list.cpp

send_file.o: send_file.cpp $(INCLUDE_DIR)send_file.h
	$(GCC) -I$(INCLUDE_DIR) -lm -c send_file.cpp

begin_window.o: begin_window.cpp $(INCLUDE_DIR)begin_window.h
	$(GCC) -I$(INCLUDE_DIR) $(MY_FLAGS) -c begin_window.cpp

final_window.o: begin_window.cpp $(INCLUDE_DIR)final_window.h
	$(GCC) -I$(INCLUDE_DIR) $(MY_FLAGS) -c final_window.cpp

#build commands for openmoko

neo_gui: $(OBJ_OM)
	. /usr/local/openmoko/arm/bin/setup-env
	$(GCC_OM_TOOLCHAIN) -o $@ $(OBJ_OM) $(OM_FLAGS_USED)

attendance_OM.o: attendance.cpp $(INCLUDE_DIR)attendance.h
	$(OM_COMPILER_USED) -I$(INCLUDE_DIR) $(OM_FLAGS_USED) -c  attendance.cpp -o attendance_OM.o

combo_OM.o: combo.cpp $(INCLUDE_DIR)combo.h
	$(OM_COMPILER_USED) -I$(INCLUDE_DIR) $(OM_FLAGS_USED) -c combo.cpp -o combo_OM.o

main_OM.o: main.cpp $(INCLUDE_DIR)include.h
	$(OM_COMPILER_USED) -I$(INCLUDE_DIR) $(OM_FLAGS_USED) -c  main.cpp -o main_OM.o

utils_OM.o: utils.cpp $(INCLUDE_DIR)utils.h
	$(OM_COMPILER_USED) -I$(INCLUDE_DIR) $(OM_FLAGS_USED) -c  utils.cpp -o utils_OM.o

send_file_OM.o: send_file.cpp $(INCLUDE_DIR)send_file.h
	$(OM_COMPILER_USED) -I$(INCLUDE_DIR) $(OM_FLAGS_USED) -lm -c send_file.cpp -o send_file_OM.o

begin_window_OM.o: begin_window.cpp $(INCLUDE_DIR)begin_window.h
	$(OM_COMPILER_USED) -I$(INCLUDE_DIR) $(OM_FLAGS_USED) -c begin_window.cpp -o begin_window_OM.o

clean:
	rm *.o *_OM.o test neo_gui

