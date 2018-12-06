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
	
modules:
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
	
	
	
	
	
------------
------------
------------
------------
------------	
	
	
	



Single Channel LoRaWAN Edge-Gateway
==============================
```
[ A single channel LoRaWAN multi-services and multi-optional gateway for communities ]
```
This repository contains a proof-of-concept implementation of a single
channel LoRaWAN multi-services and multi-optional gateway for communities. (the proof-of-concept for the eight is available on : https://github.com/pape-barro/eight_chan_lorawan_edge_gateway).

It has been tested on the Raspberry Pi platform, using a Semtech SX1272
transceiver (HopeRF RFM92W), and SX1276 (HopeRF RFM95W).

The code is for testing and development purposes only, and is not meant
for production usage.

Maintainer: Pape Abdoulaye BARRO  <pape.abdoulaye.barro@gmail.com>

inspired on:
------------
```
- https://github.com/hallard/single_chan_pkt_fwd
- https://github.com/bokse001/dual_chan_pkt_fwd/blob/master/README.md
- https://www.loraserver.io/guides/debian-ubuntu/
```

Added new Features:
------------------

on `Makefile`:
	
```
- added graphic command;
- added modules command;
- added fireup command;
```

 on `global_conf.json`:
	
```
- adapted for the use of uputronics board CE1 activity, Internet and Lan sensing leds;
- extended for the use of lora gateway bridge locally or remotely;
```
 
 on `single_chan_pkt_fwd.service`:
	
```
- changed WorkingDirectory by '/opt/edge-gateway/'
- changed ExecStart by '/opt/edge-gateway/single_chan_pkt_fwd'
```
 Added repositories:

```
- html repository for graphical setting
- modules repository ( loraserver, TIG and access point ) for Isolated network
```

Raspberry PI pin mapping is as follow and pin number in file `global_conf.json` are WiringPi pin number (wPi colunm):
--------------------------------------------------------------------------------------------------------------------

```
root@pi04 # gpio readall
+-----+-----+---------+--B Plus--+---------+-----+-----+
| BCM | wPi |   Name  | Physical | Name    | wPi | BCM |
+-----+-----+---------+----++----+---------+-----+-----+
|     |     |    3.3v |  1 || 2  | 5v      |     |     |
|   2 |   8 |   SDA.1 |  3 || 4  | 5V      |     |     |
|   3 |   9 |   SCL.1 |  5 || 6  | 0v      |     |     |
|   4 |   7 | GPIO. 7 |  7 || 8  | TxD     | 15  | 14  |
|     |     |      0v |  9 || 10 | RxD     | 16  | 15  |
|  17 |   0 | GPIO. 0 | 11 || 12 | GPIO. 1 | 1   | 18  |
|  27 |   2 | GPIO. 2 | 13 || 14 | 0v      |     |     |
|  22 |   3 | GPIO. 3 | 15 || 16 | GPIO. 4 | 4   | 23  |
|     |     |    3.3v | 17 || 18 | GPIO. 5 | 5   | 24  |
|  10 |  12 |    MOSI | 19 || 20 | 0v      |     |     |
|   9 |  13 |    MISO | 21 || 22 | GPIO. 6 | 6   | 25  |
|  11 |  14 |    SCLK | 23 || 24 | CE0     | 10  | 8   |
|     |     |      0v | 25 || 26 | CE1     | 11  | 7   |
|   0 |  30 |   SDA.0 | 27 || 28 | SCL.0   | 31  | 1   |
|   5 |  21 | GPIO.21 | 29 || 30 | 0v      |     |     |
|   6 |  22 | GPIO.22 | 31 || 32 | GPIO.26 | 26  | 12  |
|  13 |  23 | GPIO.23 | 33 || 34 | 0v      |     |     |
|  19 |  24 | GPIO.24 | 35 || 36 | GPIO.27 | 27  | 16  |
|  26 |  25 | GPIO.25 | 37 || 38 | GPIO.28 | 28  | 20  |
|     |     |      0v | 39 || 40 | GPIO.29 | 29  | 21  |
+-----+-----+---------+----++----+---------+-----+-----+
| BCM | wPi |   Name  | Physical | Name    | wPi | BCM |
+-----+-----+---------+--B Plus--+---------+-----+-----+
```

* For Uputronics Raspberry Pi 3 B+ LoRa(TM) Expansion Board pins configuration in file global_conf.json:
---------------------------------------------------------------------------------------------------
```
  "freq": 868300000,
  "spread_factor": 7,
  "pin_nss": 11,
  "pin_dio0": 27,
  "pin_rst": 0,
  "pin_NetworkLED": 22,
  "pin_InternetLED": 23,
  "pin_ActivityLED_0": 21,
  "pin_ActivityLED_1": 29,
```

Installation
------------
```
$ cd /opt/
$ sudo git clone https://github.com/pape-barro/edge-gateway.git
$ cd /opt/edge-gateway/
$ sudo make
$ sudo make install
$ sudo make graphic
$ sudo -u postgres psql
	> create role loraserver_as with login password 'dbpassword';
	> create role loraserver_ns with login password 'dbpassword';
	> create database loraserver_as with owner loraserver_as;
	> create database loraserver_ns with owner loraserver_ns;
	> \c loraserver_as
	> create extension pg_trgm;
	> \q
```
find the version of raspbian and choise:
```
$ echo "deb https://repos.influxdata.com/debian jessie stable" | sudo tee /etc/apt/sources.list.d/influxdb.list
```
OR:
```
echo "deb https://repos.influxdata.com/debian stretch stable" | sudo tee /etc/apt/sources.list.d/influxdb.list
```
next:
```
$ sudo make modules
$ influx
	> CREATE USER admin WITH PASSWORD 'dbpassword' WITH ALL PRIVILEGES
	> CREATE DATABASE telegraf
	> exit
$ fireup

```
To find out which version of raspbian you’re running
-------------
```
$ cat /etc/os-release
```

To start service (should already be started at boot if you done make install and rebooted of course), stop service or look service status:
------------------------------------------------------------------------------------------------------------------------------------------
```
$ sudo systemctl start single_chan_pkt_fwd
$ sudo systemctl stop single_chan_pkt_fwd
$ sudo systemctl status single_chan_pkt_fwd
```

To see packet forwarder log in real time:
-------------------------------
```
$ sudo journalctl -f -u single_chan_pkt_fwd
```
To see LoRa-gateway-bridge log-output:
-------------------------------
```
$ sudo journalctl -u lora-gateway-bridge -f -n 50
```
To see LoRa Server log-output:
-------------------------------
```
$ sudo journalctl -f -n 100 -u loraserver
```
To see LoRa App Server log-output:
-------------------------------
```
$ sudo journalctl -f -n 100 -u lora-app-server
```

Dependencies
------------
```
- SPI needs to be enabled on the Raspberry Pi (use raspi-config)
- WiringPi: a GPIO access library written in C for the BCM2835
  used in the Raspberry Pi.
  sudo apt-get install wiringpi
  see http://wiringpi.com
- Run packet forwarder as root
```

License
-------
```
The source files in this repository are made available under the Eclipse Public License v1.0, except:
- base64 implementation, that has been copied from the Semtech Packet Forwarder;
- RapidJSON, licensed under the MIT License.
```
 


