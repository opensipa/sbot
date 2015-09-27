<?php
$app_name = "phpJobScheduler";
$phpJobScheduler_version = "3.9";
// -------------------------------
include_once("pjsfiles/functions.php");
include(LOCATION."phpjobscheduler.php");
// return image - used for html page img tag
if ( isset($_GET['return_image']) )
{
 header("Content-Type: image/gif");
 header("Content-Length: 49");
 echo pack('H*', '47494638396101000100910000000000ffffffffffff00000021f90405140002002c00000000010001000002025401003b');
}
?>