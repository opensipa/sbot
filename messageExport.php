<?php 
include ('theme/verification.php');
include ('config.php');
include ('init.php');
include ('functions/function.php');
include ('functions/functionDb.php');
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
        <link rel="shortcut icon" href="img/favicon.ico" >
        <title>{S}Bot - Telegram Bot by OpenSipa</title>
    </head>
    <body>
    <div id="content" class="clearfix">
        <div class="content-row">
            <br>
            <table border="1">              
                <tr>
                    <td>First name</td>
                    <td>Data inserimento</td>
                    <td>Messaggio</td
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
                }
                ?>
                </table>	
        </div>			
    </div>
    </body>
</html>