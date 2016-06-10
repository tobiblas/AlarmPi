#!/bin/bash
head -n 100 ALARMLOG.txt > ALARMLOG_.txt; mv ALARMLOG_.txt ALARMLOG.txt; chmod 755 ALARMLOG.txt
