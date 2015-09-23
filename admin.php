<?php include 'theme/verification.php'; ?>
<?php include 'theme/header.php'; ?>
	<div>
		<ul>
			<h2>
			<a href="user.php">Utenti attivi in {S}BOT</a> | 
			<a href="coda.php">Coda dal sito Telegram</a> | 
			<a href="message.php">Messaggi degli utenti</a> |
      		<a href="fullSend.php">Messaggi inviati</a> |  
			<a href="#">Cambio password</a>
			</h2>
		</ul>
	</div>

	<div id="content" class="clearfix">
		<div class="content-row">
				<h1>Il servizio risulta attivo con il seguente pid:
				<?php 
				$pid = shell_exec('pidof php'); 		//Questo comando restituisce il pid del processo che deve rimanere in ascolto
				echo $pid;
				?>
				</h1>
				<form action="admin.php"> 
					<input type="submit" name="submit" value="Aggiorna">
				</form> 
					
		</div>
	</div>
		<div id="content" class="clearfix">
			<div class="content-row">
				<h1>Per inviare un messaggio usa questo form:</h1>
					 <form method="post" action="send.php" method="POST">
						<textarea name="testo" rows="9" cols="60">Testo avviso da inviare..</textarea>
						<br>
						<input type="submit" name="invia" value="Invia messaggio">
					</form>
				
			</div>
	</div>
		<div id="content" class="clearfix">
			<div class="content-row">
				<h1>Invia una immagine (attenzione che ci potrebbe impiegare molto - attendi esito finale -):</h1>
				<br>
					<form action="upload.php" method="post" enctype="multipart/form-data">
						<!-- Campo file di nome "image" -->
						<input name="image" type="file" size="40" />
						<br><br>
						<!-- Pulsante -->
						<input name="upload" type="submit" value="Procedi con l'invio" />
					</form> 
			</div>			
	</div>
<?php include 'theme/footer.php'; ?>