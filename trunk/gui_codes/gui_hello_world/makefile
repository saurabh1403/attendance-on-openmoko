GCC = gcc
GCC_OM = /home/saurabhg/moko/build/tmp/cross/arm-angstrom-linux-gnueabi/bin/gcc
GCC_OM_TOOLCHAIN = /usr/local/openmoko/arm/arm-angstrom-linux-gnueabi/bin/gcc

MY_FLAGS = -lm -Wall `pkg-config --cflags --libs gtk+-2.0`

OM_FLAGS= -L /home/saurabhg/moko/build/tmp/staging/arm-angstrom-linux-gnueabi/lib/ -Wl, \
 	 /home/saurabhg/moko/build/tmp/staging/arm-angstrom-linux-gnueabi/usr/lib/ -Wl, \
	 `/home/saurabhg/moko/build/tmp/staging/i686-linux/usr/bin/pkg-config --cflags --libs gtk+-2.0` 

OM_FLAGS_TOOLCHAIN = \
	`pkg-config --cflags --libs gtk+-2.0`

test: main.c
	$(GCC) $(MY_FLAGS)  -o test main.c 

neo_gui: main.c
	. /usr/local/openmoko/arm/setup-env
	$(GCC_OM_TOOLCHAIN) -o neo_gui main.c $(OM_FLAGS_TOOLCHAIN)

clean:
	rm test neo_gui
