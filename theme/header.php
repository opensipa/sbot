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
    <h1><span><img src="img/logo.png" alt="logo Sbot"> </span>by Opensipa.it</h1>
	<div id="header">    
            <ul id="menu">
            <?php
            if (!empty($_SESSION['username'])) { 
            echo '<li><a href="#">Pagina di gestione</a>';
            echo '<ul>
                <li><a href="admin.php">Invia messaggi</a></li>
                <li><a href="user.php">Utenti attivi</a></li>
                <li><a href="coda.php">Coda Telegram</a></li>
                <li><a href="message.php">Messaggi utenti</a></li>
                <li><a href="fullSend.php">Messaggi inviati</a></li>
                </ul></li>';
            echo '<li><a href="#">Panello Controllo</a>';
            echo '<ul>    
                <li><a href="changePwd.php">Cambio password</a></li>
                <li><a href="addAdmin.php">Aggiungi utenti</a></li>
                </ul></li>';
            echo'<li><a href="help.php">Help on-line</a></li>';
            echo'<li><a href="logout.php">Logout</a></li>';
            } else {
            echo'<li><a href="index.php">Home page {S}Bot</a></li>';
            }
            ?>
            </ul>
	</div> 