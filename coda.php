<?php include 'theme/verification.php'; ?>
<?php include 'theme/header.php'; ?>

	<div id="content" class="clearfix">
		<div class="content-row">	
<?php
include("config.php");
include("init.php");
include("functions/function.php");
include("functions/functionDb.php");

/* torna in admin */
echo '<h2><p><a href="admin.php">Torna alla pagina di Gestione</a></p></h2> ';

// inizializzo cURL
$ch = curl_init();

// imposto la URL della risorsa remota da scaricare
curl_setopt($ch, CURLOPT_URL, API_URL.'getUpdates');

// imposto che non vengano scaricati gli header
curl_setopt($ch, CURLOPT_HEADER, 0);

// un paio di timeout per evitare tempi troppo lunghi sul server
curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
curl_setopt($handle, CURLOPT_TIMEOUT, 60); 

// eseguo la chiamata e restituisco la coda
curl_exec($ch);

// chiudo e riordino
curl_close($handle);

?>				
			</div>			
	</div>
<?php include 'theme/footer.php';
