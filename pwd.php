<?php
include 'theme/verification.php';
include 'theme/header.php';
include("config.php");
include("init.php");
include("functions/function.php");
include("functions/functionDb.php");
include("functions/passwordHash.php");
?>

	<div id="content" class="clearfix">
		<div class="content-row">
				<h2>Per cambiare la password di gestione di {S}bot compila questi campi:</h2>
				   <form id='pwd' action='pwd.php' method='post' accept-charset='UTF-8'>
					  <fieldset >
					  <legend>Cambio password</legend>
					  <input type='hidden' name='submitted' id='submitted' value='1'/>
					  <label for='username' >UserName*:</label>
					  <input type='text' name='username' id='username'  maxlength="50" />
					  <label for='password' >Nuova Password*: </label>
					  <input type='password' name='password' id='password' maxlength="50" />
					  <label for='newpassword' >Ripeti Password*: </label>
					  <input type='password' name='newpassword' id='newpassword' maxlength="50" />
					  <input type='submit' name='Submit' value='Submit' />
					  </fieldset>
				</form>

		</div>
	</div>

<?php

if (isset($_POST["Submit"])) {

$username=filter_input(INPUT_POST, 'username', FILTER_SANITIZE_EMAIL);
$password=filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
$newpassword=filter_input(INPUT_POST, 'newpassword', FILTER_SANITIZE_STRING);
$submit = filter_input(INPUT_POST, 'Submit', FILTER_SANITIZE_STRING);

//Deprecato con aggiunta salt password
//convert password for security in sha 256 
//$password = hash('sha256', $password); //hash 256 della password
//$newpassword = hash('sha256', $newpassword); //hash 256 della password

//controllo se inserito le password due volte uguali

if ($password==$newpassword){
if (!empty($submit)) {
    $conn=getDbConnection();
    //update password in to mysql with sha-256
    $sql="update admins set password=:password where username=:username";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':username',$username, PDO::PARAM_STR);
    $stmt->bindValue(':password',create_hash($password), PDO::PARAM_STR);    
    $stmt->execute();
    echo '<div id="content" class="clearfix">';
	  echo '<div class="content-row">';
    echo '<h2>Hai cambiato correttamente la password. </h2>';
    echo '<br>Al prossimo login effettua l\'accesso con la nuova password.';
    echo '</div></div>';
  }
} else  {	
	  echo '<div id="content" class="clearfix">';
	  echo '<div class="content-row">';
    echo '<h2>Hai inserito in modo sbagliato la password reinserisci i dati correttamente: Ritenta!</h2>';
    echo '</div></div>'; 
  }
}
?>

<!-- Footer della pagina html -->
<?php include 'theme/footer.php'; ?>
