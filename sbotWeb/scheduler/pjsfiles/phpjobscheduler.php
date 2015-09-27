<?php
$app_name = "phpJobScheduler";
$phpJobScheduler_version = "3.9";
// -------------------------------
$time_and_window =  time() + TIME_WINDOW;
$scripts_to_run = array();

$dbc = dbc::instance();
$result = $dbc->prepare("select * from ".PJS_TABLE." WHERE fire_time <= $time_and_window AND paused='0' ");
$rows = $dbc->executeGetRows($result);
$i=0;
if(count($rows))  // check has got some
{
  foreach ($rows AS $row)
  {
    foreach ($row AS $key => $value) $$key = $value;    
    $fire_time_new = $fire_time + $time_interval;
    $scripts_to_run[$i]["script"]="$scriptpath";
    $scripts_to_run[$i]["id"]=$id;
    if (DEBUG) echo "Found script to run: $scriptpath - id=$id (debug ref. 3.9a)<br>";
    $result = $dbc->prepare("UPDATE ".PJS_TABLE."
                             SET
                              fire_time='$fire_time_new',
                              time_last_fired='$fire_time'
                             WHERE id='$id'");
    $result = $dbc->execute($result);  
    if($run_only_once) 
    {
     $result = $dbc->prepare("DELETE from ".PJS_TABLE." WHERE id='$id' ");
     $result = $dbc->execute($result);  
    }
    $i++;
  }
 }
// run the scheduled scripts
$log_date="";
$log_output="";
for ($i = 0; $i < count($scripts_to_run); $i++) fire_script($scripts_to_run[$i]['script'],$scripts_to_run[$i]['id']);