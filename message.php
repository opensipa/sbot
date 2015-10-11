<?php 
include ('theme/verification.php');
include ('theme/header.php');
include ('functions/function.php');
include ('functions/functionDb.php');
include ('config.php');
include ('init.php');

ini_set('display_errors','On');
error_reporting(E_ALL);
?>
<?php
if (isset($_POST['Archivia'])) {
        $selected_radio = $_POST['update_archivia'];
        foreach ($selected_radio as $value){
        dbLogTextUpdate ($value);  
        }
    }
?>
    <div id="content" class="clearfix">
        <div class="content-row">
            <form method="post" action="message.php" method="POST">
            <input type='submit' name='Archivia' value='Archivia' />
            <br> <br>    
            <table border="1">
                <tr>
                    <td>Data inserimento</td>
                    <td>Nome</td>
                    <td>Messaggio ricevuto</td>
                    <td>Archivia</td>
                    <td>Risp.</td>
                    <td>Messaggio</td>
                    <td>Invia</td>
                </tr>
                <?php
                /******
                 * This table view the message send by single user
                 ******/
                $messageUsers = dbLogTextFull();
                foreach ($messageUsers as $message) { 
                    echo '<tr>';
                       echo '<td>'.(date('d/m/Y H:i', strtotime($message['DataInsert']))).'</td>';
                       echo '<td>'.$message['FirstName'].'</td>';
                       echo '<td>'.$message['Text'].'</td>';
                       echo '<td align="center">'
                       .    '<input type="checkbox" name="update_archivia[]" value="'.$message['ID'].'" />'
                       .    '</td>';
                       echo '<td>'
                       .    '<form method="post" action="joinMessage.php" method="POST">'
                       .    '<input type="hidden" name="id_message" value="'.$message['Message'].'">'
                       .    '<input type="submit" id="join" name="join" value="+"></form>'
                       .    '</td>';
                       echo '<td><form method="post" action="sendSingle.php" method="POST">'
                       .    '<textarea name="testo" rows="2" cols="40" placeholder="Inserisci qui la risposta.."></textarea>'
                       .    '</td>'
                       .    '<td><input type="hidden" name="id_user" value="'.$message['UserID'].'">'
                       .    '<input type="hidden" name="id_message" value="'.$message['Message'].'">'
                       .    '<input type="hidden" name="id_total" value="'.$message['ID'].'">'
                       .    '<br>'
                       .    '<input type="submit" id="invia" name="invia" value="Invia">'
                       .    '</form></td>';
                       echo '</tr>';
                }
                ?>
            </table>
            </form>	
        </div>
        <div class="content-row">
            <form action="messageExport.php"> 
            <input type="submit" name="esporta" value="Esporta in Excel" />
            </form>
        </div>			
    </div>

<!-- Footer page -->
<?php include 'theme/footer.php'; ?>