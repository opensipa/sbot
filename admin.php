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
            // inizializzo cURL
            $output = controlTelgramState();
            $risultato = $output[0];
            $controllo = $output[1];
            if( $risultato == $controllo ){ ?>
            Il sistema sta funzionando correttamente. 
            <?php } else { ?>
            Il sistema non sta funzionando correttamente, <a href="coda.php">controlla la coda.</a><br>
            <?php } ?>
            </h1>			
    </div>
    <div id="content" class="clearfix">
        <div class="content-row">
            <h1>Per inviare un messaggio usa questo form:</h1>
            <form method="post" action="send.php" method="POST">
                <textarea name="testo" rows="9" cols="60"placeholder="Inserisci qui la risposta..."></textarea><br>
                <input type="submit" id="invio" name="invia" value="Invia messaggio">
            </form>
            <!-- Disable button send after one click
            <script type="text/javascript">
                $('#invio').click(function(){
                $(this).prop("disabled",true);
                });
            </script>
            -->
        </div>
    </div>
    <div id="content" class="clearfix">
        <div class="content-row">
            <h1>Invia una immagine (attenzione che ci potrebbe impiegare molto - attendi esito finale -):</h1>
            <br>
            <form action="upload.php" method="post" enctype="multipart/form-data">
                <!-- Campo file di nome "image" -->
                <input name="image" type="file" size="40" />
                <br><br>
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
</div>   
<!-- Footer page -->
<?php include ('theme/footer.php');?>