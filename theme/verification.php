<?php
session_start();
if (empty($_SESSION['username'])) {
	echo'<div id="content" class="clearfix">';
		echo'<div class="content-row">';
			echo '<h2><p><a href="index.php">Fai il Login.</a></p></h2>';
                echo '</div>';			
        echo '</div>';
	die();
}
?>