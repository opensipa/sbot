<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="copyright" content="Copyright 2015 © Opensipa">
        <meta name="language" content="italian">
        <meta name="email" content="opensipa[at]gmail[dot]com @gmail">
        <link rel="shortcut icon" href="img/favicon.ico" >
        <title>{S}Bot - Telegram Bot by OpenSipa</title>
        <script src="http://code.jquery.com/jquery-latest.js"></script>
        <script type="text/javascript" src="theme/js/tablesorter/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="theme/js/tablesorter/jquery.tablesorter.min.js"></script>
        <link href="theme/css/stile.css" rel="stylesheet" type="text/css">
    </head>
<body>
<div id="container">
    <h1><span><img src="img/logo.png" alt="logo Sbot"> </span>by Opensipa.it</h1>
	<div id="header">    
            <ul id="menu">
            <?php
            if (!empty($_SESSION['username'])) { 
            echo '<li><a href="#">Pagina di gestione</a>'
               . '<ul>'
               . '<li><a href="admin.php">Invia messaggi</a></li>'
               . '<li><a href="user.php">Utenti attivi</a></li>'
               . '<li><a href="coda.php">Coda Telegram</a></li>'
               . '<li><a href="message.php">Messaggi utenti</a></li>'
               . '<li><a href="fullSend.php">Messaggi inviati</a></li>'
               . '</ul></li>';
            echo '<li><a href="#">Panello Controllo</a>'
                . '<ul>'    
                . '<li><a href="changePwd.php">Cambio password</a></li>'
                . '<li><a href="addAdmin.php">Gestione utenza</a></li>'
                . '</ul></li>';
            echo '<li><a href="#">Aggiornamenti</a>'
                . '<ul>'    
                . '<li><a href="update.php">Controlla</a></li>'
                . '</ul></li>';
            echo'<li><a href="help.php">Help on-line</a></li>';
            echo'<li><a href="logout.php">Logout</a></li>';
            } else {
            echo'<li><a href="index.php">Home page {S}Bot</a></li>';
            }
            ?>
            </ul>
	</div>
        <?php
        if (!empty($_SESSION['username'])) { 
            $back = $_SERVER['HTTP_REFERER'];
            echo '<div id="content" class="clearfix" align="center">';
            echo '<form action="'.$back.'" method="GET">'
            . '<input type="submit" value="Torna indietro" name="Submit" id="Submit">'
            . '</form>';
            echo '</div>';
            }
        ?>