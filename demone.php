<?php
/*
 * Ultimate revision 09/01/2016
 */
require_once ('config.php');
require_once ('functions/function.php');
require_once ('functions/functionDb.php');
require_once ('functions/functionInit.php');
require_once ('functions/functionPlugin.php');

/*
 * Function that processes incoming message
 */
function processMessage($message) {
  // Variable for demone
  $message_id = $message['message_id'];
  $chat_id = $message['chat']['id'];
  $text = $message['text'];
  //Keyword
  $key = createKeyboard();
  $num0 = $key[0];
  $reply_markup = $key[1];
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
  /**
   * Controll Message of Text
   */

  if (isset($message['text'])) {
   /*
   * The very function of process messag
   */   
    if (strpos($text, "/start") === 0) {
      apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => $num0, 'reply_markup' => $reply_markup));
      /*
       * Log the user in DB. If the user is already activated only you change their status in active also.
       */
      dbLogUserStart ($chat_id,$first_name_id,$last_name_id, $username_id);
      /* 
       * Possibility to send logo/image when the user enter for first time (optinal)
       * Function: SendPicture($chat_id, INFO_PHOTO ); 
       */
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
        $responceKey = dbDemoneKeyboard("Titolo = '". $text ."'");
        $textControl = $text; //Copy of variable for more control exit to cicle
        foreach ($responceKey as $responceKeyFinal){
            //Insert her for control this is a function, not a button. Implement this control with if function
            if ($responceKeyFinal['Type'] === 'Function'){
                //Launch function
                $functionPersonal = Launcher($chat_id,$reply_markup, $responceKeyFinal['Param']);
                apiRequest("sendMessage", array('chat_id' => $chat_id, "text" =>  $functionPersonal, 'reply_markup' => $reply_markup));
                $textControl = "";
                break; //Exit cicle
            } else if ($textControl === $responceKeyFinal['Titolo']){
            $responceFinal = html_entity_decode($responceKeyFinal['Param']);
            $responceFinal = str_replace ("&#39;","'" ,$responceFinal);
            apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => $responceFinal, 'reply_markup' => $reply_markup));
            $textControl = "";
            break; //Exit cicle
            }  
      }
    } if ($textControl != "") {
        /*
         *  Function that stores all messages that users send through extra bot
         */
        initSendAnswer($chat_id,$first_name_id,$message_id,$text);
    } 
    }//End controll Message of Text
} //End function processMessage

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
      /*
         * Start/Stop Demone
       */
    $status=dbDemoneStatus();
    if($status=="1"){
        $last_id = $update["update_id"] + 1;
        if (isset($update["message"])) {
            processMessage($update["message"]);
            }
    }else{
           sleep(15); 
    }
  }
}
?>