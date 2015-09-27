<?php
$app_name = "phpJobScheduler";
$phpJobScheduler_version = "3.9";
// -------------------------------
include_once("functions.php");
update_db(); // check database is up-to-date, if not add required tables
include("header.html");
if (isset($_GET['add'])) include("add-modify.html");
else include("main.html");
include("footer.html");
?>