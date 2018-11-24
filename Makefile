# single_chan_pkt_fwd
# Single Channel LoRaWAN Gateway

CC = g++
CFLAGS = -std=c++11 -c -Wall -I include/
LIBS = -lwiringPi

all: single_chan_pkt_fwd

single_chan_pkt_fwd: base64.o single_chan_pkt_fwd.o
	$(CC) single_chan_pkt_fwd.o base64.o $(LIBS) -o single_chan_pkt_fwd

single_chan_pkt_fwd.o: single_chan_pkt_fwd.cpp
	$(CC) $(CFLAGS) single_chan_pkt_fwd.cpp

base64.o: base64.c
	$(CC) $(CFLAGS) base64.c

clean:
	rm *.o single_chan_pkt_fwd

install:
	sudo cp -f ./single_chan_pkt_fwd.service /lib/systemd/system/
	sudo systemctl enable single_chan_pkt_fwd.service
	sudo systemctl daemon-reload
	sudo systemctl start single_chan_pkt_fwd
	sudo systemctl status single_chan_pkt_fwd -l

uninstall:
	sudo systemctl stop single_chan_pkt_fwd
	sudo systemctl disable single_chan_pkt_fwd.service
	sudo rm -f /lib/systemd/system/single_chan_pkt_fwd.service 
	
graphic:
	sudo apt-get update
	sudo apt-get install apache2 php libapache2-mod-php
	sudo chmod 777 /var/www/
	sudo rm -f /var/www/html
	sudo cp -f ./html /var/www/
	sudo chmod 777 /var/www/html/web/utils/app.txt
	sudo chmod 777 /var/www/html/web/utils/log.json
	sudo chmod 777 /var/www/html/web/utils/log.json
	sudo chmod 777 /opt/edge-gateway/global_conf.json
	
modules:
	
	
	
	
	
	
