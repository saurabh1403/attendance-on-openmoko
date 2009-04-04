GCC = gcc
GCC_OM = /home/saurabhg/moko/build/tmp/cross/arm-angstrom-linux-gnueabi/bin/gcc
GCC_OM_TOOLCHAIN = /usr/local/openmoko/arm/arm-angstrom-linux-gnueabi/bin/gcc

SRC = main.c

MY_FLAGS = -lm -Wall `pkg-config --cflags --libs gtk+-2.0 libglade-2.0` -export-dynamic
OM_FLAGS = -lm -Wall `pkg-config --cflags --libs libglade-2.0` -export-dynamic

all: test neo_gui

test: ${SRC}
	export PKG_CONFIG_PATH="/usr/lib/pkgconfig/"
	$(GCC) -o test ${SRC}  $(MY_FLAGS)

neo_gui: ${SRC}
	. /usr/local/openmoko/arm/bin/setup-env
	$(GCC_OM_TOOLCHAIN) -I/usr/local/openmoko/arm/usr/include  -o neo_gui ${SRC}  $(OM_FLAGS) 


clean:
	rm test neo_gui



