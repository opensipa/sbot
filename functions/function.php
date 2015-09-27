<?php
// Launcher Demone
function avvio(){
    shell_exec('php ../demone.php'); // questo demone deve sempre rimanere in ascolto per far funzionare il bot
    echo 'Demone avviato';
    echo '<p><a href="admin.php">Torna alla pagina di Admin</a></p> ';
  }
  
// Funzioni di scrittura per file LOG errori
// Write
function writeLog($message){
 // Posiziona il puntatore alla fine del file indicato
 // Se il file non esiste prova a crearlo
 if( !$fileHandle = fopen('log.txt', 'a+') ){
    echo "Impossibile aprire il file di Log";
    return false;
 }
 // Scrittura della riga di log
  fwrite($fileHandle, $message."\r\n");
 // Chiusura dell'handle
 fclose($fileHandle);
}

// Funzione per la gestione delle Api di Telegram

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
    sleep(100); //default 10
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

// Funzione che processa l'invio di Messaggi in modo massivo
function sendMessage($user_id, $message) {
    //Correzione dei caratteri utf-8 particolari ed inoltre apici
    $message = html_entity_decode($message);
    $message = str_replace ("&#39;","'" ,$message);
    
    //Funzione di Send Message 
	apiRequest("sendMessage", array('chat_id' => $user_id, "text" => $message));
}

// Funzione che processa l'invio di Foto dopo averle uplodate sul server
function sendPicture($chat_id, $photo) {
 $ch = curl_init($chat_id);
 curl_setopt($ch, CURLOPT_URL, API_URL."sendPhoto");
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
 echo $output;
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
