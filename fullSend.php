<?php
include('theme/verification.php');
include('theme/header.php');
include('functions/function.php');
include('functions/functionDb.php');
include('config.php');
include('init.php');
?>

<div id="content" class="clearfix">
    <div class="content-row">
	<table border="1">
            <tr>
                <td>Data inserimento</td>
                <td>Messaggio</td>
            </tr>
<?php
            /******
             * questa fase cicla sui messaggi inviati agli utenti 
             ******/
            $messageSend = dbLogTextFullSend();
            foreach ($messageSend as $message) { 
                echo '<tr>';
                   echo '<td>'.(date('d/m/Y H:i:s', strtotime($message['DataInsert']))).'</td>';
                   echo '<td>'.$message['Text'].'</td>';
                echo '</tr>';
            }
?>      
          </table>
    </div>			
</div>


<!-- Footer page -->
<?php
include('theme/footer.php');