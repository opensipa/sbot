<?php
include ('functions/function.php');
include ('functions/functionDb.php');
include ('config.php');
include ('functions/functionInit.php');
include ('functions/passwordHash.php');
?>
<?php
$messageSchedulation = dbCronExtraction();
// format Date: 2016-05-07 21:30:00 
$currentSend = date("Y-m-d H:i:s"); 
$currentDate = strtotime($currentSend);

foreach ($messageSchedulation as $program){
  $schedulazione = strtotime($program[DataScheduler]);
  $numCron = $program[ID];
  $sent = $program[AlreadySent];
  $testo_ricevuto = $program[Text];
    //Se cron attivo allora ha valore 1
    if ($schedulazione < $currentDate && $sent==1){
      //disattivo subito il cron per non avere ripetizioni
      dbCronUpdate($numCron);
      //estraggo gli utenti
      $activeUsers = dbActiveUsers();
        foreach ($activeUsers as $user) {
          //Control for channel
          if (strpos($user, "@") === FALSE) {
              sendMessage($user, $testo_ricevuto);
          } else {
              sendMessageChannel($user, $testo_ricevuto);
          }  
      }
      //registro operazione
      dbLogTextSend ($testo_ricevuto,'schedulato','','');
      //invio mail al gestore
      $currentTerm = date("Y-m-d H:i:s"); 
      sendMail("Messaggio Schedulato Sbot","Ho mandato il messaggio schedulato dalle $currentSend alle $currentTerm, con il seguente testo: $testo_ricevuto.");
    }
}
?>
<head>
    <meta charset="UTF-8">
    <meta name="copyright" content="Copyright 2015 © Opensipa">
    <title>{S}Bot</title>
</head>
    <div>
    Area Riservata, accesso NEGATO
    </div>
    </body>
</html>