<?php
include('theme/verification.php');
include('theme/header.php');
include('functions/function.php');
include('functions/functionDb.php');
include('functions/functionInit.php');
include('config.php');
?>
<div id="content" class="clearfix">
    <h1>Stato del sistema:
    <?php 
    //Status Telegram Bot
    $output = controlTelgramState();
    $risultato = $output[$risultato];
    $controllo = $output[$controllo];
    $name = dbDemName(); 
    if( $risultato == $controllo ){ ?>
        Il sistema funziona correttamente.<br> 
    <?php
    if(isset($name)){echo'Stai usando: '.$name[Param];} 
    } else { 
    ?>
    Il sistema non sta funzionando correttamente, <a href="coda.php">controlla la coda.</a><br>
    <?php } ?>
    </h1>			
</div>
<div id="content" class="clearfix">
    <div class="content-row">
        <fieldset>
        <legend>Inserisci qui il messaggio che vuoi spedire a tutti:</legend>
        <div class="form-group">
        <form method="post" action="send.php" method="POST">
            <textarea id="msg" name="testo" rows="15" cols="80" placeholder="Inserisci qui il messaggio da inviare (non superare i 4096 caratteri)." onkeyup="ContaCaratteri()" required="1" maxlength="4096"></textarea><br>
            <br>
            <input type="submit" id="invio" name="invia" value="Invia messaggio">
            <span id="conteggio"></span>
        </form>
        <!-- Count digit character -->
        <script type="text/javascript">
        //Control keyup
        $('textarea#msg').keyup(function() {
            var limite = 4096; //Limit
            var quanti = $(this).val().length;
            //Count in real-time
            $('span#conteggio').html(quanti + ' di ' + limite + ' caratteri ammessi');
            //Go to limit
            if(quanti >= limite) {
            //Message alert
            $('span#conteggio').html('<strong>Non puoi inserire pi&ugrave; di ' + limite + ' caratteri!</strong>');
            //Tail character out
            var $contenuto = $(this).val().substr(0,limite);
            $('textarea#msg').val($contenuto);
            }
        });
        </script>
        <!-- Disable button send after one click
        <script type="text/javascript">
            $('#invio').click(function(){
            $(this).prop("disabled",true);
            });
        </script>
        -->
        </div>
        </fieldset>
    </div>
</div>
<div id="content" class="clearfix">
    <div class="content-row">
    <fieldset>
        <legend>Invia una immagine (attenzione che ci potrebbe impiegare molto - attendi esito finale -):</legend>
        <div class="form-group">
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <!-- Campo file di nome "image" -->
            <input class="form-control" name="image" type="file" size="40" />
            <br><br><br>
            <!-- Pulsante -->
            <input name="upload" id="send_image" type="submit" value="Procedi con l'invio" />
        </form> 
        <!-- Disable button send image after one click
        <script type="text/javascript">
            $('#send_image').click(function(){
            $(this).prop("disabled",true);
            });
        </script>
        -->
        </div>
    </fieldset>
    </div>
</div>   
<!-- Footer page -->
<?php include ('theme/footer.php');?>