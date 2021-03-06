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
    <h2>Per cambiare la password di <strong> <?php echo $_SESSION['username'] ?> </strong> in {S}bot compila questi campi:</h2>
        <form id="pwd" action="changePwd.php" method="post" accept-charset="UTF-8">
            <fieldset >
            <legend>Cambio password</legend>
            <div class="form-group">
            <input class="form-control" type="hidden" name="submitted" id="submitted" value="1"/>
            <label for="password" >Nuova Password*: </label>
            <input class="form-control" type="password" name="password" id="password" maxlength="50" />
            <label for="newpassword" >Ripeti Password*: </label>
            <input class="form-control" type="password" name="newpassword" id="newpassword" maxlength="50" />
            <input type="submit" name="Submit" value="Submit" />
            </div>
            </fieldset>
        </form>
</div>

<?php

if (isset($_POST["Submit"])) {

$username=$_SESSION['username'];
$password=filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
$newpassword=filter_input(INPUT_POST, 'newpassword', FILTER_SANITIZE_STRING);
$submit = filter_input(INPUT_POST, 'Submit', FILTER_SANITIZE_STRING);

//controllo se inserito le password due volte uguali

if ($password==$newpassword){
if (!empty($submit)) {
    dbUpdatePwd($username,$password);
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
<!-- Footer page -->
<?php include ('theme/footer.php');?>