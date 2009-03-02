
SRC = client.cpp

GCC = g++
GCC_OM = /home/saurabhg/moko/build/tmp/cross/arm-angstrom-linux-gnueabi/bin/g++

all: test neo_test

test: ${SRC}
	$(GCC)  -lm -o $@  ${SRC}

neo_test: ${SRC}
	$(GCC_OM) -lm -o $@ ${SRC}


clean:
	rm test neo_test
