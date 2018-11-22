Single Channel LoRaWAN Edge-Gateway
==============================
```
[ A multi-services and multi-optional gateway for communities ]
{ IN PROGRESS ...}
```
This repository contains a proof-of-concept implementation of a single
channel LoRaWAN gateway.

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
```

Added new Features:
------------------
```
- Web repository for graphical setting
```
 on `global_conf.json`:
	---
```
- adapted for the use of uputronics board CE1 activity, Internet and Lan sensing leds;
- extended for the use of lora gateway bridge locally or remotely;
```
 
 on `gsingle_chan_pkt_fwd.service`
	---
```
- changed WorkingDirectory by '/opt/edge-gateway/'
- changed ExecStart by '/opt/edge-gateway/single_chan_pkt_fwd'
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
$ make
$ sudo make install
$ sudo apt-get update
$ sudo apt-get install apache2 php libapache2-mod-php
```

To start service (should already be started at boot if you done make install and rebooted of course), stop service or look service status:
------------------------------------------------------------------------------------------------------------------------------------------
```
$ systemctl start single_chan_pkt_fwd
$ systemctl stop single_chan_pkt_fwd
$ systemctl status single_chan_pkt_fwd
```

To see gateway log in real time:
-------------------------------
```
$ journalctl -f -u single_chan_pkt_fwd
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
 

