<?php
include('theme/verification.php');
include('theme/header.php');
include('functions/function.php');
include('functions/functionDb.php');
include('config.php');
include('init.php');
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
              echo '<br>Non ci sono messaggi in coda. Il sistema funziona correttamente.'; 
            } else {
                echo "<br>Il sistema non sta funzionando correttamente (controlla il demone). Hai questi messaggi in coda: <br>";
              echo $risultato;  
            }
            ?>			
            </h2> 
	</div>			
</div>
<!-- Footer page -->
<?php include ('theme/footer.php');?>