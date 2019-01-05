import json

with open('/var/www/html/web/data/setup.json') as json_data:
	data_dict = json.load(json_data)
date = data_dict["date"]

print(date)
