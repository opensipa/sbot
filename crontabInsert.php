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
    <p><h3>Al momento attuale &egrave; possibile inserire l'invio di una informazione <strong>senza alcuna ripetizione</strong>.</h3></p>
</div>
<?php
//Insert new button
if (isset($_POST["New"])) { ?>
        <div id="content" class="clearfix">
            <form id='formData' name="formData" action='crontabInsert.php' method='post' accept-charset='UTF-8'>
            <fieldset>
            <legend>Per inserire nuovi Scheduler, compila questi campi:</legend>
                <div class="form-group">
                <input type='hidden' name='alreadysent' id='alreadysent' value='1'/>
                <label for='testo' >Testo*: </label>
                <textarea class='form-control' type='testo' name='testo' id='testo' maxlength='2048' required='1'></textarea>
                <label for="firma" >Firma da inserire nel messaggio*: </label>
                <input class="form-control" type="signature" name="signature" id="signature" required="1" />
                <label for="note" >Note (non inviate): </label>
                <input class="form-control" type="note" name="note" id="note" maxlength="500">
                <label for="date" >Inserisci la data di invio*: </label>
                <input type="Text" name="data1" value="" required="1">
                <a href="javascript:show_calendar('document.formData.data1', document.formData.data1.value);"><img src="theme/img/cal.gif" width="16" height="16" border="0" alt="Seleziona la data"></a>
                <br>
                <input type="submit" name="Inserisci" value="Inserisci" />
                </div>
            </fieldset>
            </form>
        </div>
<?php }

// Insert the variable
if (isset($_POST["Inserisci"])) {
    $AlreadySent = filter_input(INPUT_POST, 'alreadysent', FILTER_SANITIZE_STRING);
    $Signature = filter_input(INPUT_POST, 'signature', FILTER_SANITIZE_STRING);
    $Note = filter_input(INPUT_POST, 'note', FILTER_SANITIZE_STRING);
    $Testo = filter_input(INPUT_POST, 'testo', FILTER_DEFAULT);
    $Date = filter_input(INPUT_POST, 'data1', FILTER_SANITIZE_STRING);
    $submit = filter_input(INPUT_POST, 'Inserisci', FILTER_SANITIZE_STRING);
if (!empty($submit)) {
    $errore = dbSchedulerInsert($Date, $Signature, $Testo, $Note);
    if ($errore == 0){
        echo'<div id="content" class="clearfix">
            <h2>Hai inserito correttamente il nuvo scheduler.</h2>
        </div>';
    } else {
         echo'<div id="content" class="clearfix">
            <h2>Non hai inserito in modo corretto lo scheduler, riprova, grazie!</h2>
        </div>';
    }
    } else  {	
    echo'<div id="content" class="clearfix">
            <h2>Errore generico, riprova!</h2>
        </div>'; 
  }
}

// Form for view the table for update setting variable
if (isset($_POST["Valori"])) {
    $ID = filter_input(INPUT_POST, 'ID', FILTER_SANITIZE_STRING);
    $extractScheduler = dbSchedulerExtraction('ID = '.$ID);
    //Variable extract: ID, Date, Signature, Text, Note
    foreach ($extractScheduler as $extract) {
    echo '
        <div id="content" class="clearfix">
            <form id="changesetting" name="formData" action="crontabInsert.php" method="post" accept-charset="UTF-8">
                <fieldset>
                <legend>Aggiorna i parametri dello scheduler selezionato</legend>
                <div class="form-group">
                <div class="form-group">
                <input type="hidden" name="alreadysent" id="alreadysent" value="1"/>
                <label for="testo" >Testo*: </label>
                <textarea class="form-control" type="testo" name="testo" id="testo" maxlength="2048" required="1">'.$extract['Text'].'</textarea>
                <label for="firma" >Firma da inserire nel messaggio*: </label>
                <input class="form-control" type="signature" name="signature" id="signature" value="'.$extract['Signature'].'" required="1" />
                <label for="note" >Note (non inviate): </label>
                <input class="form-control" type="note" name="note" id="note" maxlength="500" value="'.$extract['Note'].'">
                <label for="date" >Inserisci la data di invio*: </label>
                <input type="Text" name="data1" value="'.$extract['DataScheduler'].'" required="1">
                <a href="javascript:show_calendar("document.formData.data1", document.formData.data1.value);"><img src="theme/img/cal.gif" width="16" height="16" border="0" alt="Seleziona la data"></a>
                <br>
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
    $AlreadySent = filter_input(INPUT_POST, 'alreadysent', FILTER_SANITIZE_STRING);
    $Signature = filter_input(INPUT_POST, 'signature', FILTER_SANITIZE_STRING);
    $Note = filter_input(INPUT_POST, 'note', FILTER_SANITIZE_STRING);
    $Testo = filter_input(INPUT_POST, 'testo', FILTER_DEFAULT);
    $Date = filter_input(INPUT_POST, 'data1', FILTER_SANITIZE_STRING);
    $ID = filter_input(INPUT_POST, 'ID', FILTER_SANITIZE_NUMBER_INT);
    $submit = filter_input(INPUT_POST, 'Cambia', FILTER_SANITIZE_STRING);

if (!empty($submit)) {
    $erroreUpdate = dbSchedulerUpdate($ID, $Date, $Signature, $Testo, $Note);
    if ($erroreUpdate == 0){
        echo'<div id="content" class="clearfix">
            <h2>Hai aggiornato correttamente lo scheduler.</h2>
            </div>';
    } else {
        echo'<div id="content" class="clearfix">
            <h2>Non hai inserito i dati in modo corretto.</h2>
            </div>';
        }
} else  {	
    echo'<div id="content" class="clearfix">
            <h2>Errore generico, riprova!</h2>
        </div>'; 
  }
}

?>
<!-- Table for view the scheduler of bot -->
<div id="content" class="clearfix">
        <form method="post" action="crontabInsert.php">   
        <div align="center">  
        <button type='submit' name='New' value='New' />Inserisci un evento</button>
        <button type='submit' name='Valori' value='Valori' />Modifica un evento</button>
        </div>
        <br>
        <table border="1" id="order"> 
            <thead>
                <tr>
                <th><span>Invio</span></th>
                <th><span>Testo</span></th>
                <th><span>Note</span></th>
                <th><span>Firma</span></th>
                <th><span>Stato</span></th>
                <th><span>Sel.</span></th>
                </tr>
            </thead>             
            <tbody>
            <?php $extractParam = dbSchedulerExtraction("ID is not null");
            foreach ($extractParam as $extract) { 
                echo'<tr class="align">
                    <td>'.$extract['DataScheduler'].'</td>
                    <td>'.$extract['Text'].'</td>
                    <td>'.$extract['Note'].'</td>
                    <td>'.$extract['Signature'].'</td>
                    <td>'.$extract['AlreadySent'].'</td>
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