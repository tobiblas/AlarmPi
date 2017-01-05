#!/bin/sh

# Input file
FILE=/var/www/html/alarm/crontab.txt
CHANGETIME=300
# Get current and file times
CURTIME=$(date +%s)
FILETIME=$(stat $FILE -c %Y)
TIMEDIFF=$(expr $CURTIME - $FILETIME)

# Check if file older
if [ $TIMEDIFF -lt $CHANGETIME ]; then
echo "File changed last minutes"
crontab -r -u pi;
crontab -u pi /var/www/html/alarm/crontab.txt
fi
