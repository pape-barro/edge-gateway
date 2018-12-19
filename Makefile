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
	sudo chmod 777 /opt/edge-gateway/
	sudo rm -rf /var/www/html
	sudo cp -rf /opt/edge-gateway/html /var/www/
	sudo chmod 777 /var/www/html/web/utils/app.txt
	sudo chmod 777 /var/www/html/web/utils/log.json
	sudo chmod 777 /var/www/html/web/utils/log.json
	sudo chmod 777 /opt/edge-gateway/global_conf.json
	sudo apt-get update && sudo apt-get install mosquitto mosquitto-clients redis-server redis-tools postgresql
	sudo apt-get update && sudo apt install apt-transport-https curl
	
mod:
	sudo apt-get update && sudo apt-get install apt-transport-https dirmngr
	sudo apt-key adv --keyserver keyserver.ubuntu.com --recv-keys 1CE2AFD36DBCCA00
	sudo echo "deb https://artifacts.loraserver.io/packages/2.x/deb stable main" | sudo tee /etc/apt/sources.list.d/loraserver.list
	sudo apt-get update
	sudo apt-get install lora-gateway-bridge
	sudo systemctl start lora-gateway-bridge
	sudo systemctl enable lora-gateway-bridge
	sudo apt-get install loraserver
	sudo chmod 777 /etc/loraserver/
	sudo chmod 777 /etc/loraserver/loraserver.toml
	sudo rm -f /etc/loraserver/loraserver.toml
	sudo cp -f ./modules/loraserver.toml /etc/loraserver/
	sudo systemctl start loraserver
	sudo systemctl enable loraserver
	sudo apt-get install lora-app-server
	sudo chmod 777 /etc/lora-app-server/
	sudo chmod 777 /etc/lora-app-server/lora-app-server.toml
	sudo rm -f /etc/lora-app-server/lora-app-server.toml
	sudo cp -f ./modules/lora-app-server.toml /etc/lora-app-server/
	sudo systemctl start lora-app-server
	sudo systemctl enable lora-app-server
	curl -sL https://repos.influxdata.com/influxdb.key | sudo apt-key add -
	sudo apt-get update && sudo apt-get install telegraf
	sudo chmod 777 /etc/telegraf/
	sudo chmod 777 /etc/telegraf/telegraf.conf
	sudo rm -f /etc/telegraf/telegraf.conf
	sudo cp -f ./modules/telegraf.conf /etc/telegraf/
	sudo apt-get update && sudo apt-get install influxdb
	sudo chmod 777 /etc/influxdb/
	sudo chmod 777 /etc/influxdb/influxdb.conf
	sudo rm -f /etc/influxdb/influxdb.conf
	sudo cp -f ./modules/influxdb.conf /etc/influxdb/influxdb.conf
	sudo apt-get update && sudo wget https://github.com/fg2it/grafana-on-raspberry/releases/download/v4.2.0/grafana_4.2.0_armhf.deb
	sudo dpkg -i grafana_4.2.0_armhf.deb
	sudo systemctl enable influxdb
	sudo systemctl start influxdb
	sudo systemctl enable telegraf
	sudo systemctl start telegraf
	sudo systemctl enable grafana-server
	sudo systemctl start grafana-server
	sudo apt-get update 
	sudo apt-get install dnsmasq hostapd
	sudo systemctl stop hostapd
	sudo systemctl stop dnsmasq
	sudo chmod 777 /etc/
	sudo chmod 777 /etc/dhcpcd.conf
	sudo rm -f /etc/dhcpcd.conf
	sudo cp -f ./modules/dhcpcd.conf /etc/
	sudo chmod 777 /etc/network/
	sudo chmod 777 /etc/network/interfaces
	sudo rm -f /etc/network/interfaces
	sudo cp -f ./modules/interfaces /etc/network/
	sudo chmod 777 /etc/hostapd/
	sudo cp -f ./modules/hostapd.conf /etc/hostapd/
	sudo chmod 777 /etc/default/
	sudo chmod 777 /etc/default/hostapd
	sudo rm -f /etc/default/hostapd
	sudo cp -f ./modules/hostapd /etc/default/
	sudo chmod 777 /etc/dnsmasq.conf
	sudo rm -f /etc/dnsmasq.conf
	sudo cp -f ./modules/dnsmasq.conf /etc/
	sudo chmod 777 /etc/sysctl.conf
	sudo rm -f /etc/sysctl.conf
	sudo cp -f ./modules/sysctl.conf /etc/
	sudo iptables -t nat -A POSTROUTING -o eth0 -j MASQUERADE
	sudo sh -c "iptables-save > /etc/iptables.ipv4.nat"
	sudo chmod 777 /etc/rc.local
	sudo rm -f /etc/rc.local
	sudo cp -f ./modules/rc.local /etc/
	sudo apt-get install bridge-utils
	sudo brctl addbr br0
	sudo brctl addif br0 eth0
	sudo systemctl start hostapd
	sudo systemctl start dnsmasq
	
fireup:
	sudo apt-get update
	sudo apt-get upgrade
	sudo systemctl restart influxdb
	sudo reboot
