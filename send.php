<?php include 'theme/verification.php'; ?>
<?php include 'theme/header.php'; ?>

	<div id="content" class="clearfix">
		<div class="content-row">
			<h1>
<?php

include("config.php");
include("init.php");
include("functions/function.php");
include("functions/functionDb.php");

//Recupero il valore del parametro "nome"

$testo_ricevuto=filter_input(INPUT_POST, 'testo', FILTER_SANITIZE_STRING);


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
dbLogTextSend ($testo_ricevuto);

echo '<p>Hai inviato il seguente testo: <br> "<strong>'.$testo_ricevuto.'</strong>"</p>';
echo '<p>Ha inviato il testo a <strong>'.$numeroInvi.'</strong> utenti del servizio.</p>';

/* torna in admin */
echo '<h2><p><a href="admin.php">Torna alla pagina di Gestione</a></p></h2> ';
?>
				</h1>
			</div>			
	</div>

<?php include 'theme/footer.php'; ?>