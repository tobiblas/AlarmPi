#!/bin/sh
 
if [ $(cat /var/www/html/alarm/crontab.txt | wc -l) -gt "0" ]; then 
	crontab -r -u pi; 
	crontab /var/www/html/alarm/crontab.txt && > /var/www/html/alarm/crontab.txt; 
fi

