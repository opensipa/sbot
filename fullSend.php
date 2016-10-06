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
        $selectedRadio = $_POST['update_archivia'];
        foreach ($selectedRadio as $value){
        dbLogTextUpdateSend($value);  
        }
    }
?>
<div id="content" class="clearfix">
    <div class="content-row">
        <form method="post" action="fullSend.php" />
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
            /*
             * Manufacturer data table
             */
            $messageSend = dbLogTextFullSend();
            foreach ($messageSend as $message) { 
                echo ' <tr> ';
                   echo '<td>'.(date('d/m/Y H:i:s', strtotime($message['DataInsert']))).' </td>';
                   echo '<td>'.$message['Signature'].' </td>';
                   echo '<td>'.$message['Text'].' </td>';
                   echo '<td align="center"> <input type="checkbox" name="update_archivia[]" value="'.$message['ID'].'" /> </td> ';
                echo ' </tr> ';
            }
?>      
        </table>
        </form>
    </div>			
</div>
<!-- Footer page -->
<?php include('theme/footer.php'); ?>