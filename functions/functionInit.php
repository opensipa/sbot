<?php
/* 
 * Funzioni comuni a più Servizi
 * 
 * 
 */

require_once ('phpmailer/PHPMailerAutoload.php');
require_once ('functionGoogle.php');

/**
 * 
 * Function initSendAnswer
 * 
 * 
 * for widows: http://www.brinkster.com/KB/Article~KBA-01132-T2P9H8~How-do-I-send-email-with-PHPMailer-for-Windows-Hosting%3F
 * for use with gmail setting ON "Allow less secure apps: ON" in this page https://myaccount.google.com/security?pli=1#activity
 *
 * 
 * @param $chat_id,$first_name_id,$message_id,$text, 
 * Permette l'inserimento in Sbot di messaggi non conmtemplati in altre funzioni e invio mail di avviso 
 *  
 * @return anything
 */

function initSendAnswer($chat_id,$first_name_id,$message_id,$text){
    // Extract param for message responce
    $tableParmExit = dbParamExtraction('SoftDesc = "Message" AND Active = "1"');
    foreach ($tableParmExit as $param) {
        if ($param['Code'] == "exit"){
            $messageExit = $param['Param'];
        }  
    }
    if($messageExit != ''){
    apiRequest("sendMessage", array('chat_id' => $chat_id, "reply_to_message_id" => $message_id, "text" => $messageExit));
    }
    dbLogTextOn($chat_id,$first_name_id,$message_id,$text);
    sendMail("Hai ricevuto un messaggio nel Bot","Da: ".$first_name_id." - Testo del messaggio: ".$text);
    // Extract param for message responce
    $tableParmSearch = dbParamExtraction('SoftDesc = "Search" AND Active = "1"');
        foreach ($tableParmSearch as $param) {
            if ($param['Code'] == "url"){
                $link = $param['Param'];
            }
            if ($param['Code'] == "text"){
                $linkText = $param['Param'];
            }   
        }
        if($link != '' & $linkText != ''){
            $text = str_replace(" ","+" ,$text);
            $messagePrivate = $linkText . $link . $text;
            apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => $messagePrivate));
        }
}

/**
 * sendMail
 * 
 * Invia una mail ogni volta che un utente inserisce una domanda
 * 
 * @param 
 * 
 */

function sendMail($subject, $corpo_messaggio) {
    $mittente = "";
    $nomemittente = "";
    $destinatario = "";
    $nomedestinatario  = "";
    $serversmtp = "";
    $port = "";
    $secure = "";       // puoi settare tsl, ssl ecc
    $username = "";     // utente server SMTP autenticato
    $password = "";     // password server SMTP autenticato
    //extract to Db the setting parameter
    $tableParm = dbParamExtraction('SoftDesc = "Mail" AND Active = "1"');
    foreach ($tableParm as $param) {
        if ($param['Code'] == "mittente"){$mittente = $param['Param'];}
        if ($param['Code'] == "nomemittente"){$nomemittente = $param['Param'];}
        if ($param['Code'] == "destinatario"){$destinatario = $param['Param'];}
        if ($param['Code'] == "nomedestinatario"){$nomedestinatario = $param['Param'];}
        if ($param['Code'] == "serversmtp"){$serversmtp = $param['Param'];}
        if ($param['Code'] == "port"){$port = $param['Param'];}
        if ($param['Code'] == "secure"){$secure = $param['Param'];}
        if ($param['Code'] == "username"){$username = $param['Param'];}
        if ($param['Code'] == "password"){$password = $param['Param'];}
    }
    //control parameter also skeep
    if (empty($mittente)){return "Errore di configurazione per il mittente";}
    if (empty($destinatario)){return "Errore di configurazione per il destinatario";}
    if (empty($serversmtp)){return "Errore di configurazione per il server smtp";}
    if (empty($port)){return "Errore di configurazione per la porta";}
    if (empty($username)){return "Errore di configurazione per nome utente";}
    if (empty($password)){return "Errore di configurazione per la password";
    } else {   
    // Ok for setting
    $messaggio = new PHPMailer;
    $messaggio->IsSMTP(); 
    /* Enable SMTP debugging
     * 0 = off (for production use)
     * 1 = client messages
     * 2 = client and server messages
     */
    $messaggio->SMTPDebug = 0;
    $messaggio->SMTPAuth = true;     // abilita autenticazione SMTP
    $messaggio->SMTPKeepAlive = "true";
    $messaggio->isHTML(false);
    $messaggio->Host  = $serversmtp;
    $messaggio->Port = $port;
    $messaggio->SMTPSecure = $secure;
    $messaggio->Username = $username;
    $messaggio->Password = $password;
    $messaggio->Subject = $subject;
    $messaggio->CharSet = "UTF-8";
    $messaggio->setFrom($mittente, $nomemittente);
    $messaggio->addReplyTo($destinatario, $nomedestinatario);
    $messaggio->addAddress($destinatario, $nomedestinatario);
    $messaggio->Body  = $corpo_messaggio;
    $messaggio->AltBody = 'This is a plain-text message body';
    $messaggio ->Send();
    return $messaggio->ErrorInfo;
    }
}

/**
 * buttonDemone
 * 
 * gestisce i menù del demone
 * 
 * @param array 
 * 
 */

function buttonDemone(){
  $buttonArray[] = dbParamExtraction('SoftDesc = "Button" AND Active = 1'); 
}

/*
 * Fuction initShort($link)
 * return Short Link from Google
 * Use the Api Google and Key Google
 * 
 * Return link not short (not key found)
 * Return short link if key found
 * 
 */

function initShort($link){
    if (class_exists('GoogleUrlApi')) {
        // Create instance with key
        // Extract Google API key
        $tableParm = dbParamExtraction('SoftDesc = "Google" AND Active = "1"');
        foreach ($tableParm as $param) {
        if ($param['Code'] == "key"){$GOOGLE_KEY = $param['Param'];}
        }
        if($GOOGLE_KEY != ''){
            $googleShort = new GoogleURLAPI($GOOGLE_KEY);
            // Test: Shorten a URL
            $shortDWName = $googleShort->shorten($link);
            // Returns http://goo.gl/i002
            return $shortDWName;
        } else {
            return $link;
        }
    }
}

/**
 * topMenu
 * 
 * disegna il menu come lista puntata
 * 
 * @param array $menu array associativo con descrizione del link => link
 * 
 */
function topMenu($menu)
{
    echo '<div>';
    echo '<ul id="admin_menu">';
    printMenuItems($menu);
    echo '</ul>';
    echo '</div>';
}

function printMenuItems($menu)
{
    foreach ($menu as $nome=>$uri) {
    echo '<li><a href="'.$uri.'">'.$nome.'</a></li> ';
    }
}

$menu = array(
    'Utenti attivi in {S}BOT'=>'user.php',
    'Coda dal sito Telegram'=>'coda.php',
    'Messaggi degli utenti'=>'message.php',
    'Messaggi inviati'=>'fullSend.php',
    'Cambio password'=>'pwd.php'
    );
