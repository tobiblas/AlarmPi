#!/bin/bash

DATE=$(date +"%Y-%m-%d_%H%M%S")

raspistill -t 2500 -o /var/www/html/photos/$DATE.jpg
