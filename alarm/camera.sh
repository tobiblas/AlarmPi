#!/bin/bash

DATE=$(date +"%Y-%m-%d_%H%M%S")

raspistill -vf -hf -w 648 -h 486 -q 50 -o /var/www/html/photos/2018_0%d.jpg -tl 1000 -t 3000 -dt
