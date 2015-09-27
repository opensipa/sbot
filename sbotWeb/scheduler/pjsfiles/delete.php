<?php
$app_name = "phpJobScheduler";
$phpJobScheduler_version = "3.9";
// -------------------------------
include_once("functions.php");
$id=clean_input($_POST['id']);
$table_name=clean_input($_POST['table_name']);
$query="delete from $table_name where id=$id";
$dbc = dbc::instance();
$result = $dbc->prepare($query);
$result = $dbc->execute($result);
echo "Deleted";
?>