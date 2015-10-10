<?php
include ('theme/verification.php');
include ('theme/header.php');
include ('functions/function.php');
include ('functions/functionDb.php');
include ('config.php');
include ('init.php');
include ('functions/passwordHash.php');
?>
<div id="content" class="clearfix">
    <div class="content-row">
<h2>Utenti amministratori presenti in {S}BOT:</h2>
  <table border="1" align="left">
    <tr>
      <td>Username</td>
      <td>Signature</td>
    </tr>
  <?php $activeAdmin = dbSelectAdmin();
    foreach ($activeAdmin as $user) { 
        echo '<tr>';
          echo '<td>'.$user['username'].'</td>';
          echo '<td>'.$user['signature'].'</td>';
        echo '</tr>';
    	}
  ?>
  </table>
    </div>
  </div>
	<div id="content" class="clearfix">
		<div class="content-row">
			<h2>Per inserire un nuovo utente in {S}bot compila questi campi:</h2>
				   <form id='pwd' action='addAdmin.php' method='post' accept-charset='UTF-8'>
					  <fieldset >
					  <legend>Inserisci nuovo utente</legend>
					  <label for='username' >Username*: </label>
					  <input type='username' name='username' id='username' maxlength="50" />
					  <label for='password' >Password*: </label>
					  <input type='password' name='password' id='password' maxlength="50" />
					  <label for='signature' >Firma*: </label>
					  <input type='signature' name='signature' id='signature' maxlength="50" />
					  <input type='submit' name='Aggiungi' value='Aggiungi' />
					  </fieldset>
				</form>
		</div>
		<div class="content-row">
			<h2>Per cambiare la firma in {S}bot compila questo campo:</h2>
				   <form id='changeSignature' action='addAdmin.php' method='post' accept-charset='UTF-8'>
					  <fieldset >
					  <legend>Cambia la firma</legend>
					  <label for='signature' >Firma*: </label>
					  <input type='signature' name='signature' id='signature' maxlength="50" />
					  <input type='submit' name='Cambia' value='Cambia' />
					  </fieldset>
				</form>
		</div>
	</div>

<?php
if (isset($_POST["Aggiungi"])) {
    $username= filter_input(INPUT_POST, 'username', FILTER_SANITIZE_EMAIL);
    $password=filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $signature=filter_input(INPUT_POST, 'signature', FILTER_SANITIZE_STRING);
    $aggiungi = filter_input(INPUT_POST, 'Aggiungi', FILTER_SANITIZE_STRING);
    //controllo se i campi sono compilati
    if (!empty($aggiungi)) {
        // Richiamo la funzione di inserimento
        if( dbInsertAdmin ($username, $password, $signature) == 1){
            echo '<div id="content" class="clearfix">';
                  echo '<div class="content-row">';
            echo '<h2>Hai inserito un utente gi&agrave; presente nella banca dati. Scegli una username differente.</h2>';
            echo '</div></div>';
          } else {
            echo '<div id="content" class="clearfix">';
                  echo '<div class="content-row">';
            echo '<h2>Hai inserito correttamente l\'utente: '.$username.'</h2>';
            echo '<br>Al prossimo login puoi effettuare l\'accesso con il nuovo utente.';
            echo '</div></div>';
        }
    }
}
if (isset($_POST["Cambia"])) {
    $username=$_SESSION['username'];
    $signature=filter_input(INPUT_POST, 'signature', FILTER_SANITIZE_STRING);
    $cambia = filter_input(INPUT_POST, 'Cambia', FILTER_SANITIZE_STRING);
    echo 'ci sono';
    if (!empty($cambia)) { 
        if(dbUpdateAdmin ($username, $signature) == 1){
            echo '<div id="content" class="clearfix">';
                  echo '<div class="content-row">';
            echo '<h2>Sono accorsi degli errori, ritenta il cambio firma.</h2>';
            echo '</div></div>';
          } else {
            echo '<div id="content" class="clearfix">';
                  echo '<div class="content-row">';
            echo '<h2>Hai inserito correttamente la nuova firma: '.$signature.' per l\'utente '.$username.'</h2>';
            echo '</div></div>';
        }
    }   
}
?>
<!-- Footer della pagina html -->
<?php include 'theme/footer.php'; ?>