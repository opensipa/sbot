<?php
include ('theme/verification.php');
include ('theme/header.php');
include ('functions/function.php');
include ('functions/functionDb.php');
include ('functions/functionInit.php');
include ('config.php');
include ('init.php');
include ('functions/passwordHash.php');
?>
<div id="content" class="clearfix">
    <div class="content-row">
    <h2>Per inserire nuovi parametri di gestione, compila questi campi:</h2>
        <form id='setting' action='panel.php' method='post' accept-charset='UTF-8'>
            <fieldset >
            <legend>Settaggi</legend>
            <input type='hidden' name='state' id='state' value='1'/>
            <label for='software' >Software*: </label>
            <input type='software' name='software' id='software' maxlength="50" />
            <label for='code' >Variabile*: </label>
            <input type='code' name='code' id='code' maxlength="20" />
            <label for='param' >Valore*: </label>
            <input type='param' name='param' id='param' maxlength="50" />
            <label for='note' >Note: </label>
            <input type='note' name='note' id='note' maxlength="200" />
            <input type='submit' name='Inserisci' value='Inserisci' />
            </fieldset>
        </form>
    </div>
</div>

<?php
// Form for insert the variable into table

if (isset($_POST["Inserisci"])) {
    $state = filter_input(INPUT_POST, 'state', FILTER_SANITIZE_STRING);
    $username = $_SESSION['username'];
    $software = filter_input(INPUT_POST, 'software', FILTER_SANITIZE_STRING);
    $code = filter_input(INPUT_POST, 'code', FILTER_SANITIZE_STRING);
    $param = filter_input(INPUT_POST, 'param', FILTER_SANITIZE_STRING);
    $note = filter_input(INPUT_POST, 'note', FILTER_SANITIZE_STRING);
    $submit = filter_input(INPUT_POST, 'Inserisci', FILTER_SANITIZE_STRING);

if (!empty($submit)) {
    dbParamInsert($software, $code, $param, $state, $username, $note);
    header( "refresh:5;url=panel.php" );   
    echo '<div id="content" class="clearfix">';
    echo'<div class="content-row">'
        .   '<strong>Hai inserito correttamente il nuovo parametro</strong>'
        .   '</div></div>';
} else  {	
    echo '<div id="content" class="clearfix">';
	echo '<div class="content-row">';
        echo '<h2>Hai inserito in modo sbagliato il parametro, ritenta!</h2>';
    echo '</div></div>'; 
  }
}
?>

<?php
// Form for view the table for update setting variable

if (isset($_POST["Valori"])) {
    $ID = filter_input(INPUT_POST, 'ID', FILTER_SANITIZE_STRING);
    $extractParam = dbParamExtraction('ID = '.$ID);
//Variable extract: Code, Param, SoftDesc, Active, Log, ID
    foreach ($extractParam as $extract) {
    echo '
        <div id="content" class="clearfix">
        <div class="content-row">
        <h2>Modifica i parametri:</h2>
        <form id="changesetting" action="panel.php" method="post" accept-charset="UTF-8">
            <fieldset >
            <legend>Aggiorna i Settaggi</legend>
            <label for="software" >Software*: </label>
            <input type="software" name="software" id="software" value="'.$extract['SoftDesc'].'" maxlength="50" />
            <label for="code" >Variabile*: </label>
            <input type="code" name="code" id="code" value="'.$extract['Code'].'" maxlength="20" />
            <label for="param" >Valore*: </label>
            <input type="param" name="param" id="param" value="'.$extract['Param'].'" maxlength="50" />
            <label for="note" >Note: </label>
            <input type="note" name="note" id="note" value="'.$extract['Note'].'" maxlength="200" />
            <label for="active" >Stato*: </label>
            <select name="active">
            <option value="1">Attivo</option>
            <option value="0">Disattivo</option>
            </select>
            <input type="hidden" name="ID" id="ID" value="'.$extract['ID'].'" />
            <br>
            <input type="submit" name="Cambia" value="Cambia" />
            </fieldset>
        </form>
        </div></div>
        ';
    }
}
// Change the variable

if (isset($_POST["Cambia"])) {
    $software = filter_input(INPUT_POST, 'software', FILTER_SANITIZE_STRING);
    $code = filter_input(INPUT_POST, 'code', FILTER_SANITIZE_STRING);
    $param = filter_input(INPUT_POST, 'param', FILTER_SANITIZE_STRING);
    $note = filter_input(INPUT_POST, 'note', FILTER_SANITIZE_STRING);
    $ID = filter_input(INPUT_POST, 'ID', FILTER_SANITIZE_STRING);
    $state = filter_input(INPUT_POST, 'active', FILTER_SANITIZE_STRING);
    $user = $_SESSION['username'];
    $submit = filter_input(INPUT_POST, 'Cambia', FILTER_SANITIZE_STRING);

if (!empty($submit)) {
    dbParamUpdate($ID, $software, $code, $param, $state, $user, $note);
    echo'<div id="content" class="clearfix">
            <div class="content-row">
            <h2>Hai aggiornato correttamente i valori</h2>
        </div></div>'; 
} else  {	
    echo'<div id="content" class="clearfix">
            <div class="content-row">
            <h2>Hai inserito in modo sbagliato il parametro, ritenta!</h2>
        </div></div>'; 
  }
}
?>
<?php
if (isset($_POST["Test"])) {
    $submit = filter_input(INPUT_POST, 'Test', FILTER_SANITIZE_STRING);

if (!empty($submit)) {
    $error = sendMail("Test di configurazione","Configurazione OK.");
    if (empty($error)){
        echo'<div id="content" class="clearfix">
                <div class="content-row">
                <h2>Hai configurato correttamente la mail. Controlla se ti &egrave; arrivato il messaggio via e-mail.</h2>
            </div></div>'; 
        } else {	
        echo'<div id="content" class="clearfix">
                <div class="content-row">
                <h2>Errore: '.$error.'.</h2>
            </div></div>'; 
        }
    }
}
?>

<!-- Table for view the variable of bot -->
<div id="content" class="clearfix">
    <div class="content-row">
        <form method="post" action="panel.php">
        <div align="center">  
        <button type='submit' name='Valori' value='Valori' />Modifica i valori dei parametri</button>
        <button type='submit' name='Test' value='Test '/>Test di configurazione Mail</button>
        </div>
        <br>
        <table border="1" align="center" id="order"> 
            <thead>
                <tr>
                <th><span>Descrizione Software</span></th>
                <th><span>Variabile</span></th>
                <th><span>Valore</span></th>
                <th><span>Att/Disatt</span></th>
                <th><span>Note</span></th>
                <th><span>Log</span></th>
                <th><span>Modifica</span></th>
                </tr>
            </thead>             
            <tbody>
            <?php $extractParam = dbParamExtraction("SoftDesc is not null");
            foreach ($extractParam as $extract) { 
                echo'<tr class="align">'
                .   '<td>'.$extract['SoftDesc'].'</td>'
                .   '<td>'.$extract['Code'].'</td>'
                .   '<td>'.$extract['Param'].'</td>'
                .   '<td>'.$extract['Active'].'</td>'
                .   '<td>'.$extract['Note'].'</td>'
                .   '<td>'.$extract['Log'].'</td>' 
                .   '<td><input type="radio" name="ID" value="'.$extract['ID'].'" /></td>'
                .   '</tr>';
            }
            ?>
            </tbody>            
        </table>
        </form>
        <!-- table order --> 
        <script type="text/javascript">
            $(function(){
            $('#order').tablesorter(); 
            });
       </script>
    </div>
</div>

<!-- Footer page -->
<?php include ('theme/footer.php');?>