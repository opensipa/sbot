<?php
// Spazio per le customizzazioni, ad esempio per impostare user e password del db
include ('config.local.php'); 

if (file_exists('config.sample.php')) {
    $msg='Found file config.sample. Please rename config.sample.php to config.local.php. Insert in config.local.php the user and password of DB.';
    writeLog($msg);
    die ($msg);
}