# -*- coding: utf-8 -*-
from __future__ import with_statement
from subprocess import call
import time
import sys

def triggerAlarm(alarmOn):
    print "The alarm went off. Trigger php server and phone if configured"
    
    myprops = {}
    with open('settings.properties', 'r') as f:
        for line in f:
            line = line.rstrip() #removes trailing whitespace and '\n' chars
            
            if ":" not in line: continue #skips blanks and comments w/o =
            if line.startswith("#"): continue #skips comments which contain =
            
            k, v = line.split(":", 1)
            myprops[k] = v
    print myprops

    if alarmOn and (myprops['sound'].strip() == 'true' or myprops['sms'].strip() == 'true'):
        print "triggering android app"
    
    #               call(["adb","shell", "am", "force-stop", "com.tobiblas.alarmpusher"])
    #               call(["adb", "shell", "am", "start", "-a", "android.intent.action.VIEW", "-n", "com.tobiblas.alarmpusher/.MainActivity", "-e" ,"phonenumbers", "'+46760732005'", "-e", "message", "'Nämen! Nu tror jag tamigfasen att larmet gick'"])
        #TODO: the call above
    
    else:
        print "system not configured to use phone or alarm is off"


# todo trigger call to php server
    sys.exit()


triggerAlarm(True)

import RPi.GPIO as GPIO

GPIO.setmode(GPIO.BCM)
PIR_PIN = 7
LED_PIN = 8
GPIO.setup(PIR_PIN, GPIO.IN)
GPIO.setup(LED_PIN, GPIO.OUT)
GPIO.output(LED_PIN, False)


def MOTION(PIR_PIN):
    print 'Motion Detected!'
    GPIO.output(LED_PIN, True)

    with open('myfile.txt', 'r') as f:
        first_line = f.readline().strip()
        if "true" in first_line:
            #ALARM IS ON!
            triggerAlarm(True)
        else:
            triggerAlarm(False)

    time.sleep(3)
    GPIO.output(LED_PIN, False)
               

print 'PIR Module Test (CTRL+C to exit)'
time.sleep(2)
print 'Ready'

try:
               GPIO.add_event_detect(PIR_PIN, GPIO.RISING, callback=MOTION)
               while 1:
                              time.sleep(100)
except KeyboardInterrupt:
               print ' Quit'
               GPIO.cleanup()
