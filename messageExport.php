<?php 
include ('theme/verification.php');
include ('config.php');
include ('functions/functionInit.php');
include ('functions/function.php');
include ('functions/functionDb.php');

//Config export
$filename="sheet.xls";
header ("Content-Type: application/vnd.ms-excel");
header ("Content-Disposition: inline; filename=$filename");
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="copyright" content="Copyright 2015 © Opensipa">
        <meta name="language" content="italian">
        <meta name="email" content="opensipa[at]gmail[dot]com @gmail">
        <title>Telegram Bot</title>
    </head>
    <body>
    <div id="content" class="clearfix">
        <div class="content-row">
            <br>
            <table border="1">              
                <tr>
                    <td>Nome utente</td>
                    <td>Data inserimento</td>
                    <td>Messaggio ricevuto</td
                </tr>
                <?php
                /*
                 * Manufacturer data table
                 */
                $messageUsers = dbLogTextFull();
                foreach ($messageUsers as $message) { 
                    echo '<tr>';
                       echo '<td>'.$message['FirstName'].'</td>';
                       echo '<td>'.(date('d/m/Y H:i:s', strtotime($message['DataInsert']))).'</td>';
                       echo '<td>'.$message['Text'].'</td>';
                }
                ?>
                </table>	
        </div>			
    </div>
    </body>
</html>