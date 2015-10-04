<?php
include ('theme/verification.php'); 
include ('theme/header.php'); 
include ('config.php');
include ('init.php');
include ('functions/function.php');
include ('functions/functionDb.php');
?>

	<div id="content" class="clearfix">
            <div class="content-row">
			<h1>
                <?php
                //Ricevo il testo e id utente a cui inviare il messaggio da message.php
                $testo_ricevuto = filter_input(INPUT_POST, 'testo', FILTER_SANITIZE_STRING);
                $id_user = filter_input(INPUT_POST, 'id_user', FILTER_SANITIZE_STRING);
                $id_message = filter_input(INPUT_POST, 'id_message', FILTER_SANITIZE_STRING);
                $id_total = filter_input(INPUT_POST, 'id_total', FILTER_SANITIZE_STRING);

                /******
                 * questa fase cicla sugli utenti attivi inseriti nel database e per ciascun id
                 * richiama la funzione sendMessage per spedire il testo passato con post
                 * ogni chat_id una singola spedizione messaggio
                 ******/
                $testo_ricevuto_add = $testo_ricevuto.' Inviato da: '.$_SESSION['signature']; 
                sendMessage($id_user, $testo_ricevuto_add);
                dbLogTextSend ($testo_ricevuto,$_SESSION['username'],$id_message, $id_total);
                ?>
                <p>Hai inviato il seguente testo: <br> <strong><?php echo $testo_ricevuto; ?></strong></p>
                <p>Al seguente identificativo: <br> <strong><?php echo $id_user; ?></strong></p>
			</h1>
            </div>			
	</div>
<!-- Footer page -->
<?php include 'theme/footer.php'; ?>