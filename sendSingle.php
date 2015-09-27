<?php
include 'theme/verification.php'; 
include 'theme/header.php'; 
include("config.php");
include("init.php");
include("functions/function.php");
include("functions/functionDb.php");
?>

	<div id="content" class="clearfix">
		<div class="content-row">
			<h1>
                <?php
                //Ricevo il testo e id utente a cui inviare il messaggio da message.php
                $testo_ricevuto = filter_input(INPUT_POST, 'testo', FILTER_SANITIZE_STRING);
                $nome_var = filter_input(INPUT_POST, 'nome_var', FILTER_SANITIZE_STRING);

                /******
                 * questa fase cicla sugli utenti attivi inseriti nel database e per ciascun id
                 * richiama la funzione sendMessage per spedire il testo passato con post
                 * ogni chat_id una singola spedizione messaggio
                 ******/

                sendMessage($nome_var, $testo_ricevuto);
                dbLogTextSend ($testo_ricevuto);
                ?>
                <p>Hai inviato il seguente testo: <br> <strong><?php echo $testo_ricevuto; ?></strong></p>
                <p>Al seguente identificativo: <br> <strong><?php echo $nome_var; ?></strong></p>
			</h1>
		</div>			
	</div>
<!-- Footer page -->
<?php include 'theme/footer.php'; ?>