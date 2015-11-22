<?php
$f = fopen('test.txt', 'a');
fwrite($f, 'test executed at ' . strftime("%Y-%m-%d %H:%M:%S") . "\r\n");
fclose($f);
exit;
?>
