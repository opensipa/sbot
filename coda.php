<?php
include('theme/verification.php');
include('theme/header.php');
include('functions/function.php');
include('functions/functionDb.php');
include('config.php');
include('init.php');
?>

<div id="content" class="clearfix">
	<div id="top_menu">
		<?php topMenu($menu);?>
	</div>
	<div class="content-row">

            <h2>Ecco il responso da parte del server telegram:
            <?php            
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
            </h2> 
	</div>			
</div>
<!-- Footer page -->
<?php include 'theme/footer.php';
