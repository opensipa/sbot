<?php
include('theme/verification.php');
include('theme/header.php');
include('functions/function.php');
include('functions/functionDb.php');
include('config.php');
include('functions/functionInit.php');
?>
<?php
if (isset($_POST['Archivia'])) {
        $selected_radio = $_POST['update_archivia'];
        foreach ($selected_radio as $value){
        dbLogTextUpdateSend ($value);  
        }
    }
?>

<div id="content" class="clearfix">
    <div class="content-row">
        <form method="post" action="fullSend.php" method="POST" />
            <input type="submit" name="Archivia" value="Archivia" />
            <br><br>
	<table border="1">
            <tr>
                <td>Data inserimento</td>
                <td>Inviato da</td>
                <td>Messaggio</td>
                <td>Archivia</td>
            </tr>
<?php
            /******
             * questa fase cicla sui messaggi inviati agli utenti 
             ******/
            $messageSend = dbLogTextFullSend();
            foreach ($messageSend as $message) { 
                echo '<tr>';
                   echo '<td>'.(date('d/m/Y H:i:s', strtotime($message['DataInsert']))).'</td>';
                   echo '<td>'.$message['Signature'].'</td>';
                   echo '<td>'.$message['Text'].'</td>';
                   echo '<td align="center"><input type="checkbox" name="update_archivia[]" value="'.$message['ID'].'" /></td>';
                echo '</tr>';
            }
?>      
          </table>
    </form>
    </div>			
</div>
<div id="content" class="clearfix">
        <div class="content-row">
        <br>
        <form action="messageExport.php"> 
        <input type="submit" name="esporta" value="Esporta in Excel" />
        </form>
    </div>
</div>
<!-- Footer page -->
<?php include('theme/footer.php'); ?>