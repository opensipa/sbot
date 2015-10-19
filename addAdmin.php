<?php
require ('theme/verification.php');
require ('theme/header.php');
require ('functions/function.php');
require ('functions/functionDb.php');
require ('config.php');
require ('init.php');
include ('functions/passwordHash.php');
?>
<div id="content" class="clearfix">
    <div class="content-row">
    <h2>Utenti amministratori presenti in {S}BOT:</h2>
    <table border="1" align="left">
        <tr>
          <td>Nome Utente</td>
          <td>Firma</td>
          <td>Stato attuale</td>
          <td>Attiva/Disattiva</td>
        </tr>
        <?php $activeAdmin = dbSelectAllAdmin();
        foreach ($activeAdmin as $user) { 
            if($user['active']==1){
                $stato="Attivo";   
            } else {
                $stato="Disattivo";
            }
            echo'<tr>'
            .   '<td>'.$user['username'].'</td>'
            .   '<td>'.$user['signature'].'</td>'
            .   '<td>'.$stato.'</td>'
            .   '<td>'
            .   '<form method="post" action="addAdmin.php" method="POST">'
            .   '<input type="hidden" id="idUser" name="idUser" value='.$user['id'].'/>'
            .   '<input type="hidden" id="idUser" name="user" value='.$user['username'].'/>'
            .   '<select name="stato">'
            .       '<option value="1">Attiva</option>'
            .       '<option value="0">Disattiva</option>'
            .       '</select>'
            .   '<input type="submit" name="Aggiorna" value="Aggiorna" />'
            .   '</form>'
            .   '</tr>';
            }
        ?>
    </table>
<?php
if (isset($_POST["Aggiorna"])) {
    $idUser = filter_input(INPUT_POST, 'idUser', FILTER_SANITIZE_STRING);
    $user = filter_input(INPUT_POST, 'user', FILTER_SANITIZE_EMAIL);
    $active = filter_input(INPUT_POST, 'stato', FILTER_SANITIZE_STRING);
    $aggiorna = filter_input(INPUT_POST, 'Aggiorna', FILTER_SANITIZE_STRING);
    if($active==1){
        $putStato="Attivo";   
    } else {
        $putStato="Disattivo";
    }
    //controllo se i campi sono compilati
    if (!empty($aggiorna)) {
        if (dbChangeStateAdmin ($idUser, $active) == 1){
        echo'<div class="content-row">'
        .   '<p align="center"><h2>E\' accorso un errore, ritenta nuovamente.</h2></p>'
        .   '</div>';
        } else {
        echo'<div class="content-row">'
        .   '<p align="center"><h2>Hai '.$putStato.' correttamente l\'utente: <strong>'.$user.'</strong></h2></p>'
        .   '</div>';
        }   
    }
}
?>
    </div>
    <div class="content-row">
    <h2>Per inserire un nuovo utente in {S}bot compila questi campi:</h2>
        <form id='pwd' action='addAdmin.php' method='post' accept-charset='UTF-8'>
        <fieldset>
            <legend>Inserisci nuovo utente</legend>
            <label for='username' >Username*: </label>
            <input type='username' name='username' id='username' maxlength="50" />
            <label for='password' >Password*: </label>
            <input type='password' name='password' id='password' maxlength="50" />
            <label for='password' >Ripeti Password*: </label>
            <input type='password' name='repeatePassword' id='repeatePassword' maxlength="50" />
            <label for='signature' >Firma*: </label>
            <input type='signature' name='signature' id='signature' maxlength="50" />
            <p align="center"><input type='submit' name='Aggiungi' value='Aggiungi nuovo utente' /></p>
        </fieldset>
	</form>
    </div>
<?php
if (isset($_POST["Aggiungi"])) {
    $username= filter_input(INPUT_POST, 'username', FILTER_SANITIZE_EMAIL);
    $password=filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $repeatePassword=filter_input(INPUT_POST, 'repeatePassword', FILTER_SANITIZE_STRING);
    $signature=filter_input(INPUT_POST, 'signature', FILTER_SANITIZE_STRING);
    $aggiungi = filter_input(INPUT_POST, 'Aggiungi', FILTER_SANITIZE_STRING);
    //controllo se i campi sono compilati
    if (!empty($aggiungi)) {
        if ($repeatePassword == $password){
        // Function to insert new user
        if( dbInsertAdmin ($username, $password, $signature) == 1){
            echo'<div class="content-row">'
            .   '<h2>Hai inserito un utente gi&agrave; presente nella banca dati. Scegli una username differente.</h2>'
            .   '</div></div>';
          } else {
            echo'<div class="content-row">'
            .   '<h2>Hai inserito correttamente l\'utente: '.$username.'</h2>'
            .   '<br>Al prossimo login puoi effettuare l\'accesso con il nuovo utente.'
            .   '</div></div>';
        }
        } else {
            echo '<div id="content" class="clearfix">'
            .   '<div class="content-row">'
            .   '<h2>Hai inserito la password in modo errato, riprova nuovamente.</h2>'
            .   '</div></div>';
        }
    }
}
?>
    <div class="content-row">
    <h2>Per cambiare la firma in {S}bot compila questo campo:</h2>
        <form id='changeSignature' action='addAdmin.php' method='post' accept-charset='UTF-8'>
        <fieldset>
        <legend>Cambia la firma</legend>
        <label for='signature' >Firma*: </label>
        <input type='signature' name='signature' id='signature' maxlength="50" />
        <input type='submit' name='Cambia' value='Cambia la Firma' />
        </fieldset>
        </form>
    </div>
<?php
if (isset($_POST["Cambia"])) {
    $username=$_SESSION['username'];
    $signature=filter_input(INPUT_POST, 'signature', FILTER_SANITIZE_STRING);
    $cambia = filter_input(INPUT_POST, 'Cambia', FILTER_SANITIZE_STRING);
    if (!empty($cambia)) { 
        if(dbChangeSignatureAdmin ($username, $signature) == 1){
            echo'<div class="content-row">'
            .   '<h2>Sono accorsi degli errori, ritenta il cambio firma.</h2>'
            .   '</div>';
          } else {
            echo '<div class="content-row">'
            .   '<h2>Hai inserito correttamente la nuova firma: '.$signature.' per l\'utente '.$username.'</h2>'
            .   '</div>';
        }
    }   
}
?>
</div>
<!-- Footer della pagina html -->
<?php include ('theme/footer.php'); ?>