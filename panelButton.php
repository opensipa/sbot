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
    $extractButton = dbButtonExtraction('ID = '.$ID);
//Variable extract: Code, Param, SoftDesc, Active, Log, ID
    foreach ($extractButton as $extract) {
    echo '
        <div id="content" class="clearfix">
            <h2>Modifica i parametri:</h2>
            <form id="changesetting" action="panelButton.php" method="post" accept-charset="UTF-8">
                <fieldset >
                <legend>Aggiorna i Pulsanti</legend>
                <div class="form-group">
                <label for="software" >Software*: </label>
                <input class="form-control" type="software" name="software" id="software" value="Button" disabled="disabled" />
                <label for="number">Ordine*: </label>
                <input class="form-control" type="number" name="number" id="number" value="'.$extract['Number'].'" maxlength="2" />
                <label for="param" >Valore*: </label>
                <textarea class="form-control"type="param" name="param" id="param" maxlength="400">'.$extract['Param'].'</textarea>
                <label for="titolo" >Titolo del bottone: </label>
                <input class="form-control" type="titolo" name="titolo" id="titolo" value="'.$extract['Titolo'].'" maxlength="10">
                <label for="active" >Stato*: </label>
                <select class="form-control" name="active">
                <option value="1">Attivo</option>
                <option value="0">Disattivo</option>
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
    $software = "Button";
    $number = filter_input(INPUT_POST, 'number', FILTER_SANITIZE_NUMBER_INT);
    $param = filter_input(INPUT_POST, 'param', FILTER_SANITIZE_STRING);
    $titolo = filter_input(INPUT_POST, 'titolo', FILTER_SANITIZE_STRING);
    $ID = filter_input(INPUT_POST, 'ID', FILTER_SANITIZE_NUMBER_INT);
    $state = filter_input(INPUT_POST, 'active', FILTER_SANITIZE_STRING);
    $user = $_SESSION['username'];
    $submit = filter_input(INPUT_POST, 'Cambia', FILTER_SANITIZE_STRING);

if (!empty($submit)) {
    dbButtonUpdate($ID, $software, $param, $number, $state, $user, $titolo); 
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
<!-- Table for view the variable of bot -->
<div id="content" class="clearfix">
    <div class="content-row">
        <form method="post" action="panelButton.php">
        <div align="center">  
        <button type='submit' name='Valori' value='Valori' />Modifica i bottoni</button>
        </div>
        <br>
        <table border="1" id="order"> 
            <thead>
                <tr>
                <th><span>Tipo</span></th>
                <th><span>N.</span></th>
                <th><span>Testo</span></th>
                <th><span>Titolo</span></th>
                <th><span>Att/Dis</span></th>
                <th><span>Log</span></th>
                <th><span>Modifica</span></th>
                </tr>
            </thead>             
            <tbody>
            <?php $extractParam = dbButtonExtraction("SoftDesc is not null");
            foreach ($extractParam as $extract) { 
                echo'<tr class="align">
                    <td>'.$extract['SoftDesc'].'</td>
                    <td>'.$extract['Number'].'</td>
                    <td>'.$extract['Param'].'</td>
                    <td>'.$extract['Titolo'].'</td>
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
</div>
<!-- Footer page -->
<?php include ('theme/footer.php');?>