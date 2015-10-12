<?php
require_once ('theme/verification.php');
require_once ('theme/header.php');
include ('functions/function.php');
include ('functions/functionDb.php');
include ('config.php');
include ('init.php');
include ('functions/passwordHash.php');
?>

<div id="content" class="clearfix">
    <div class="content-row">
        <p><b>Risultati della ricerca:</b></p>
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
                 * This table view the search message for
                 * functione dbLogSearchFull($type, $param1, $param2, $param3)
                 ******/
                $type = filter_input(INPUT_POST, 'messaggi', FILTER_SANITIZE_STRING);
                $testo_ricevuto = filter_input(INPUT_POST, 'testo', FILTER_SANITIZE_STRING);
                /******
                 * questa fase cicla sugli utenti attivi inseriti nel database e per ciascun id
                 * richiama la funzione sendMessage per spedire il testo passato con post
                 * ogni chat_id una singola spedizione messaggio
                 ******/
                if (!empty($testo_ricevuto)){
                $param = explode(" ", $testo_ricevuto);
                $param1 = $param[0];
                $messageUsers = dbLogSearchFull($type, $param1);
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
                } else {
                echo '<p><strong>Non ci sono risultati per il termine di ricerca utilizzato.</strong></p>';
                }
                ?>
            </table>
        </div>
    </div>
<!-- Footer page -->
<?php include 'theme/footer.php'; ?>