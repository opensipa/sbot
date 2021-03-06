# README #

Date: 02/11/2016


### What is this repository for? ###

* Telegram Bot
* Version: 0.54.0
* name: {S}bot

### How do I get set up? ###

* Mysql + Php + JQuery + Html with Linux or Windows

### Virtual disk with VmWare Player ###

* Use the vmware player and the virtual disk. Downalod from: http://sbot.opensipa.it/ the virtual machine for run {S}bot in 5 minutes

### Contribution guidelines ###

* Writing tests: Community

### Browsers certificate ###

* Browser: Internet Explorer 8+ , Firefox, WaterFox, Chrome, Safari

### Who do I talk to? ###

* http://sbot.opensipa.it
* Assistance: sbot.opensipa@gmail.com
* Search the bot in Telegram
* Code and conceive:
* Guion Matteo (www.guion78.com)
* Contributors of projects:
* Massimo Gorla (Mysql connection, Login, Php)
* Timothy Redaelli (PasswordHash function) 
* Giampiero Marconetto (Send Mail for alert, Testing - very hot testing -)

### How to install? ###

* Linux install:
* Create one Bot, use this guide: https://core.telegram.org/bots#botfather and generate the Token:
* The token is a string along the lines of 110201543:AAHdqTcvCH1vGWJxfSeofSAs0K5PALD saw that will be required to authorize the bot and send requests to the Bot API
* Use the server Linux with Lamp (Php version 5.5 or higher with support for curl and mcrypt (apt-get install php5-mcrypt, apt-get install php5-curl and /etc/init.d/apache2 restart), mysql 5.5 or higher and apache)
* Insert in config.sample.php the Token, user and pwd user mysql and define the path of INFO_PHOTO e SEND_PHOTO
* If this is your first install rename config.sample.php to config.php
* For ability mcrypt at php launch in the bash: "php5enmod mcrypt" and restart Apache or Server. This is very important for login in Sbot management.
* Use telegram_base.sql in folder sql and install in your server Mysql (launch in DB telegram the instruction sql).
* In /etc/rc.local your server Linux insert (in two row):
* "php /var/www/_PATH_OF_FOLDER_SBOT/sbot/demone.php > /var/www/_PATH_OF_FOLDER_SBOT/sbot/sbotAdmin/log/sbot.log & 
* exit 0"
* Delete the " " before inserting the file
* "EXIT 0" -> for force the exit
* If you want the send images to work directory upload_img must be writable (set to 777)
* reboot Server linux.
* Ok, the sbot is run and you to be working. User login: admin Password login: password

* Windows install:
* For install with Windows use the guide for Linux Server, but not configure rc.local. Configure Scheduled Tasks in Windows panel.


### Changelog ###

### 02/11/2016###
* BugFix and insert tracker user and create level user (admin, user)

### 29/07/2016###
* BugFix

### 29/06/2016###
* BugFix and clean a code

### 19/06/2016###
* New parameter for message exit and search with Google or my site if user not found responce.
* In config.php file deprecate variable: define('MESSAGE_NULL')
* Launch 11_update.sql
* BugFix and clean a code

### 12/06/2016###
* Implements the short link for send news ecc. 
* Launch 10_update.sql

### 08/06/2016###
* Use the code html for send message in {S}Bot
* For more details: https://core.telegram.org/bots/api#formatting-options
* <b>bold</b>, <strong>bold</strong>
* <i>italic</i>, <em>italic</em>
* <a href="URL">inline URL</a>
* <code>inline fixed-width code</code>
* <pre>pre-formatted fixed-width code block</pre>

### 05/06/2016###
* This version control this error: [Error : 403 : Bot was blocked by the user]. In this case the user is delete from Sbot.

### 04/06/2016###
* Bug fix for version 0.40.

### 03/06/2016###
* New version permit the scheduler send.
* In Linux server create a crontab for launcher this script:
* ##
* ##
* #!/bin/bash 
* # Questo script serve per richiamare il componente crontab.php
* # di sbot e deve essere utilizzato solo per lanciare il crontab
* /usr/bin/php -f /var/www/html/sbot/crontab.php > /dev/null 2>&1
*
* ##
* In Windows Server create a scheduled task from control pannel

### 30/05/2016###
* Implement send message into Channel Telegram.

### 16/01/2016###
* New version change the config file and demone. This versione permit the change buttonBot with web page.


### 22/11/2015###
* Notification of new posts by email. Ability to start and stop the demon. Ability to set parameters via mail interface.
* Modify the script for start demone: "php /var/www/_PATH_OF_FOLDER_SBOT/sbot/demone.php > /var/www/_PATH_OF_FOLDER_SBOT/sbot/sbotAdmin/log/sbot.log & exit 0"

### 03/11/2015###
* Bug Fix

### 17/10/2015###
* New table style, add possibility disable user in admin page setting
* Bug Fix

### 12/10/2015###
* Now is possibile search message with function
* Bug Fix

### 11/10/2015###
* Convert date format Europe/IT
* Add archive message function
* Bug Fix

### 10/10/2015###
* Insert change signature for user
* Launch 4_update.sql for update Db
* Sortable single column for table users
* Bug Fix

### 07/10/2015###
* Correct bug in scructure Db
* Launch 3_update.sql for update Db

### 05/10/2015###
* IMPORTANT: Change folder for log --> In /etc/rc.local your server Linux insert: "php /var/www/_PATH_OF_FOLDER_SBOT/sbot/demone.php > /var/www/_PATH_OF_FOLDER_SBOT/sbot/sbotAdmin/log/sbot.log, and restart Server linux.
* Corret error in config.sample.php and demone.php replace the file config
* Insert update

### 04/10/2015###
* change functionDB function dbLogTextSend
* change sendSingle.php add into dbLogTextSend ($testo_ricevuto,$_SESSION['username'],$MessageID, $utenti_messageID);
* change function dbLogTextFull()
* change sendSingle for connection with single message send
* change send for new functionDB dbLogTextSend
* disable button send message after one click
* add connection single user with single messag
* launch 2_update.sql

### 01/10/2015 ###
* Add page of insert multiuser
* Insert in single message signature of user to send message
* Update table admins and send_message (use 1_update.sql)