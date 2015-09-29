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
		<form action="message.php"> 
                <input type="submit" name="submit" value="Aggiorna">
		</form> 
                <br>
                <table border="1">
                    <tr>
                        <td>First name</td>
                        <td>Data inserimento</td>
                        <td>Messaggio</td>
                        <td>Testo di risposta</td>
                        <td>A:</td>
                    </tr>
                <?php
                /******
                 * questa fase cicla sugli utenti attivi inseriti nel database 
                 ******/
                $messageUsers = dbLogTextFull();
                foreach ($messageUsers as $message) { 
                    echo '<tr>';
                       echo '<td>'.$message['FirstName'].'</td>';
                       echo '<td>'.$message['DataInsert'].'</td>';
                       echo '<td>'.$message['Text'].'</td>';
                       echo '<td><form method="post" action="sendSingle.php" method="POST">';
                       echo '<textarea name="testo" rows="1" cols="40">Testo di risposta...</textarea>';
                       echo '<td>';
                       echo '<input type="hidden" name="nome_var" value="'.$message['UserID'].'">';
                       echo '<br>';
                       echo '<input type="submit" name="invia" value="Invia messaggio">';
                       echo '</form></td>';
                       echo '</tr>';
                }
                ?>
                </table>	
        </div>			
    </div>

<!-- Footer page -->
<?php include 'theme/footer.php'; ?>
