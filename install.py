import os
import subprocess

################# APACHE2 ####################################

print "Checking for apache installation..."

apache2path = subprocess.Popen("which apache2", shell=True, stdout=subprocess.PIPE).stdout.read()

if "apache2" not in apache2path:
	print "installing apache web server."
	print subprocess.Popen("sudo apt-get install apache2 -y", shell=True, stdout=subprocess.PIPE).stdout.read()
else:
	print "apache already installed. Skipping"

print "-----------"

################# PHP ########################################

print "Checking for php installation..."

phpPath = subprocess.Popen("which php", shell=True, stdout=subprocess.PIPE).stdout.read()

if "php" not in phpPath:
	print "installing php."
	print subprocess.Popen("sudo apt-get install php5 libapache2-mod-php5 -y", shell=True, stdout=subprocess.PIPE).stdout.read()
else:
	print "php already installed. Skipping"

print "-----------"

################# MOVE PHP PAGE TO RIGHT PLACE ###############

print "adding php admin page for alarm."
print "installing php pages in /var/www/html/"

print subprocess.Popen("sudo mkdir -p /var/www/html/alarm && sudo cp -R php/* /var/www/html/alarm", shell=True, stdout=subprocess.PIPE).stdout.read()

print "-----------"
#################ALARM FILES, CONFIG ETC######################
pathCorrect = False
alarmPath = ""
while pathCorrect == False:
	alarmPath = raw_input("Enter path to alarm configuration ")

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
print subprocess.Popen("cp -R alarm " + alarmPath, shell=True, stdout=subprocess.PIPE).stdout.read()

################# SETTING UP CONFIGURATION ##################

print "setting up configuration for alarm."

#TODO enter input to the properties file.

################## PHONE ####################################

#Ask user if attaching phone to pi

#sudo apt-get install adb-tools-android
