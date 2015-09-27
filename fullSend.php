<?php
include('theme/verification.php');
include('theme/header.php');
include('config.php');
include('init.php');
include('functions/function.php');
include('functions/functionDb.php');
?>

<div id="content" class="clearfix">
    <div id="top_menu">
        <?php topMenu($menu);?>
    </div>

    <div class="content-row">
        <form action="fullSend.php"> 
           <input type="submit" name="submit" value="Aggiorna">
        </form> 
	<br>
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
include('theme/footer.php');
