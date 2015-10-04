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
                <td>Data invio</td>
            </tr>
            <tr>
                <td>Messaggio</td>
            </tr>
            <tr>
                <td>User Send</td>
            </tr>
            <?php
            /******
             * This function filter message send for single user
             ******/
            $id_message=filter_input(INPUT_POST, 'id_message', FILTER_SANITIZE_STRING);
            $messageSend = dbJoinMessageSend($id_message);
            foreach ($messageSend as $message) { 
                echo '<tr>';
                   echo '<td>'.$message['DataInsert'].'</td>';
                echo '</tr>';
                echo '<tr>';
                   echo '<td>'.$message['Text'].'</td>';
                echo '</tr>';
                echo '<tr>';
                   echo '<td>'.$message['Signature'].'</td>';
                echo '</tr>';
                    }
             ?>      
          </table>
    </div>			
</div>
<!-- Footer page -->
<?php
include('theme/footer.php');