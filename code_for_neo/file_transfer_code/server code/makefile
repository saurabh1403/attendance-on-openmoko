
SRC = server.c

GCC = gcc
GCC_OM = /home/saurabhg/moko/build/tmp/cross/arm-angstrom-linux-gnueabi/bin/gcc

test: ${SRC}
	$(GCC)  -lm -o $@ ${SRC}

neo_test: ${SRC}
	$(GCC_OM) -lm -o $@ ${SRC}


clean:
	rm test neo_test
