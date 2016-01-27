import os
import subprocess

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

if isServer:
    print "Checking for apache installation..."

    apache2path = subprocess.Popen("which apache2", shell=True, stdout=subprocess.PIPE).stdout.read()

    if "apache2" not in apache2path:
        print "installing apache web server."
        print subprocess.Popen("sudo apt-get install apache2 -y", shell=True, stdout=subprocess.PIPE).stdout.read()
    else:
        print "apache already installed. Skipping"

    print "-----------"

################# PHP ########################################

if isServer:
    print "Checking for php installation..."

    phpPath = subprocess.Popen("which php", shell=True, stdout=subprocess.PIPE).stdout.read()

    if "php" not in phpPath:
        print "installing php."
        print subprocess.Popen("sudo apt-get install php5 libapache2-mod-php5 -y", shell=True, stdout=subprocess.PIPE).stdout.read()
    else:
        print "php already installed. Skipping"

    print "-----------"

################# MOVE PHP PAGE TO RIGHT PLACE ###############

if isServer:
    print "adding php admin page for alarm."
    print "installing php pages in /var/www/html/"

    print subprocess.Popen("sudo mkdir -p /var/www/html/alarm && sudo cp -R php/* /var/www/html/alarm", shell=True, stdout=subprocess.PIPE).stdout.read()

    print "-----------"

#################ALARM FILES, CONFIG ETC######################
pathCorrect = False
alarmPath = ""
while pathCorrect == False:
	alarmPath = raw_input("Enter path to alarm home folder (example: /home/pi/alarm) ")

	if os.path.exists(alarmPath):
		print alarmPath + " exists." 
		if not os.path.isdir(alarmPath):
			print alarmPath + " is a file. Please enter an existing folder or a folder you want to create."
			continue
		else:
			pathCorrect = True
	else:
		#create the path.
		print "creating folders for " + alarmPath
		print subprocess.Popen("mkdir -p " + alarmPath, shell=True, stdout=subprocess.PIPE).stdout.read()
		pathCorrect = True

print "Installing alarm files in " + alarmPath
if not alarmPath.endswith("/"):
	alarmPath += "/"
print subprocess.Popen("cp -R alarm/* " + alarmPath, shell=True, stdout=subprocess.PIPE).stdout.read()

if isServer:
    print "Adding alarm home to admin.properties"
    print subprocess.Popen('echo "alarm_home:' + alarmPath + '" | sudo tee /var/www/html/alarm/admin.properties', shell=True, stdout=subprocess.PIPE).stdout.read()
    print "Making the alarm application available for the php server"
    print subprocess.Popen('sudo chmod 777 ' + alarmPath + '/*', shell=True, stdout=subprocess.PIPE).stdout.read()

################## PHONE ####################################

#Ask user if attaching phone to pi
phoneConnected = False
inputCorrect = False
while inputCorrect == False:
    phone = raw_input("Should this Raspberry Pi use an Android Phone as part of the system (sending alarm sms, taking pictures)? (Y/n). ")
    if phone == 'Y' or phone == 'y' or phone == '':
        print "you have chosen to have a phone connected to this Pi."
        phoneConnected = True
        inputCorrect = True
    elif phone == 'N' or phone == 'n':
        print "you have chosen NOT to have a phone connected to this Pi."
        inputCorrect = True
    else:
        print "Please enter valid input 'y' or 'n'."

if phoneConnected:
    print subprocess.Popen('sudo apt-get install adb-tools-android', shell=True, stdout=subprocess.PIPE).stdout.read()

##############################################################

print
print "Congratulation! Now go to " + alarmPath + "settings.properties and fill in the necessary data. If this is not the main brain Pi in your alarm system all you need to enter is the server IP for the main Pi and the detector id."
