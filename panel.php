<?php
include ('theme/verification.php');
include ('theme/header.php');
include ('functions/function.php');
include ('functions/functionDb.php');
include ('config.php');
include ('functions/functionInit.php');
include ('functions/passwordHash.php');
?>
<?php
// Form for view the table for update setting variable
if (isset($_POST["Valori"])) {
    $ID = filter_input(INPUT_POST, 'ID', FILTER_SANITIZE_STRING);
    $extractParam = dbParamExtraction('ID = '.$ID);
    //Variable extract: Code, Param, SoftDesc, Active, Log, ID
    foreach ($extractParam as $extract) {
    echo'
    <div id="content" class="clearfix">
        <form id="changesetting" action="panel.php" method="post" accept-charset="UTF-8">
        <fieldset>
        <legend>Aggiorna i settaggi/paramentri:</legend>
        <div class="form-group">
        <label for="software" >Software*: </label>
        <input class="form-control" type="software" name="software" id="software" value="'.$extract['SoftDesc'].'" readonly />
        <label for="code" >Variabile*: </label>
        <input class="form-control" type="code" name="code" id="code" value="'.$extract['Code'].'" readonly />
        <label for="param" >Valore*: </label>
        <input class="form-control" type="param" name="param" id="param" value="'.$extract['Param'].'" maxlength="300" required="1"/>
        <label for="note" >Note: </label>
        <input class="form-control" type="note" name="note" id="note" value="'.$extract['Note'].'" maxlength="200" />
        <label for="active" >Stato*: </label>
        <select class="form-control" name="active">';
        if ($extract['Active']){
            echo'
                <option value="1">Attivo</option>
                <option value="0">Disattivo</option>';
        }else{
            echo'
                <option value="0">Disattivo</option>
                <option value="1">Attivo</option';
        } 
        echo'
        </select>
        <input class="form-control" type="hidden" name="ID" id="ID" value="'.$extract['ID'].'" />
        <br>
        <input type="submit" name="Cambia" value="Cambia" />
        </div>
        </fieldset>
        </form>
    </div>';
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
            </div>
        </div>'; 
} else  {	
    echo'<div id="content" class="clearfix">
            <div class="content-row">
            <h2>Hai inserito in modo sbagliato il parametro, ritenta!</h2>
            </div>
        </div>'; 
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
                </div>
            </div>'; 
        } else {	
        echo'<div id="content" class="clearfix">
                <div class="content-row">
                <h2>Errore: '.$error.'.</h2>
                </div>
            </div>'; 
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
        <button type='submit' name='Test' value='Test' />Test di configurazione Mail</button>
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