# README #

Date: 04/10/2015


### What is this repository for? ###

* Telegram Bot
* Version: 0.12 beta 4
* name: {S}bot

### How do I get set up? ###

* Mysql + Php + JQuery + Html


### Contribution guidelines ###

* Writing tests: Community Opensipa.it


### Who do I talk to? ###

* sbot.opensipa.it
* Assistance: sbot.opensipa@gmail.com
* Code by Guion Matteo e Massimo Gorla

### How to install? ###

* Create one Bot, use this guide: https://core.telegram.org/bots#botfather and generate the Token:
* The token is a string along the lines of 110201543:AAHdqTcvCH1vGWJxfSeofSAs0K5PALDsaw that will be required to authorize the bot and send requests to the Bot API
* Use the server Linux with Lamp (Php versione 5.5 or heigher with support for curl and mcrypt, mysql 5.5 or heigher and apache)
* Insert in config.sample.php the Token, user and pwd user mysql and define the path of INFO_PHOTO e SEND_PHOTO
* Don't delete the config.php and rename config.sample.php
* For ability mcrypt at php launch in the bash: "php5enmod mcrypt" and restart Apache or Server. This is very import for login in Sbot management.
* Use telegram_base.sql in folder sql and install in your server Mysql (launch in DB telegram the instruction sql).
* In /etc/rc.local your server Linux insert: "php /var/www/_PATH_OF_FOLDER_SBOT/sbot/demone.php > /var/www/_PATH_OF_FOLDER_SBOT/sbot/log/sbot.log, andr restart Server linux.
* Ok, the sbot is run and you to be working. User login: admin Password login: password
*
*
* Install library for cron command:
* Author page script cron: http://code.tutsplus.com/tutorials/managing-cron-jobs-with-php--net-19428
* Use the command (for debian/ubuntu): "apt-get install libssh2-php" and restart apache with "/etc/init.d/apache2 restart"
* For more details for installation visit the page: http://www.php.net/manual/en/ssh2.installation.php
*

### Changelog ###

*05/10/2015
*Corret error in config.sample.php and demone.php replace the file config
*
*04/10/2014
*change functionDB function dbLogTextSend
*change sendSingle.php add into dbLogTextSend ($testo_ricevuto,$_SESSION['username'],$MessageID, $utenti_messageID);
*change function dbLogTextFull()
*change sendSingle for connection with single message send
*change send for new functionDB dbLogTextSend
*disable button send message after one click
*add connection single user with single messag
*launch 2_update.sql
*
* 01/10/2015
* Add page of insert multiuser
* Insert in single message signature of user to send message
* Update table admins and send_message (use 1_update.sql)


