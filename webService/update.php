<?php
include('../theme/verification.php');
include('../theme/header.php');
include('../config.php');
include('../init.php');
include('../functions/function.php');
include('../functions/functionDb.php');
?>
<style>
    <?php include '../theme/css/stile.css'; ?>
</style>

<div>
    <h1>Controllo aggiornamenti:</h1>
    <?php
        include ('isUpdated.php');
	echo $outVersion;
    ?>
</div>
<!-- Footer page -->
<?php include ('../theme/footer.php');?>