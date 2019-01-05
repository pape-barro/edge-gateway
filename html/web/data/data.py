#!/usr/bin/python
from influxdb import InfluxDBClient
import json

with open('/var/www/html/web/data/setup.json') as json_data:
        data_dict = json.load(json_data)
data = data_dict["date"]

date=data+"T23:59:59Z";
client = InfluxDBClient(host="127.0.0.1", port="8086", username="admin", password="dbpassword", database="telegraf")

cpu="delete from cpu where time < \'"+date+"\'"
disk="delete from disk where time < \'"+date+"\'"
diskio="delete from diskio where time < \'"+date+"\'"
kernel="delete from kernel where time < \'"+date+"\'"
mem="delete from mem where time < \'"+date+"\'"
processes="delete from processes where time < \'"+date+"\'"
swap="delete from swap where time < \'"+date+"\'"
system="delete from system where time < \'"+date+"\'"
mqtt_consumer="delete from mqtt_consumer where time < \'"+date+"\'"
test ="SELECT * from mqtt_consumer where time < \'"+date+"\' limit 10"

result = client.query(cpu)
result = client.query(disk)
result = client.query(diskio)
result = client.query(kernel)
result = client.query(mem)
result = client.query(processes)
result = client.query(swap)
result = client.query(system)
result = client.query(mqtt_consumer)

result = client.query(test)
print (result)
