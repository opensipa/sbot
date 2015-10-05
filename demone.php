<?php
/*
 * Ultimate revision 14/09/2015
 */
include('config.php');
include('init.php');
include('functions/function.php');
include('functions/functionDb.php');

/*
 * Function that processes incoming message
 */
function processMessage($message) {
  // Variable
  $conn=getDbConnection(); //connection to DB
  $message_id = $message['message_id'];
  $chat_id = $message['chat']['id'];
  /*
   * Control the empty fields in incoming message
   */
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
   /*
   * The very function of process messag
   */
    $text = $message['text'];
    if (strpos($text, "/start") === 0) {
      apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => MESSAGE_BENVENUTO, 'reply_markup' => array(
        'keyboard' => array(array('Help', 'Social Media', 'Forum', 'Credit')),
        'one_time_keyboard' => false,                    
        'resize_keyboard' => true)));
      /*
       * Log the user in DB. If the user is already activated only you change their status in active also.
       */
     dbLogUserStart ($chat_id,$first_name_id,$last_name_id, $username_id);
     /* 
      * Possibility to send logo/image when the user enter for first time (optinal)
      * Function: SendPicture($chat_id, INFO_PHOTO ); 
      */
     
     /*
      * Menù Help
      */ 
    } else if ($text === "Help") {
        apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => MESSAGE_HELP, 'reply_markup' => array(
        'keyboard' => array(array('Info', 'Comandi', 'Contatti', 'Exit')),
        'one_time_keyboard' => false,                    
        'resize_keyboard' => true)));
    } else if ($text === "Info" || $text === "Informazioni" || $text === "/informazioni") {
        apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => MESSAGE_INFO, "disable_web_page_preview" => true));
    } else if ($text === "Comandi" ) {
        apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => MESSAGE_COMANDI, "disable_web_page_preview" => true));
    } else if ($text === "Contatti" ) {
        apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => MESSAGE_CONTATTI, "disable_web_page_preview" => true));
    }  else if ($text === "Exit") {
    /*
     * Return to menù home page
     */
      apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => 'Sei tornato al menu\' in Home.', 'reply_markup' => array(
        'keyboard' => array(array('Help', 'Social Media', 'Forum', 'Credit')),
        'one_time_keyboard' => false,
        'force_reply_keyboard' => true,                    
        'resize_keyboard' => true)));
    }  else if ($text === "Social Media") {
        apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => MESSAGE_SOCIAL, "disable_web_page_preview" => true));
    }  else if ($text === "Forum") {
        apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => MESSAGE_FORUM, "disable_web_page_preview" => true));
    }  else if ($text === "Credit") {
        apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => MESSAGE_CREDIT, "disable_web_page_preview" => true));
    } else if ($text === "/stop") {
    /*
     * Here inserted disabling user from the DB (not cleared but only put off)
     */
        apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => MESSAGE_EXIT));
        dbLogUserStop ($chat_id);
    } else if (strpos($text, "Stop") === 0) {
    /*
     * For ecception 
     * Here inserted disabling user from the DB (not cleared but only put off)
     */
        apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => MESSAGE_EXIT));
        dbLogUserStop ($chat_id);
    } else {
        /*
         *  Function that stores all messages that users send through extra bot
         */
        apiRequest("sendMessage", array('chat_id' => $chat_id, "reply_to_message_id" => $message_id, "text" => MESSAGE_NULL));
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
    /*
     * Received an error
     */
    sleep(1);
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