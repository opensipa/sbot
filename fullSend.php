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
            <?php
            /******
             * questa fase cicla sugli utenti attivi inseriti nel database 
             ******/

            $messageSend = dbLogTextFullSend();

            echo '<tr>';
                   echo '<td>Data inserimento</td>';
                   echo '<td>Messaggio</td>';
            echo '</tr>';

            foreach ($messageSend as $message) { 
                echo '<tr>';
                   echo '<td>'.$message['DataInsert'].'</td>';
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