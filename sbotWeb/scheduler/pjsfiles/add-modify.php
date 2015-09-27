<?php
$app_name = "phpJobScheduler";
$phpJobScheduler_version = "3.9";
// -------------------------------
include("functions.php");

if ($minutes>0) $time_interval=$minutes * 60;
elseif ($hours>0) $time_interval=$hours * 3600;
elseif ($days>0) $time_interval=$days * 86400;
else $time_interval=$weeks * 604800;

if ($id>0)
{
 $time_last_fired= ($time_last_fired)? $time_last_fired:time();
 $fire_time = $time_last_fired + $time_interval;
 $query="UPDATE ".PJS_TABLE."
         SET
          name='$name',
          scriptpath='$scriptpath',
          time_interval='$time_interval',
          fire_time='$fire_time',
          run_only_once='$run_only_once',
          paused='$paused' 
         WHERE id='$id'";
}
else
{
 $fire_time = time() + $time_interval;
 $query="INSERT INTO ".PJS_TABLE."
          (scriptpath, name, time_interval, fire_time, time_last_fired,run_only_once, paused)
         VALUES
          ('$scriptpath','$name','$time_interval','$fire_time','0','$run_only_once','$paused')";
}
$dbc = dbc::instance();
$result = $dbc->prepare($query);
$result = $dbc->execute($result);
?>
<script language="JavaScript"><!--
function moveit()
{
 url2open="index.php";
 document.location=url2open;
}
moveit();
// --></script>