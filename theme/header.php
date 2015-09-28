<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="copyright" content="Copyright 2015 © Opensipa">
        <meta name="language" content="italian">
        <meta name="email" content="opensipa[at]gmail[dot]com @gmail">
        <link rel="shortcut icon" href="img/favicon.ico" >
        <title>{S}Bot - Telegram Bot by OpenSipa</title>
        <link href="css/stile.css" rel="stylesheet" type="text/css">
    </head>
<body>
<div id="container">	
	<div id="header">
		<h1><span>{S}Bot </span>by Opensipa.it</h1>
		<ul id="menunav">
        <?php
        if (!empty($_SESSION['username'])) {
        echo '<li class="active"><a href="admin.php">Pagina di gestione</a></li>'; 
        echo '<li><a href="help.php">Help on-line</a></li>';
        echo '<li><a href="logout.php">Logout</a></li>';
        } else {
        echo '<li class="active"><a href="index.php">Home page {S}Bot</a></li>';
        }
        ?>
			<img src="img/logo.png" alt="logo Sbot">
		</ul>
	</div> 