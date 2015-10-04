<?php
include ('theme/verification.php');
include ('theme/header.php');
include ('config.php');
include ('init.php');
include ('functions/function.php');
include ('functions/functionDb.php');
?>

    <div id="content" class="clearfix">
        <div class="content-row">
            <h2>
            <?php
            //Pagina di controllo upload

            do {
              if (is_uploaded_file($_FILES['image']['tmp_name'])) {
                // Controllo che il file non superi i 40 KB
                if ($_FILES['image']['size'] > DIMENSION) {
                  $msg = "<p>Il file non deve superare i ".DIMENSION." KB!!</p>";
                  break;
                }
                // Ottengo le informazioni sull'immagine
                list($width, $height, $type, $attr) = getimagesize($_FILES['image']['tmp_name']);
                // Controllo che le dimensioni (in pixel) non superino 1024 x 1024
                if (($width > PIXEL) || ($height > PIXEL)) {
                  $msg = "<p>Dimensioni in pixel che superano il limite di: ".PIXEL." X ".PIXEL."!!</p>";
                  break;
                }
                // Controllo che il file sia in uno dei formati GIF, JPG o PNG
                if (($type!=1) && ($type!=2) && ($type!=3)) {
                  $msg = "<p>Formato non corretto!!</p>";
                  break;
                }
                // Verifico che sul sul server non esista già un file con lo stesso nome
                // In alternativa potrei dare io un nome che sia funzione della data e dell'ora
                if (file_exists('upload_img/'.$_FILES['image']['name'])) {
                  $msg = "<p>File esistente sul server. Rinominarlo e riprovare.</p>";
                  break;
                }
                // Sposto il file nella cartella da me desiderata
                if (!move_uploaded_file($_FILES['image']['tmp_name'], 'upload_img/'.$_FILES['image']['name'])) {
                  $msg = "<p>Problema di permessi nella cartella di upload!!</p>";
                  break;
                }
              }
            } while (false);
            if ($msg == ""){
                echo 'Upload eseguito correttamente sul server.';
                $numeroInvi = dbCountActiveUsers();
                echo '<p>Ha inviato l\'immagine a <strong>'.$numeroInvi.'</strong> utenti del servizio.</p>';
                $photo= PHOTO_SEND.$_FILES['image']['name'];
                echo '<p>Ho inviato la seguente foto: <strong> '.$photo.'</strong></p>';
                $activeUsers = dbActiveUsers();
                    foreach ($activeUsers as $user) {
                        sendPicture($user, $photo);
                    }
            } else {
                echo 'Accorso il seguente errore: '.$msg;
                echo '<p><a href="admin.php">Torna al pannello di Gestione</a></p>';
            }
            ?>

            </h2>
	</div>			
    </div>
  
<!-- Footer della pagina html -->
<?php include 'theme/footer.php'; ?>