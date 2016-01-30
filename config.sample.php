<?php
/*
 * Variabili del Token Sbot
 * Define this variable immediatly. Insert the token of bot. Readme: https://core.telegram.org/bots#botfather
 */ 
define('BOT_TOKEN', 'toke_del_bot');    //Insert number/letter of id token
define('API_URL', 'https://api.telegram.org/bot'.BOT_TOKEN.'/');

/*
 * Variabili del database Mysql
 * Define this variable immediatly. This is variable of Mysql Server
 */ 
$GLOBALS['mysql_host']='localhost'; //Ip server Mysql
$GLOBALS['mysql_port']='3306';      //Port server Mysql
$GLOBALS['mysql_user']='';          //User database
$GLOBALS['mysql_pass']='';          //Password database
$GLOBALS['mysql_db']='telegram';    //Don't change

/* 
 * Variabili dipendenti dal path - sostituire con il percorso della directory di upload
 * Define this variable immediatly. This is the path folder of upload image.
 */
define('INFO_PHOTO', "@/var/www/html/sbot/upload_img/foto.jpg");	//qui serve il path alla foto di benvenuto
define('PHOTO_SEND', "@/var/www/html/sbot/upload_img/");            //qui serve solo il path, la foto cambia sempre

/*
 * Variabili per personalizzazione messaggi
 * Variables for customizing messages
 */
define('MESSAGE_NULL', 'Questo bot non puo\' rispondere a questa domanda. Ma ogni segnalazione che fai verra\' registrata sul server.');
define('MESSAGE_EXIT', 'Non riceverai piu\' news da questo Bot, usa /start per riattivarle.');


/*
 * Variabili per invio messaggi, link, foto, da usare solo per messaggi benvenuto o in opzioni particolari
 * Variables for sending messages, links, photos, to be used only for messages or welcome in particular options
 */
define('MESSAGE_SEND','Ti avvisiamo che martedi\' 22 settembre 2015 e\' stata rilasciata la app Sbot.');

/*
 * Variabili per settaggio funzione di upload foto
 * Variables for setting function of upload photos
 */
define('DIMENSION','160000');
define('PIXEL', '800');

