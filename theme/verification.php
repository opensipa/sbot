<?php
session_start();
if (empty($_SESSION['username'])) {
    include('theme/header.php');
	echo'<div id="content" class="clearfix">';
		echo'<div class="content-row">';
			echo '<h2><p><a href="index.php">Fai nuovamente il login.</a></p></h2>';
                echo '</div>';
        echo '</div>';
        include ('theme/footer.php');
	die();
}
?>