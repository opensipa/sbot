<?php
/* 
 * Funzioni Demone
 * 
 * 
 * 
 */

// Launcher Demone
function avvio(){
    shell_exec('php ../demone.php'); // questo demone deve sempre rimanere in ascolto per far funzionare il bot
    echo 'Demone avviato';
  }
  
/*
 * Funzioni di scrittura per file LOG errori
 * Write error log
 */
 
function writeLog($message, $destination){
 // Posiziona il puntatore alla fine del file indicato
 // Se il file non esiste prova a crearlo
 if( !$fileHandle = fopen($destination.'error.log', 'a+') ){
    echo "Impossibile aprire il file di Log";
    return false;
 }
 // Scrittura della riga di log
  fwrite($fileHandle, $message."\r\n");
 // Chiusura dell'handle
 fclose($fileHandle);
}

/*
 * 
 * Funzione per la gestione delle Api di Telegram
 * 
 */

/*
 *
 * Function that processes incoming message
 *  
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
        //Filtering response for select button for users with title in DB
        $responceKey = dbDemoneKeyboard("Titolo = '". $text ."'");
        $textControl = $text; //Copy of variable for more control exit to cicle
        foreach ($responceKey as $responceKeyFinal){
            //Insert her for control this is a function, not a button. Implement this control with if function
            if ($responceKeyFinal['Type'] === 'Function'){
                //Launch function with messagge time wait
                $tableParm = dbParamExtraction('SoftDesc = "Message" AND Active = "1"');
                foreach ($tableParm as $param) {
                if ($param['Code'] == "waiting"){
                    $message = $param['Param'];}
                }
                if($message != ''){
                    apiRequest("sendMessage", array('chat_id' => $chat_id, "text" =>  $message, 'reply_markup' => $reply_markup));
                    $functionPersonal = Launcher($chat_id,$reply_markup, $responceKeyFinal['Param']);  
                    apiRequest("sendMessage", array('chat_id' => $chat_id, "text" =>  $functionPersonal, 'reply_markup' => $reply_markup));
                    $textControl = "";
                    break; //Exit cicle
                } else {
                    $functionPersonal = Launcher($chat_id,$reply_markup, $responceKeyFinal['Param']);  
                    apiRequest("sendMessage", array('chat_id' => $chat_id, "text" =>  $functionPersonal, 'reply_markup' => $reply_markup));
                    $textControl = "";
                    break; //Exit cicle
                }
            } else if ($textControl === $responceKeyFinal['Titolo']){
            //QUESTO DIVENTA UN ARRAY NON UNA RIGA SOLA QUINDI SERVE UN FOREACH
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

/*
*
* Function apiRequest
*
*/

function apiRequest($method, $parameters) {
  if (!is_string($method)) {
    error_log("Method name must be a string\n");
    return false;
  }

  if (!$parameters) {
    $parameters = array();
  } else if (!is_array($parameters)) {
    error_log("Parameters must be an array\n");
    return false;
  }

  foreach ($parameters as $key => &$val) {
    // encoding to JSON array parameters, for example reply_markup
    if (!is_numeric($val) && !is_string($val)) {
      $val = json_encode($val);
    }
  }
  $url = API_URL.$method.'?'.http_build_query($parameters);

  $handle = curl_init($url);
  curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($handle, CURLOPT_TIMEOUT, 60); 

  $response = curl_exec($handle);

  if ($response === false) {
    $errno = curl_errno($handle);
    $error = curl_error($handle);
    error_log("Curl returned error $errno: $error\n");
    curl_close($handle);
    return false;
  }

  $http_code = intval(curl_getinfo($handle, CURLINFO_HTTP_CODE));
  curl_close($handle);

  if ($http_code >= 500) {
    // we wouldn't want to DDOS the server if something goes wrong
    sleep(10); //default 10
    return false;
  } else if ($http_code != 200) {
    $response = json_decode($response, true);
    error_log("Request has failed with error {$response['error_code']}: {$response['description']}\n");
    if ($http_code == 401) {
      throw new Exception('Invalid access token provided');
    }
    // This error "403": Request has failed with error 403: Bot was blocked by the user - Delete user from Sbot for block
    if ($http_code == 403) {
        dbLogUserStop ($parameters['chat_id']);
    }
    return false;
  } else {
    $response = json_decode($response, true);
    if (isset($response['description'])) {
      error_log("Request was successfull: {$response['description']}\n");
    }
    $response = $response['result'];
  }

  return $response;
}
// Fine API Telegram

/*
 * 
 * Funzione che processa l'invio di Messaggi in modo massivo
 * 
 */
function sendMessage($user_id, $message) {
    //Correzione dei caratteri utf-8 particolari ed inoltre apici
    //Funzione deprecata -> $message = html_entity_decode($message);
    $message = str_replace ("&#39;","'" ,$message);
    $key = createKeyboard();
    $reply_markup = $key[1];
    //Funzione di Send Message 
    apiRequest("sendMessage", array('chat_id' => $user_id, 'text' => $message, 'parse_mode' => 'HTML', 'reply_markup' => $reply_markup));
}

/*
 * 
 * Funzione che processa l'invio di Messaggi per i Channel di Telegram
 * 
 */
function sendMessageChannel($user_id, $message) {
    //Correzione dei caratteri utf-8 particolari ed inoltre apici
    $message = html_entity_decode($message);
    $message = str_replace ("&#39;","'" ,$message);
    //Funzione di Send Message to Channel 
    apiRequest("sendMessage", array('chat_id' => "$user_id", 'text' => $message));
}

/*
 * 
 * Funzione che processa l'invio di Foto dopo averle uplodate sul server
 * 
 */
function sendPicture($chat_id, $photo) {
 $ch = curl_init($chat_id);
 
 // New variable for send Photo
 $url = API_URL.'sendPhoto';
 $handle = curl_init($url);
 
 curl_setopt($ch, CURLOPT_URL, $url);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 curl_setopt($ch, CURLOPT_POST, true);
 
 // timeout per evitare blocco server se Telegram non risponde
 curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
 curl_setopt($handle, CURLOPT_TIMEOUT, 120);  
 
 $data = array('chat_id' => $chat_id,
			'photo' => $photo
			);
 curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
 $output = curl_exec($ch);
 curl_close($ch);
 // echo for testing (disable for normal use)
 // echo $output;
}

/**
 * controlTelgramState
 * 
 * disegna il menu come lista puntata
 * 
 * @param array $risultato, $controllo array associativo allo stato della coda Telegram
 * 
 */

function controlTelgramState(){
    $ch = curl_init();
    // Set URL della risorsa remota da scaricare
    // New variable for send Photo
    $url = API_URL.'getUpdates';
    $handle = curl_init($url);
    curl_setopt($ch, CURLOPT_URL, $url);
    // imposto che non vengano scaricati gli header
    curl_setopt($ch, CURLOPT_HEADER, 0);
    // un paio di timeout per evitare tempi troppo lunghi sul server
    curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($handle, CURLOPT_TIMEOUT, 60); 
    // blocca l'output di curl
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // inserisco il risultato su variabile
    $risultato = curl_exec($ch);
    curl_close($ch);
    // output di Telegram site when the result is OK
    $controllo = "{\"ok\":true,\"result\":[]}";
    return (array($risultato, $controllo));
}

/**
 * This Function is not terminate
 * Control the stop bot from users
 * 
 *
 * 
 * @return type
 */ 
 
function controlUserState($indirizzo)
{
    $ch = curl_init();
    // Set URL della risorsa remota da scaricare
    // New variable for send Photo
    $url = $indirizzo; //API_URL.'getUpdates';
    $handle = curl_init($url);
    curl_setopt($ch, CURLOPT_URL, $url);
    // imposto che non vengano scaricati gli header
    curl_setopt($ch, CURLOPT_HEADER, 0);
    // un paio di timeout per evitare tempi troppo lunghi sul server
    curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($handle, CURLOPT_TIMEOUT, 60); 
    // blocca l'output di curl
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // inserisco il risultato su variabile
    $risultato = curl_exec($ch);
    curl_close($ch);
    // output di Telegram site when the result is OK
    //$controllo = "{\"ok\":false,\"error_code\":403,\"description\":\"[Error]: Bot was kicked from a chat\"}";
    $controllo = "Request has failed with error 403: Bot was blocked by the user";
    return (array($risultato, $controllo));
}


/*
 * 
 * Funzione per la gestione della tastiera
 * 
 */

function createKeyboard(){
    //Message of Hello
    $num = dbDemoneKeyboard("Number=0");
    foreach ($num as $numText){$key0 = $numText['Param'];}
    //Keyboard
    $numKey = dbDemoneKeyboard("Number BETWEEN 1 AND 4 AND SoftDesc='Button'");
        foreach ($numKey as $numKeyText){
            $num1[] = $numKeyText['Titolo'];
        } 
    $numKey = dbDemoneKeyboard("Number BETWEEN 5 AND 8 AND SoftDesc='Button'");
        foreach ($numKey as $numKeyText){
            $num2[] = $numKeyText['Titolo'];
        }
    $keyboard = [
        $num1, 
        $num2   
    ];
    $reply_markup = [
        'keyboard' => $keyboard, 
        'resize_keyboard' => true, 
        'one_time_keyboard' => false,
        'force_reply' => true
    ];
    return [$key0, $reply_markup];
}

/*
//Funzioni di prossima implementazione

function sendAudio($chat_id, $audio, $reply_to_message_id = null, $reply_markup = null){
    return new Message($this->request('sendAudio', compact('chat_id', 'audio', 'reply_to_message_id', 'reply_markup')));
}

function sendDocument($chat_id, $document, $reply_to_message_id = null, $reply_markup = null){
      return new Message($this->request('sendDocument', compact('chat_id', 'document', 'reply_to_message_id', 'reply_markup')));
}

function sendSticker($chat_id, $sticker, $reply_to_message_id = null, $reply_markup = null){
      return new Message($this->request('sendSticker', compact('chat_id', 'sticker', 'reply_to_message_id', 'reply_markup')));
}
*/
