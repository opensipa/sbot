<?php
include('theme/verification.php');
include('theme/header.php');
include('functions/function.php');
include('functions/functionDb.php');
include('config.php');
include('functions/functionInit.php');
?>

<div id="content" class="clearfix">
	<div class="content-row">

            <h2>
            <?php header('Refresh: 20');
            // inizializzo cURL
            $output = controlTelgramState();
            $risultato = $output[0];
            $controllo = $output[1];
            if( $risultato == $controllo ){
                echo '<br>Non ci sono messaggi in coda. Il sistema funziona correttamente.</h2>'; 
            } else {
                echo'<br>Il sistema non st&agrave funzionando correttamente (controlla il demone).</h2><br>'
                .   'Hai questi messaggi in coda: <br><br>';
                echo $risultato;  
            }
            ?>			
            
	</div>			
</div>
<!-- Footer page -->
<?php include ('theme/footer.php');?>