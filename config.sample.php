<?php
// Variabili del Token Sbot
// Define this variable immediatly. Insert the token of bot. Readme: https://core.telegram.org/bots#botfather
define('BOT_TOKEN', 'toke_del_bot');    //inserire il token del bot
define('API_URL', 'https://api.telegram.org/bot'.BOT_TOKEN.'/');

// Variabili del database Mysql
// Define this variable immediatly. This is variable of Mysql Server
$GLOBALS['mysql_host']='localhost';
$GLOBALS['mysql_port']='3306';
$GLOBALS['mysql_user']='';
$GLOBALS['mysql_pass']='';
$GLOBALS['mysql_db']='telegram';

// Variabili dipendenti dal path - sostituire con il percorso della directory di upload
// Define this variable immediatly. This is the path folder of upload image.
define('INFO_PHOTO', "@/var/www/html/opensipa/upload_img/foto.jpg");	//qui serve il path alla foto di benvenuto
define('PHOTO_SEND', "@/var/www/html/opensipa/upload_img/");            //qui serve solo il path, la foto cambia sempre

// Variabili per personalizzazione messaggi
define('MESSAGE_INFO', 'Opensipa, la comunita\' dei Sistemisti Informatici della Pubblica Amministrazione. Visita il sito www.opensipa.it');
define('MESSAGE_SOCIAL', 'Twitter: https://twitter.com/opensipa'."\r\n".'Facebook: http://www.facebook.com/opensipa'."\r\n".'Linkedin: https://www.linkedin.com/grp/home?gid=5187218'."\r\n".'GPlus: https://plus.google.com/+OpensipaItalia');
define('MESSAGE_FORUM', ' Il forum della comunità si trova su forum.opensipa.it');
define('MESSAGE_CREDIT', 'Progetto realizzato dalla comunità Opensipa.');
define('MESSAGE_NULL','Questo bot non puo\' rispondere a questa domanda. Ma ogni segnalazione che fai verra\' registrata sul server.');
define('MESSAGE_SCUSE','Per ora posso solo utilizzare alcuni comandi. Mi spiace.');
define('MESSAGE_EXIT', 'Non riceverai più news da Opensipa, usa /start per riattivarle');
define('MESSAGE_BENVENUTO','Benvenuto nel Bot della comunita\' Opensipa.');
define('MESSAGE_COMANDI','Puoi usare direttamente i pulsanti delle tastire o scrivere /start per avviare nel news automatiche, /stop per fermare le news, /informazioni per accedere alle informazioni. Per ora non ci sono altri comandi.');
define('MESSAGE_CONTATTI','Puoi scrivere una mail a: opensipa@gmail.com');
define('MESSAGE_HELP','Sei entrato nella sotto sezione Help.');

// Variabili per invio messaggi, link, foto, da usare solo per messaggi benvenuto o in opzioni particolari
define('MESSAGE_SEND','Ti avvisiamo che martedi\' 22 settembre 2015 e\' stata rilasciata la app Sbot.');

// Variabili per settaggio upload foto
define('DIMENSION','48000');
define('PIXEL', '300');

