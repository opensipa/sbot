<?php
$app_name = "phpJobScheduler";
$phpJobScheduler_version = "3.9";
// -------------------------------
include("functions.php");
$id=clean_input($_POST['id']);

$dbc = dbc::instance();
$result = $dbc->prepare("select * from ".PJS_TABLE." where id='$id' ");
$rows = $dbc->executeGetRows($result);
if(count($rows)<1) js_msg("There has been an error!");
$row=$rows[0];
// check if its hours
$interval_array = time_unit($row["time_interval"]);
if (preg_match("/minute/",$interval_array[1])>0) $minutes=$interval_array[0];
else $minutes=-1;
if (preg_match("/hour/",$interval_array[1])>0) $hours=$interval_array[0];
else $hours=-1;
if (preg_match("/day/",$interval_array[1])>0) $days=$interval_array[0];
else $days=-1;
if (preg_match("/week/",$interval_array[1])>0) $weeks=$interval_array[0];
else $weeks=-1;
include("header.html");
include("add-modify.html");
include("footer.html");
?>
<script language="JavaScript"><!--
with (document.I_F)
{
 id.value="<?php echo $row["id"]; ?>";
 name.value="<?php echo $row["name"]; ?>";
 scriptpath.value="<?php echo $row["scriptpath"]; ?>";
 minutes.value=<?php echo $minutes; ?>;
 hours.value=<?php echo $hours; ?>;
 days.value=<?php echo $days; ?>;
 weeks.value=<?php echo $weeks; ?>;
 time_last_fired.value=<?php echo $row['time_last_fired']; ?>;
 button.value="Modify Job";
 original_minutes=<?php echo $minutes; ?>;
 original_hours=<?php echo $hours; ?>;
 original_days=<?php echo $days; ?>;
 original_weeks=<?php echo $weeks; ?>;
 run_only_once.value=<?php echo $row['run_only_once']; ?>;
 paused.value=<?php echo $row['paused']; ?>
}
// --></script>