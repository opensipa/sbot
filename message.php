<?php 
include ('theme/verification.php');
include ('theme/header.php');
include ('functions/function.php');
include ('functions/functionDb.php');
include ('config.php');
include ('init.php');
?>
<?php
if (isset($_POST['Archivia'])) {
        $selected_radio = $_POST['update_archivia'];
        foreach ($selected_radio as $value){
        dbLogTextUpdate($value);  
        }
    }
?>
<div id="content" class="clearfix">
        <div align="center">
            <form method="post" action="search.php" method="POST" />
            <fieldset>
            <legend>Funzione di ricerca dei messaggi ricevuti</legend>
            <label><strong>La funzione di ricerca utilizza al massimo UNA PAROLA CHIAVE.</strong></label><br>
            Recenti <input type="radio" name="messaggi" value="1" checked="checked" />
            Archivio<input type="radio" name="messaggi" value="0"/><br>
            <input type="text" name="testo" style="width: 400px;" />
            <input type="submit" id="cerca" name="Cerca" value="Cerca" />
            </fieldset>
            </form>
        </div>
        <div class="content-row">
            <table border="1">
                <tr>
                    <td>Data inserimento</td>
                    <td>Nome</td>
                    <td>Messaggio ricevuto</td>
                    <td>Messaggio</td>
                    <td>Risp.</td>
                    <td>Archivia</td>
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
                       echo '<td>'
                       .    '<form method="post" action="sendSingle.php" method="POST" />'
                       .    '<textarea name="testo" rows="2" cols="40" placeholder="Inserisci qui la risposta.."></textarea>'
                       .    '<input type="hidden" name="id_user" value="'.$message['UserID'].'" />'
                       .    '<input type="hidden" name="id_message" value="'.$message['Message'].'" />'
                       .    '<input type="hidden" name="id_total" value="'.$message['ID'].'" />'
                       .    '<br>'
                       .    '<input type="submit" id="invia" name="invia" value="Invia" />'
                       .    '</form></td>';
                        echo '<td>'
                       .    '<form method="post" action="joinMessage.php" method="POST" />'
                       .    '<input type="hidden" name="id_message" value="'.$message['Message'].'" />'
                       .    '<input type="submit" id="join" name="join" value="+"></form>'
                       .    '</td>';
                       echo '<td align="center">'
                       .    '<form method="post" action="message.php" method="POST" />'
                       .    '<input type="hidden" name="update_archivia[]" value="'.$message['ID'].'" />'
                       .    '<input type="submit" name="Archivia" value="Archivia" />'
                       .    '</td>';
                       echo '</tr>';
                }
                ?>
            </table>
            </form>	
        </div>
        <div class="content-row">
            <br>
            <form action="messageExport.php"> 
            <input type="submit" name="esporta" value="Esporta in Excel" />
            </form>
        </div>			
    </div>

<!-- Footer page -->
<?php include 'theme/footer.php'; ?>