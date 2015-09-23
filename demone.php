<?php
// Versione n. 2, revisione del 14 settembre 2015
// Demone di funzionamento bot
// Inizializzazione

include("config.php");
include("init.php");
include("functions/function.php");
include("functions/functionDb.php");

//Funzione che processa i messaggi in entrata
function processMessage($message) {
  // process incoming message
  $conn=getDbConnection();
    
  $message_id = $message['message_id'];
  $chat_id = $message['chat']['id'];
  
  if (isset($message['from']['first_name'])) {
      $first_name_id=$message['from']['first_name'];
  } else {
      $first_name_id='';
  }
  
  if (isset($message['from']['last_name'])) {
      $last_name_id=$message['from']['last_name'];
  } else {
      $last_name_id='';
  }
  
  if (isset($message['from']['username'])) {
      $username_id=$message['from']['username'];
  } else {
      $username_id='';
  }
    
  if (isset($message['text'])) {
    // incoming text message
    $text = $message['text'];

    if (strpos($text, "/start") === 0) {
      apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => MESSAGE_BENVENUTO, 'reply_markup' => array(
        'keyboard' => array(array('Help', 'Social Media', 'Forum', 'Credit')),
        'one_time_keyboard' => false,                    
        'resize_keyboard' => true)));
        
     //Registro l'utente nel DB utenti. Se l'utente e gia attivato modifica solo il suo stato in attivo 
     dbLogUserStart ($chat_id,$first_name_id,$last_name_id, $username_id);
        
     //Possibilita di inviare logo quando utente entra per la prima volta (opzionale)
     //SendPicture($chat_id, INFO_PHOTO ); 
	
    // Sotto menu di help
	} else if ($text === "Help") { 
      apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => MESSAGE_HELP, 'reply_markup' => array(
        'keyboard' => array(array('Info', 'Comandi', 'Contatti', 'Exit')),
        'one_time_keyboard' => false,                    
        'resize_keyboard' => true)));
    } else if ($text === "Info" || $text === "Informazioni" || $text === "informazioni" || $text === "/informazioni" ) {
		apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => MESSAGE_INFO, "disable_web_page_preview" => true));
    } else if ($text === "Comandi" ) {
		apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => MESSAGE_COMANDI, "disable_web_page_preview" => true));
    } else if ($text === "Contatti" ) {
		apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => MESSAGE_CONTATTI, "disable_web_page_preview" => true));
	
    }  else if ($text === "Exit") {
      // Torna indietro con la tastiera
      apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => '/start', 'reply_markup' => array(
        'keyboard' => array(array('Help', 'Social Media', 'Forum', 'Credit')),
        'one_time_keyboard' => false,                    
        'resize_keyboard' => true)));
        
    // Fine sotto menu di help
    
    }  else if ($text === "Social Media") {
      apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => MESSAGE_SOCIAL, "disable_web_page_preview" => true));   
    
    }  else if ($text === "Forum") {
      apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => MESSAGE_FORUM, "disable_web_page_preview" => true));
      
    }  else if ($text === "Credit") {
      apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => MESSAGE_CREDIT, "disable_web_page_preview" => true));
      
    } else if ($text === "/stop") {
      apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => MESSAGE_EXIT));
	  //Stop qui inserisco la disabilitazione utente dal DB (non viene cancellato ma solo messo disabilitato)
	   dbLogUserStop ($chat_id);
      
    } else if (strpos($text, "Stop") === 0) {
      apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => MESSAGE_EXIT));
      //Stop qui inserisco la disabilitazione utente dal DB (non viene cancellato ma solo messo disabilitato)
      dbLogUserStop ($chat_id);
    
    } else {
      apiRequest("sendMessage", array('chat_id' => $chat_id, "reply_to_message_id" => $message_id, "text" => MESSAGE_NULL));
      //Funzione che registra tutti i messaggi extra che gli utenti inviano tramite il bot
      dbLogTextOn ($chat_id,$first_name_id,$message_id,$text); 
    }
	} else {
    apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => MESSAGE_SCUSE));
  }
}

$last_id = null;
while (true) {
  $args = array();
  if ($last_id) {
    $args["offset"] = $last_id;
  }
  $args["timeout"] = 200;

  $updates = apiRequest("getUpdates", $args);
  if ($updates === false) {
    // received an error
    sleep(1);   //default 1
    continue;
  }

  foreach ($updates as $update) {
    $last_id = $update["update_id"] + 1;
    if (isset($update["message"])) {
      processMessage($update["message"]);
    }
  }
}

?>