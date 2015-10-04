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
                        <form action="messageExport.php"> 
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
                        <td>Coll.</td>
                        <td>Testo di risposta</td>
                        <td>A:</td>
                    </tr>
                <?php
                /******
                 * This table view the message send by single user
                 ******/
                $messageUsers = dbLogTextFull();
                foreach ($messageUsers as $message) { 
                    echo '<tr>';
                       echo '<td>'.$message['FirstName'].'</td>';
                       echo '<td>'.$message['DataInsert'].'</td>';
                       echo '<td>'.$message['Text'].'</td>';
                       echo '<td>'
                       .    '<form method="post" action="joinMessage.php" method="POST">'
                       .    '<input type="hidden" name="id_message" value="'.$message['Message'].'">'
                       .    '<input type="submit" id="join" name="join" value="Coll."></form>'
                       .    '</td>';
                       echo '<td><form method="post" action="sendSingle.php" method="POST">'
                       .    '<textarea name="testo" rows="1" cols="40" placeholder="Inserisci qui la risposta"></textarea>'
                       .    '</td>';
                       echo '<td><input type="hidden" name="id_user" value="'.$message['UserID'].'">'
                       .    '<input type="hidden" name="id_message" value="'.$message['Message'].'">'
                       .    '<input type="hidden" name="id_total" value="'.$message['ID'].'">'
                       .    '<br>'
                       .    '<input type="submit" id="invia" name="invia" value="Invia messaggio">'
                       .    '</form></td>';
                       echo '</tr>';
                }
                ?>
                </table>	
        </div>			
    </div>

<!-- Footer page -->
<?php include 'theme/footer.php'; ?>
