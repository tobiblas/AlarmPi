# AlarmPi
Home alarm system for Raspberry Pi

See video here: ddlkfsdlkfjds for an overview of the project.

install.py in the root folder will install the alarm system in /home/pi/alarm

One raspberry unit in the system must be the master and will hold a PHP server which is used for commpunication between units and for communication between end user (you) and the alarm. The PHP server will be installed in /var/www/html/alarm

The AlarmPi system currently supports 1 to many units that all MUST have a motion sensor and LED attached. 
They MUST also be connected to a local network. 
They MAY have a pi camera attached.
The master unit MAY also be connected to an Android phone via USB which will send SMS, make sound and detect power outages.

At http://<IP OF YOUR MASTER UNIT>/alarm you can turn the alarm on/off, see the alarm log, see camera images (optional) and change system settings.
