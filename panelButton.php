<?php
include ('theme/verification.php');
include ('theme/header.php');
include ('functions/function.php');
include ('functions/functionDb.php');
include ('config.php');
include ('functions/functionInit.php');
include ('functions/passwordHash.php');
?>
<div id="content" class="clearfix" align="center">
    <p>
    <h3>
        Al momento attuale &egrave; possibile usare fino ad <strong>un massimo di 8 pulsanti (4X4)</strong>.
        Puoi disabilitare i pulsanti per ridurne il numero in ogni singola riga.<br>
        Il pulsante con <strong>numero ZERO</strong> deve sempre esistere ed &egrave; il messaggio di benvenuto!
    </h3>
    <h4>
        Puoi inserire invece comandi del tipo /news e assegnarli un numero superiore a 20.
    </h4>
    I pulsanti possono essere di tipo <strong>"normale" o di tipo "funzione"</strong> nell'ultimo caso devi crearti una funzione in<br>
    "functionPlugin.php" ed inserire nel campo testo il nome della funzione e i suoi parametri con il seguente formato:<br>
    nome_funzione|nome_parametro1|nome_parametro2 , per passare i parametri separarli dal "|".
    </p>
</div>
<?php
//Insert new button
if (isset($_POST["New"])) { ?>
        <div id="content" class="clearfix">
        <form id='setting' action='panelButton.php' method='post' accept-charset='UTF-8'>
            <fieldset>
            <legend>Per inserire nuovi pulsanti, compila questi campi:</legend>
                <div class="form-group">
                <input type='hidden' name='state' id='state' value='1'/>
                <label for="software" >Descrizione (Button per i bottoni, o altro)*: </label>
                <input class="form-control" type="software" name="software" id="software" required="1"/>
                <label for="number">Ordine*: </label>
                <input class="form-control" type="number" name="number" id="number" maxlength="2" required="1"/>
                <label for="titolo" >Nome del bottone*: </label>
                <input class="form-control" type="titolo" name="titolo" id="titolo" maxlength="50" required="1">
                <label for="param" >Testo*: </label>
                <textarea class="form-control" type="param" name="param" id="param" maxlength="1000"required="1"></textarea>
                <label for="param" >Tipo operazione del pulsante*: </label>
                <select class="form-control" name="type" required="1">
                <option value="Normal">Normale</option>
                <option value="Function">Funzione</option>
                </select>
                <br>
                <input type="submit" name="Inserisci" value="Inserisci" />
                </div>
            </fieldset>
        </form>
</div>
<?php }

// Form for view the table for update setting variable
if (isset($_POST["Valori"])) {
    $ID = filter_input(INPUT_POST, 'ID', FILTER_SANITIZE_STRING);
    $extractButton = dbButtonExtraction('ID = '.$ID);
//Variable extract: Code, Param, SoftDesc, Active, Log, ID
    foreach ($extractButton as $extract) {
    echo '
        <div id="content" class="clearfix">
            <form id="changesetting" action="panelButton.php" method="post" accept-charset="UTF-8">
                <fieldset>
                <legend>Aggiorna i parametri dei pulsanti usati</legend>
                <div class="form-group">
                <label for="software" >Software*: </label>
                <input class="form-control" type="software" name="software" id="software" value="'.$extract['SoftDesc'].'" />
                <label for="number">Ordine*: </label>
                <input class="form-control" type="number" name="number" id="number" value="'.$extract['Number'].'" />
                <label for="titolo" >Nome del bottone: </label>
                <input class="form-control" type="titolo" name="titolo" id="titolo" value="'.$extract['Titolo'].'" />
                <label for="param" >Testo*: </label>
                <textarea class="form-control" type="param" name="param" id="param" maxlength="400">'.$extract['Param'].'</textarea>
                <label for="param" >Tipo operazione del pulsante*: </label>
                <select class="form-control" name="type">';
                if ($extract['Type'] == "Normal"){
                    echo '<option value="Normal">Normale</option>
                          <option value="Function">Funzione</option>';
                }else{   
                    echo '<option value="Function">Funzione</option>
                          <option value="Normal">Normale</option>';
                }
                echo '
                </select>
                <label for="active" >Stato*: </label>
                <select class="form-control" name="active">';
                if ($extract['Type'] == "Normal"){
                    echo '<option value="1">Attivo</option>
                          <option value="0">Disattivo</option>';
                }else{   
                    echo '<option value="0">Disattivo</option>
                          <option value="1">Attivo</option>';
                }
                echo '
                </select>
                <input type="hidden" name="ID" id="ID" value="'.$extract['ID'].'" />
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
    $number = filter_input(INPUT_POST, 'number', FILTER_SANITIZE_NUMBER_INT);
    $param = filter_input(INPUT_POST, 'param', FILTER_SANITIZE_STRING);
    $tipo = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING);
    $titolo = filter_input(INPUT_POST, 'titolo', FILTER_SANITIZE_STRING);
    $ID = filter_input(INPUT_POST, 'ID', FILTER_SANITIZE_NUMBER_INT);
    $state = filter_input(INPUT_POST, 'active', FILTER_SANITIZE_NUMBER_INT);
    $user = $_SESSION['username'];
    $submit = filter_input(INPUT_POST, 'Cambia', FILTER_SANITIZE_STRING);
if (!empty($submit)) {
    if ($number>99){
        echo'<div id="content" class="clearfix">
                <h2>NON puoi assegnare un numero di pulsante maggiore di 99.</h2>
            </div>';   
    } else {
    dbButtonUpdate($ID, $software, $param, $tipo, $number, $state, $user, $titolo);
        echo'<div id="content" class="clearfix">
            <h2>Hai aggiornato correttamente i valori.</h2>
        </div>';   
    }
} else  {	
    echo'<div id="content" class="clearfix">
            <h2>Hai inserito in modo sbagliato i parametri dei pulsanti, riprova!</h2>
        </div>'; 
  }
}

// Insert the variable
if (isset($_POST["Inserisci"])) {
    $software = filter_input(INPUT_POST, 'software', FILTER_SANITIZE_STRING);
    $number = filter_input(INPUT_POST, 'number', FILTER_SANITIZE_NUMBER_INT);
    $param = filter_input(INPUT_POST, 'param', FILTER_SANITIZE_STRING);
    $tipo = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING);
    $titolo = filter_input(INPUT_POST, 'titolo', FILTER_SANITIZE_STRING);
    $active = filter_input(INPUT_POST, 'state', FILTER_SANITIZE_NUMBER_INT);
    $user = $_SESSION['username'];
    $submit = filter_input(INPUT_POST, 'Inserisci', FILTER_SANITIZE_STRING);
if (!empty($submit)) {
    dbButtonInsert($software, $param, $tipo, $number, $active, $user, $titolo);
        echo'<div id="content" class="clearfix">
            <h2>Hai inserito correttamente il nuovo parametro.</h2>
        </div>';       
    } else  {	
    echo'<div id="content" class="clearfix">
            <h2>Hai inserito in modo sbagliato i parametri dei pulsanti, riprova!</h2>
        </div>'; 
  }
}

?>
<!-- Table for view the variable of bot -->
<div id="content" class="clearfix">
    <form method="post" action="panelButton.php">   
    <div align="center">  
    <button type='submit' name='New' value='New' />Inserisci un pulsante</button>
    <button type='submit' name='Valori' value='Valori' />Modifica il pulsante</button>
    </div><br>
    <table border="1" id="order"> 
    <thead>
        <tr>
            <th><span>Desc.</span></th>
            <th><span>N.</span></th>
            <th><span>Nome</span></th>
            <th><span>Testo</span></th>
            <th><span>Tipo</span></th>
            <th><span>Att/Dis</span></th>
            <th><span>Log</span></th>
            <th><span>Sel.</span></th>
        </tr>
    </thead>             
    <tbody>
        <?php $extractParam = dbButtonExtraction("SoftDesc is not null");
        foreach ($extractParam as $extract) { 
            echo'<tr class="align">
                <td>'.$extract['SoftDesc'].'</td>
                <td>'.$extract['Number'].'</td>
                <td>'.$extract['Titolo'].'</td>
                <td>'.$extract['Param'].'</td>
                <td>'.$extract['Type'].'</td>
                <td>'.$extract['Active'].'</td>
                <td>'.$extract['Log'].'</td> 
                <td><input type="radio" name="ID" value="'.$extract['ID'].'" /></td>
                </tr>';
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
<!-- Footer page -->
<?php include ('theme/footer.php');?>