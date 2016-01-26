# -*- coding: utf-8 -*-
from __future__ import with_statement
from subprocess import call
import time
import sys
import urllib2
import RPi.GPIO as GPIO

def triggerAlarm():
    print "The alarm went off. Trigger php server"
    
    myprops = {}
    with open('settings.properties', 'r') as f:
        for line in f:
            line = line.rstrip() #removes trailing whitespace and '\n' chars
            
            if ":" not in line: continue #skips blanks and comments w/o =
            if line.startswith("#"): continue #skips comments which contain =
            
            k, v = line.split(":", 1)
            myprops[k] = v
    print myprops

#if alarmOn and (myprops['sound'].strip() == 'true' or myprops['sms'].strip() == 'true'):
#        print "triggering android app"
#        message = "Alarm triggered. DetectorID = " + ""
#        messageToAndroidApp(myprops['sound'].strip() == 'true',
#                        myprops['sms'].strip() == 'true',
#                        message,
#                        myprops['phonenumbers'].strip())
#    else:
#        print "system not configured to use phone or alarm is off"

    # trigger call to php server
    url = myprops['serverURL'].strip() + 'trigger_alarm.php?triggerID=' + myprops['detectorID'].strip()
    print "calling " + url
    response = urllib2.urlopen(url)
    if not response.code == 200:
        print "ERROR! Did not get 200 response"
    response.close()



GPIO.setmode(GPIO.BCM)
PIR_PIN = 7
LED_PIN = 8
GPIO.setup(PIR_PIN, GPIO.IN)
GPIO.setup(LED_PIN, GPIO.OUT)
GPIO.output(LED_PIN, False)


def MOTION(PIR_PIN):
    print 'Motion Detected!'
    GPIO.output(LED_PIN, True)

    triggerAlarm()
    
    time.sleep(3)
    GPIO.output(LED_PIN, False)
               

print 'Motion detection script loaded (CTRL+C to exit)'
print 'Ready'

try:
               GPIO.add_event_detect(PIR_PIN, GPIO.RISING, callback=MOTION)
               while 1:
                              time.sleep(100)
except KeyboardInterrupt:
               print ' Quit'
               GPIO.cleanup()
