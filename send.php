<?php
include('theme/verification.php');
include('theme/header.php'); 
include('config.php');
include('functions/functionInit.php');
include('functions/function.php');
include('functions/functionDb.php');
?>
<div id="content" class="clearfix">
    <div class="content-row">
    <h1>
<?php

//Recupero il valore del testo
$testo_ricevuto=filter_input(INPUT_POST, 'testo', FILTER_SANITIZE_STRING);
if (!empty($testo_ricevuto)){
/******
 * questa fase cicla sugli utenti attivi inseriti nel database e per ciascun id
 * richiama la funzione sendMessage per spedire il testo passato con post
 * ogni chat_id una singola spedizione messaggio
 ******/
    $activeUsers = dbActiveUsers();
    foreach ($activeUsers as $user) {
        sendMessage($user, $testo_ricevuto);
    }
    $numeroInvi = dbCountActiveUsers();
    dbLogTextSend ($testo_ricevuto,$_SESSION['username'],'','');
    echo'<p>Hai inviato il seguente testo: <br> "<strong>'.$testo_ricevuto.'</strong>"</p>'
    .   '<p>Ha inviato il testo a <strong>'.$numeroInvi.'</strong> utenti del servizio.</p>';
} else {
    echo'<p><strong>Non hai scritto nessun testo</strong></p>'
    .   '<p>Devi inserire nella form il testo da inviare.</p>';   
}
?>
    </h1>
    </div>			
</div>
<!-- Footer page -->
<?php include ('theme/footer.php');?>