GCC = g++
GCC_OM = /home/saurabhg/moko/build/tmp/cross/arm-angstrom-linux-gnueabi/bin/g++
GCC_OM_TOOLCHAIN = /usr/local/openmoko/arm/arm-angstrom-linux-gnueabi/bin/g++

#GCC_OM_TOOLCHAIN = $(CXX)

INCLUDE_DIR = -I/usr/local/openmoko/arm/arm-angstrom-linux-gnueabi/usr/include/c++/4.1.2

SRC = main.cpp

#MY_FLAGS = -lm -Wall `pkg-config --cflags --libs gtk+-2.0`
MY_FLAGS = -lm -Wall `pkg-config --cflags --libs gtkmm-2.4`

OM_FLAGS= -L /home/saurabhg/moko/build/tmp/staging/arm-angstrom-linux-gnueabi/lib/ -Wl, \
 	 /home/saurabhg/moko/build/tmp/staging/arm-angstrom-linux-gnueabi/usr/lib/ -Wl, \
	 `/home/saurabhg/moko/build/tmp/staging/i686-linux/usr/bin/pkg-config --cflags --libs gtk+-2.0` 

OM_FLAGS_TOOLCHAIN = \
	`pkg-config --cflags --libs gtk+-2.0`

test: $(SRC)
	$(GCC) $(MY_FLAGS)  -o test $(SRC)

neo_gui: $(SRC)
	. /usr/local/openmoko/arm/bin/setup-env
	$(GCC_OM_TOOLCHAIN) -o neo_gui $(SRC) ${OM_FLAGS_TOOLCHAIN}

clean:
	rm test neo_gui

