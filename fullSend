<?php include 'theme/verification.php'; ?>
<?php include 'theme/header.php'; ?>

	<div id="content" class="clearfix">
		<div class="content-row">

		<h2><p><a href="admin.php">Torna alla pagina di Gestione</a></p></h2>
		<form action="fullSend.php"> 
				<input type="submit" name="submit" value="Aggiorna">
		</form> 
		<br>
	<table border="1">
<?php

include("config.php");
include("init.php");
include("functions/function.php");
include("functions/functionDb.php");

/******
 * questa fase cicla sugli utenti attivi inseriti nel database 
 ******/

$messageSend = dbLogTextFullSend();

echo '<tr>';
       echo '<td>Data inserimento</td>';
       echo '<td>Messaggio</td>';
echo '</tr>';

foreach ($messageSend as $message) { 
    echo '<tr>';
       echo '<td>'.$message['DataInsert'].'</td>';
       echo '<td>'.$message['Text'].'</td>';
    echo '</tr>';
	}
echo '</table>';

?>
				
			</div>			
	</div>
<?php include 'theme/footer.php'; ?>
