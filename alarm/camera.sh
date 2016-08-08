#!/bin/bash

DATE=$(date +"%Y-%m-%d_%H%M%S")

raspistill -o /var/www/html/photos/$DATE.jpg
