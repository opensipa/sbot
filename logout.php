<?php
/* 
 * 
 * 
 */
session_start();
unset($_SESSION['username']);

/* torna in home */
header('Location: index.php'); 

exit;
?>
