import os
import subprocess
from tempfile import mkstemp
from shutil import move
from os import remove, close

######### CHECK IF UPGRADED ###############
#updateToLatest = False
#inputCorrect = False
#while inputCorrect == False:
#    update = raw_input("Do you want to upgrade Raspbian to latest update (might take up to an hour? (Y/n). ")
#    if update == 'Y' or update == 'y' or update == '':
#        updateToLatest = True
#        inputCorrect = True
#    elif update == 'N' or update == 'n':
#        print "NOT checking for updates."
#        inputCorrect = True
#    else:
#        print "Please enter valid input 'y' or 'n'."
#if updateToLatest:
#    print "Checking for new updates..."
#    print subprocess.Popen("sudo apt-get update & sudo apt-get dist-upgrade -y", shell=True, stdout=subprocess.PIPE).stdout.read()

######### CHECK IF THIS PI SHOULD HAVE SERVER ###############
isServer = False
inputCorrect = False
while inputCorrect == False:
    mainBrain = raw_input("Is this Pi the main brain of the alarm system? (Y/n). ")
    if mainBrain == 'Y' or mainBrain == 'y' or mainBrain == '':
        print "you have chosen to use this Pi as main brain in the alarm system."
        isServer = True
        inputCorrect = True
    elif mainBrain == 'N' or mainBrain == 'n':
        print "you have chosen NOT to use this Pi as main brain in the alarm system."
        inputCorrect = True
    else:
        print "Please enter valid input 'y' or 'n'."

print "-----------"
################# APACHE2 ####################################

print "Checking for apache installation..."

apache2path = subprocess.Popen("which apache2", shell=True, stdout=subprocess.PIPE).stdout.read()

if "apache2" not in apache2path:
    print "installing apache web server (might take a while..)"
    print subprocess.Popen("sudo apt-get install apache2 -y", shell=True, stdout=subprocess.PIPE).stdout.read()
else:
    print "apache already installed. Skipping"

print "-----------"

################# PHP ########################################

print "Checking for php installation..."

phpPath = subprocess.Popen("which php", shell=True, stdout=subprocess.PIPE).stdout.read()

if "php" not in phpPath:
    print "installing php  (might take a while..)"
    print subprocess.Popen("sudo apt-get install php5 libapache2-mod-php5 -y", shell=True, stdout=subprocess.PIPE).stdout.read()
else:
    print "php already installed. Skipping"

print "-----------"

################# MOVE PHP PAGE TO RIGHT PLACE ###############

print "about to add php admin page for alarm."
overwrite = False
inputCorrect = False
while inputCorrect == False:
    overwriteInput = raw_input("Overwrite current php config if any (enter 'n' if you have run this install script before)? (Y/n). ")
    if overwriteInput == 'Y' or overwriteInput == 'y' or overwriteInput == '':
        overwrite = True
        inputCorrect = True
    elif overwriteInput == 'N' or overwriteInput == 'n':
        inputCorrect = True
    else:
        print "Please enter valid input 'y' or 'n'."

print "installing php pages in /var/www/html/"

if overwrite:
    print subprocess.Popen("sudo mkdir -p /var/www/html/alarm && sudo cp -R php/* /var/www/html/alarm", shell=True, stdout=subprocess.PIPE).stdout.read()
else:
    print "Copying all files except *.properties and *.txt"
    print subprocess.Popen("cd php && sudo find * -type f -not -iname '*.properties' -a -not -iname '*.txt' -exec cp '{}' '/var/www/html/alarm/{}' ';' && cd ..", shell=True, stdout=subprocess.PIPE).stdout.read()

print "-----------"

#################ALARM FILES, CONFIG ETC######################
alarmPath = "/home/pi/alarm/"

print "about to install alarm application in " + alarmPath

overwrite = False
inputCorrect = False
while inputCorrect == False:
    overwriteInput = raw_input("Overwrite everything? (enter 'n' if you have run this install script before) (Y/n). ")
    if overwriteInput == 'Y' or overwriteInput == 'y' or overwriteInput == '':
        overwrite = True
        inputCorrect = True
    elif overwriteInput == 'N' or overwriteInput == 'n':
        inputCorrect = True
    else:
        print "Please enter valid input 'y' or 'n'."


print "Installing alarm files in " + alarmPath
print subprocess.Popen("mkdir -p " + alarmPath, shell=True, stdout=subprocess.PIPE).stdout.read()

if overwrite:
    print subprocess.Popen("cp -R alarm/* " + alarmPath, shell=True, stdout=subprocess.PIPE).stdout.read()
else:
    print subprocess.Popen("cp -R alarm/sense_motion.py " + alarmPath, shell=True, stdout=subprocess.PIPE).stdout.read()
    print subprocess.Popen("cp -R alarm/truncate_log.sh " + alarmPath, shell=True, stdout=subprocess.PIPE).stdout.read()
    print subprocess.Popen("cp -R alarm/camera.sh " + alarmPath, shell=True, stdout=subprocess.PIPE).stdout.read()
    print subprocess.Popen("cp -R alarm/checkrunning.sh " + alarmPath, shell=True, stdout=subprocess.PIPE).stdout.read()
    print subprocess.Popen("cp -R alarm/copycron.sh " + alarmPath, shell=True, stdout=subprocess.PIPE).stdout.read()

print "Making the alarm application available for the php server"
print subprocess.Popen('sudo chmod 777 ' + alarmPath + '/*', shell=True, stdout=subprocess.PIPE).stdout.read()
print subprocess.Popen('sudo chmod 777 /var/www/html/alarm/admin.properties', shell=True, stdout=subprocess.PIPE).stdout.read()
print subprocess.Popen('sudo chmod 777 /var/www/html/alarm/crontab.txt', shell=True, stdout=subprocess.PIPE).stdout.read()

print "-----------"

################## ADD TO CRONTAB ###########################

addToCrontab = False
inputCorrect = False
while inputCorrect == False:
    addToCron = raw_input("Add useful stuff to crontab? (enter 'n' if you have run this install script before) (Y/n). ")
    if addToCron == 'Y' or addToCron == 'y' or addToCron == '':
        addToCrontab = True
        inputCorrect = True
    elif addToCron == 'N' or addToCron == 'n':
        inputCorrect = True
    else:
        print "Please enter valid input 'y' or 'n'."

if addToCrontab:
    print "Adding to crontab so that network stays up."
    print subprocess.Popen('(crontab -l 2>/dev/null; echo "* * * * * ping 8.8.8.8 -c 1 > /dev/null 2>&1") | crontab -', shell=True, stdout=subprocess.PIPE).stdout.read()
    print subprocess.Popen('(crontab -l 2>/dev/null; echo "* * * * * /home/pi/alarm/checkrunning.sh") | crontab -', shell=True, stdout=subprocess.PIPE).stdout.read()
    
    print subprocess.Popen('(crontab -l 2>/dev/null; echo "3 0 * * * mv /var/www/html/photos/* /var/www/html/photos_backup1/") | crontab -', shell=True, stdout=subprocess.PIPE).stdout.read()
    print subprocess.Popen('(crontab -l 2>/dev/null; echo "2 0 * * 0 mv /var/www/html/photos_backup1/* /var/www/html/photos_backup2/") | crontab -', shell=True, stdout=subprocess.PIPE).stdout.read()
    print subprocess.Popen('(crontab -l 2>/dev/null; echo "1 0 * * 0 rm /var/www/html/photos_backup2/*") | crontab -', shell=True, stdout=subprocess.PIPE).stdout.read()

    if isServer:
        print "Adding to crontab so that logs are truncated."
        print subprocess.Popen('(crontab -l 2>/dev/null; echo "0 0 * * * /home/pi/alarm/truncate_log.sh") | crontab -', shell=True, stdout=subprocess.PIPE).stdout.read()
        print subprocess.Popen('(crontab -l 2>/dev/null; echo "* * * * * /home/pi/alarm/copycron.sh") | crontab -', shell=True, stdout=subprocess.PIPE).stdout.read()

if isServer:
    print "Saving current crontab to crontab.txt"
    print subprocess.Popen('crontab -u pi -l > /var/www/html/alarm/crontab.txt', shell=True, stdout=subprocess.PIPE).stdout.read()



print "-----------"

######### Camera setup #######################################

hasCamera = False
inputCorrect = False
while inputCorrect == False:
    camera = raw_input("Does this unit have an attached camera? (Y/n).")
    if camera == 'Y' or camera == 'y' or camera == '':
        hasCamera = True
        inputCorrect = True
    elif camera == 'N' or camera == 'n':
        inputCorrect = True
    else:
        print "Please enter valid input 'y' or 'n'."

if hasCamera:
    print "Creating photos folder if needed"
    print subprocess.Popen('sudo mkdir -p /var/www/html/photos', shell=True, stdout=subprocess.PIPE).stdout.read()
    print subprocess.Popen('sudo mkdir -p /var/www/html/photos_backup1', shell=True, stdout=subprocess.PIPE).stdout.read()
    print subprocess.Popen('sudo mkdir -p /var/www/html/photos_backup2', shell=True, stdout=subprocess.PIPE).stdout.read()
    print subprocess.Popen('sudo chown www-data:www-data /var/www/html/photos', shell=True, stdout=subprocess.PIPE).stdout.read()

print "-----------"

##############################################################

print
print "Congratulation! Now go to <Your IP>/alarm and fill in all settings."
