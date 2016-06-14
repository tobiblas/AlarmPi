#!/bin/bash
head -n 100 /home/pi/alarm/ALARMLOG.txt > /home/pi/alarm/ALARMLOG_.txt; mv /home/pi/alarm/ALARMLOG_.txt /home/pi/alarm/ALARMLOG.txt; chmod 777 /home/pi/alarm/ALARMLOG.txt
