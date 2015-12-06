<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="copyright" content="Copyright 2015 © Opensipa">
        <meta name="language" content="italian">
        <meta name="email" content="opensipa[at]gmail[dot]com @gmail">
        <link rel="shortcut icon" href="theme/img/favicon.ico" >
        <title>{S}Bot</title>
        <script src="http://code.jquery.com/jquery-latest.js"></script>
        <script type="text/javascript" src="theme/js/tablesorter/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="theme/js/tablesorter/jquery.tablesorter.min.js"></script>
        <link href="theme/css/stile.css" rel="stylesheet" type="text/css">
    </head>
<body>
<div id="container">
    <h1><span><img src="theme/img/logo.png" alt="logo Sbot"> </span>Thanks, contributors of Project</h1>
	<div id="header">    
            <ul id="menu">
            <?php
            if (!empty($_SESSION['username'])) { 
            echo'<li><a href="#">Pagina di gestione</a>'
                . '<ul>'
                . '<li><a href="admin.php">Invia messaggi</a></li>'
                . '<li><a href="message.php">Messaggi di utenti</a></li>'
                . '<li><a href="fullSend.php">Messaggi di massa</a></li>'
                . '<li><a href="user.php">Utenti attivi</a></li>'
                . '</ul></li>';
            echo'<li><a href="#">Pannello Controllo</a>'
                . '<ul>'
                . '<li><a href="coda.php">Coda Telegram</a></li>'
                . '<li><a href="panel.php">Gestione Parametri</a></li>'
                . '<li><a href="panelButton.php">Gestione Pulsanti</a></li>'
                . '<li><a href="changePwd.php">Cambio password</a></li>'
                . '<li><a href="addAdmin.php">Gestione Admin</a></li>'
                . '</ul></li>';
            echo'<li><a href="#">Aggiornamenti</a>'
                . '<ul>'    
                . '<li><a href="update.php">Controlla</a></li>'
                . '</ul></li>';
            echo'<li><a href="help.php">Help on-line</a></li>';
            echo'<li><a href="logout.php">Esci '.strtoupper ($_SESSION['username']).'</a></li>';
            } else {
            echo'<li><a href="index.php">Home page {S}Bot</a></li>';
            }
            ?>
            </ul>
	</div>
        <?php
        if (!empty($_SESSION['username'])) { 
            $back = $_SERVER['HTTP_REFERER'];
            echo'<center><div style="float:left; width:50%">';
            echo'<form action="'.$back.'" method="GET">'
            .   '<input type="submit" value="Torna indietro" name="Submit" id="Submit">'
            .   '</form></div>'
            .   '<div style="float:left; width:50%">'
            .   '<form action="'.$nome = basename($_SERVER['PHP_SELF']).'">'
            .   '<input type="submit" name="submit" value="Aggiorna"></form>';
            echo'</div>'
            .   '</center>'
            .   '<br><br>'
            .   '<hr align=”center” size=”1″ noshade>';
            }
        ?>