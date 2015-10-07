<?php
include('theme/verification.php');
include('theme/header.php');
?>
<div>
    <h1>Controllo aggiornamenti:</h1>
    <?php
        include ('webService/isUpdated.php');
	echo $outVersion;
    ?>
</div>
<!-- Footer page -->
<?php include ('theme/footer.php');?>