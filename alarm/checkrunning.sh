#!/bin/sh
SERVICE='sense_motion'
 
if ps ax | grep -v grep | grep $SERVICE > /dev/null
then
    #echo "$SERVICE service running, everything is fine"
    exit 0
else
    echo "$SERVICE is not running. starting it up!"
    python /home/pi/alarm/sense_motion.py > /home/pi/output.log 2>&1
    exit 1
fi
