<?php 
include ('theme/verification.php');
include ('theme/header.php');
include ('functions/function.php');
include ('functions/functionDb.php');
include ('config.php');
include ('init.php');
?>

    <div id="content" class="clearfix">
        <div class="content-row">
            <table border="0">
                <tr>
                    <td>
                        <form action="message.php"> 
                        <input type="submit" name="submit" value="Aggiorna">
                        </form> 
                    </td>
                    <td>
                        <form action="sbotWeb/messageExport.php"> 
                        <input type="submit" name="submit" value="Esporta in Excel">
                        </form>
                    </td>
                </tr>
            </table> 
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
                       echo '<textarea name="testo" rows="1" cols="40" placeholder="Inserisci qui la risposta"></textarea>';
                       echo '<td>';
                       echo '<input name="nome_var" value="'.$message['UserID'].'">';
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
