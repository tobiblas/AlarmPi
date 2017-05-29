#!/bin/bash

DATE=$(date +"%Y-%m-%d_%H%M%S")

raspistill -t 2500 -vf -hf -w 648 -h 486 -q 50 -o /var/www/html/photos/$DATE.jpg

