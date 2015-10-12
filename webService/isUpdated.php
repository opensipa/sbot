<?php
$outVersion = null;
//determino la versione attuale:
$fh = fopen('webService/version.txt', 'r');
$localVersion = fread($fh, 1024);  
fclose($fh);

// crea una risorsa cURL
$ch = curl_init();

// imposto l'URL da interrogare
curl_setopt($ch, CURLOPT_URL, 'http://5.249.159.105/repo/getVersion.php');

// escludo l'header dall'output
curl_setopt($ch, CURLOPT_HEADER, 0);

// Imposto un massimo di 5 secondi prima di interrompere l'operazione
curl_setopt($ch, CURLOPT_TIMEOUT, 5);

// Sopprimo l'output sul browser
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// recupero l'URL e lo assegno in variabile
$currentVersion = curl_exec($ch);

// chiudo la risorsa cURL
curl_close($ch);
// Se hai una vecchia versione
if ($currentVersion > $localVersion) {
	// Comunico che esiste una nuova versione
	$currentVersion = str_replace('_', '.', $currentVersion);
	$outVersion .= '
	<div>
            <strong>Una nuova versione di {S}Bot presente: ' . $currentVersion . '</strong><br />
            <strong>Tu invece hai installato la versione: '.$localVersion.'</strong><br />
        </div>' . PHP_EOL;

	// Recupero le note di rilascio
	
	// crea una risorsa cURL
	$ch = curl_init();

	// imposto l'URL da interrogare
	curl_setopt($ch, CURLOPT_URL, 'http://5.249.159.105/repo/note.htm');

	// escludo l'header dall'output
	curl_setopt($ch, CURLOPT_HEADER, 0);

	// Imposto un massimo di 5 secondi prima di interrompere l'operazione
	curl_setopt($ch, CURLOPT_TIMEOUT, 5);

	// Sopprimo l'output sul browser
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	// recupero l'URL e lo assegno in variabile
	$noteRilascio = curl_exec($ch);
	// Comunico le note di rilascio
	$outVersion.= $noteRilascio;
} else {
	// Comunico che va tutto bene così
	$outVersion .= '<p><strong>Questa versione di {S}Bot &egrave; aggiornata. Non serve fare nulla.</strong> Stai usando la versione: '.$localVersion.'<br />' . PHP_EOL;
}
?>