<?php
include ('theme/verification.php');
include ('theme/header.php');
include ('config.php');
include ('init.php');
include ('functions/function.php');
include ('functions/functionDb.php');
$userActive = dbCountActiveUsers();
?>

	<div id="content" class="clearfix">
            <div align="center">
                <!-- Utenti attivi inseriti nel database  -->
                <h2>Ci sono attualmente <strong> <?php echo $userActive; ?> </strong> utenti attivi in {S}BOT.</h2>
                <table border="1" align="center">
                    <tr>
                        <td>ID utente</td>
                        <td>First name</td>
                        <td>Last name</td>
                        <td>Date add user</td>
                    </tr>
                    <?php $activeUsers = dbActiveUsersFull();
                        foreach ($activeUsers as $user) { 
                            echo '<tr>';
                            echo '<td>'.$user['UserID'].'</td>';
                            echo '<td>'.$user['FirstName'].'</td>';
                            echo '<td>'.$user['LastName'].'</td>';
                            echo '<td>'.$user['DataInsert'].'</td>';
                            echo '</tr>';
                        }
                    ?>
                </table>

            </div>			
	</div>
  
<!-- footer page -->  
<?php include 'theme/footer.php'; ?>