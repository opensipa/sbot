<?php
include ('theme/verification.php');
include ('theme/header.php');
include ('functions/function.php');
include ('functions/functionDb.php');
include ('config.php');
include ('init.php');
$userActive = dbCountActiveUsers();
?>
	<div id="content" class="clearfix">
            <div align="center">
                <!-- Utenti attivi inseriti nel database  -->
                <h2>Ci sono attualmente <strong> <?php echo $userActive; ?> </strong> utenti attivi in {S}BOT.</h2>
                <table border="1" align="center" id="order">
                    <thead>
                    <tr>
                        <th><span>ID utente</span></th>
                        <th><span>First name</span></th>
                        <th><span>Last name</span></th>
                        <th><span>Date add user</span></th>
                    </tr>
                    </thead>
                    <tbody> 
                    <?php $activeUsers = dbActiveUsersFull();
                        foreach ($activeUsers as $user) { 
                            echo '<tr class="lalign">';
                            echo '<td>'.$user['UserID'].'</td>';
                            echo '<td>'.$user['FirstName'].'</td>';
                            echo '<td>'.$user['LastName'].'</td>';
                            echo '<td>'.$user['DataInsert'].'</td>';
                            echo '</tr>';
                        }
                    ?> 
                    </tbody>
                </table>
                <!-- table order --> 
                <script type="text/javascript">
                  $(function(){
                  $('#order').tablesorter(); 
                  });
                </script>
            </div>			
	</div>
  
<!-- footer page -->  
<?php include 'theme/footer.php'; ?>