<?php include 'theme/verification.php'; ?>
<?php include 'theme/header.php'; ?>

	<div id="content" class="clearfix">
		<div class="content-row">
<?php
include("config.php");
include("init.php");
include("functions/function.php");
include("functions/functionDb.php");

/* torna in admin */
echo '<h2><p><a href="admin.php">Torna alla pagina di Gestione</a></p></h2> ';

$userActive = dbCountActiveUsers();
echo '<p>Ci sono attualmente <strong>'.$userActive.'</strong> utenti attivi in {S}BOT.</p>';

/******
 * utenti attivi inseriti nel database 
 ******/
$activeUsers = dbActiveUsersFull();
echo '<table border="1">';
echo '<tr>';
       echo '<td>ID utente</td>';
       echo '<td>First name</td>';
       echo '<td>Last name</td>';
echo '</tr>';

foreach ($activeUsers as $user) { 
    echo '<tr>';
       echo '<td>'.$user['UserID'].'</td>';
       echo '<td>'.$user['FirstName'].'</td>';
       echo '<td>'.$user['LastName'].'</td>';
    echo '</tr>';
	}
echo '</table>';

?>		
			</div>			
	</div>
<?php include 'theme/footer.php'; ?>