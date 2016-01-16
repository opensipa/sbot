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
    $message = html_entity_decode($message);
    $message = str_replace ("&#39;","'" ,$message);
    $key = createKeyboard();
    $reply_markup = $key[1];
    //Funzione di Send Message 
    apiRequest("sendMessage", array('chat_id' => $user_id, "text" => $message, 'reply_markup' => $reply_markup));
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
function controlUserState()
{
     $ch = curl_init();

            // imposto la URL della risorsa remota da scaricare
            curl_setopt($ch, CURLOPT_URL, API_URL.'getUpdates');

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
            $controllo = "{\"ok\":false,\"error_code\":403,\"description\":\"[Error]: Bot was kicked from a chat\"}"
            return ($risultato, $controllo);
}
 * 
 */

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
