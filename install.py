import os
import subprocess
from tempfile import mkstemp
from shutil import move
from os import remove, close

######### CHECK IF UPGRADED ###############
updateToLatest = False
inputCorrect = False
while inputCorrect == False:
    update = raw_input("Do you want to upgrade Raspbian to latest update (might take up to an hour? (Y/n). ")
    if update == 'Y' or update == 'y' or update == '':
        updateToLatest = True
        inputCorrect = True
    elif update == 'N' or update == 'n':
        print "NOT checking for updates."
        inputCorrect = True
    else:
        print "Please enter valid input 'y' or 'n'."
if updateToLatest:
    print "Checking for new updates..."
    print subprocess.Popen("sudo apt-get update & sudo apt-get dist-upgrade -y", shell=True, stdout=subprocess.PIPE).stdout.read()

######### CHECK IF THIS PI SHOULD HAVE SERVER ###############
isServer = False
inputCorrect = False
while inputCorrect == False:
    mainBrain = raw_input("Should this Raspberry Pi run a php server i.e is this Pi the main brain of the alarm system? (Y/n). ")
    if mainBrain == 'Y' or mainBrain == 'y' or mainBrain == '':
        print "you have chosen to use this Pi as main brain in the alarm system."
        isServer = True
        inputCorrect = True
    elif mainBrain == 'N' or mainBrain == 'n':
        print "you have chosen NOT to use this Pi as main brain in the alarm system."
        inputCorrect = True
    else:
        print "Please enter valid input 'y' or 'n'."

################# APACHE2 ####################################

#if isServer:
print "Checking for apache installation..."

apache2path = subprocess.Popen("which apache2", shell=True, stdout=subprocess.PIPE).stdout.read()

if "apache2" not in apache2path:
    print "installing apache web server (might take a while..)"
    print subprocess.Popen("sudo apt-get install apache2 -y", shell=True, stdout=subprocess.PIPE).stdout.read()
else:
    print "apache already installed. Skipping"

print "-----------"

################# PHP ########################################

#if isServer:
print "Checking for php installation..."

phpPath = subprocess.Popen("which php", shell=True, stdout=subprocess.PIPE).stdout.read()

if "php" not in phpPath:
    print "installing php  (might take a while..)"
    print subprocess.Popen("sudo apt-get install php5 libapache2-mod-php5 -y", shell=True, stdout=subprocess.PIPE).stdout.read()
else:
    print "php already installed. Skipping"

print "-----------"

################# MOVE PHP PAGE TO RIGHT PLACE ###############

#if isServer:
    
overwrite = False
inputCorrect = False
while inputCorrect == False:
    overwriteInput = raw_input("Overwrite current config if any (enter 'n' if you have run this install script before)? (Y/n). ")
    if overwriteInput == 'Y' or overwriteInput == 'y' or overwriteInput == '':
        overwrite = True
        inputCorrect = True
    elif overwriteInput == 'N' or overwriteInput == 'n':
        inputCorrect = True
    else:
        print "Please enter valid input 'y' or 'n'."

print "adding php admin page for alarm."
print "installing php pages in /var/www/html/"

if overwrite:
    print subprocess.Popen("sudo mkdir -p /var/www/html/alarm && sudo cp -R php/* /var/www/html/alarm", shell=True, stdout=subprocess.PIPE).stdout.read()
    print "-----------"
else:
    print "Copying all files except *.properties and *.txt"
    print subprocess.Popen("cd php && sudo find * -type f -not -iname '*.properties' -a -not -iname '*.txt' -exec cp '{}' '/var/www/html/alarm/{}' ';' && cd ..", shell=True, stdout=subprocess.PIPE).stdout.read()

#################ALARM FILES, CONFIG ETC######################
alarmPath = "/home/pi/alarm/"

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

if isServer:
    print "Making the alarm application available for the php server"
    print subprocess.Popen('sudo chmod 777 ' + alarmPath + '/*', shell=True, stdout=subprocess.PIPE).stdout.read()
    print subprocess.Popen('sudo chmod 777 /var/www/html/alarm/admin.properties', shell=True, stdout=subprocess.PIPE).stdout.read()
    print subprocess.Popen('sudo chmod 777 /var/www/html/alarm/crontab.txt', shell=True, stdout=subprocess.PIPE).stdout.read()

################## ADD TO CRONTAB ###########################

addToCrontab = False
inputCorrect = False
while inputCorrect == False:
    addToCron = raw_input("Add useful stuff to crontab (enter 'n' if you have run this install script before)? (Y/n). ")
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

    if isServer:
        print "Adding to crontab so that logs are truncated."
        print subprocess.Popen('(crontab -l 2>/dev/null; echo "0 0 * * * /home/pi/alarm/truncate_log.sh") | crontab -', shell=True, stdout=subprocess.PIPE).stdout.read()

if isServer:
    print "Saving current crontab to crontab.txt"
    print subprocess.Popen('crontab -u pi -l > /var/www/html/alarm/crontab.txt', shell=True, stdout=subprocess.PIPE).stdout.read()


######### rc.local MAKE SENSE MOTION SCRIPT START AT BOOT ####

print "Adding sense_motion.py to rc.local to start up during Pi boot."

#Create temp file
fh, abs_path = mkstemp()
abort = False
with open(abs_path,'w') as new_file:
    with open('/etc/rc.local') as old_file:
        for line in old_file:
            if "sense_motion.py" in line:
                abort = True
                break
            if line.startswith("exit 0"):
                new_file.write("(sleep 10;python " + alarmPath + "sense_motion.py " + "'" + alarmPath + "'" + ")&" + '\n')
            new_file.write(line)
close(fh)
if not abort:
    # Remove original file
    print subprocess.Popen('sudo rm /etc/rc.local', shell=True, stdout=subprocess.PIPE).stdout.read()
    #  Move new file
    print subprocess.Popen('sudo mv ' + abs_path  + ' /etc/rc.local', shell=True, stdout=subprocess.PIPE).stdout.read()
    print subprocess.Popen('sudo chmod 777 /etc/rc.local', shell=True, stdout=subprocess.PIPE).stdout.read()
else:
    print subprocess.Popen('sudo rm ' + abs_path, shell=True, stdout=subprocess.PIPE).stdout.read()

##############################################################

print
print "Congratulation! Now go to " + alarmPath + "settings.properties and fill in the necessary data."
