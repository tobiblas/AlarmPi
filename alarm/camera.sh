#!/bin/bash

mkdir -p /var/www/html/alarm/photos

DATE=$(date +"%Y-%m-%d_%H%M")

raspistill -o /home/pi/alarm/photos/$DATE.jpg
