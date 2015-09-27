<?php
 $app_name = "phpJobScheduler";
 $phpJobScheduler_version = "3.9";
// ---------------------------------
include_once("config.inc.php");
include_once("constants.inc.php");

if (DBNAME=="")//not configured
{
 $folder = (file_exists("../readme.html"))? "../" : "";//called from readme.html - via different folders! 
 header("location: ".$folder."readme.html?noconfig=1");
 exit;
}
if (DEBUG)//warn set for testing 
{
   error_reporting(E_ALL);
   echo '<h2>Debug is on - to turn off see the: "readme.html" file, DEBUG section.  Error logs will not save fully until debug is off!</h2>';
}
else error_reporting(0);

if (!function_exists('clean_input')) // check to see if function is not already defined by another application
{
 function clean_input($string)
 {
  $patterns = array(// strip out:
                '@script*?>.*?</script@si', // javascript
                '@<[\/\!]*?[^<>]*?>@si', // HTML tags
                '@"@si', //double quotes
                "@'@si" //single quotes
                );
  $string = preg_replace($patterns,'',$string);
  $string = trim($string);
  $string = stripslashes($string);
  return htmlentities($string);
 }
}
foreach ($_REQUEST AS $key => $value) $$key = clean_input($value);//clean any and all user input

function update_db()
{
 $dbc = dbc::instance();
 $result = $dbc->prepare("SHOW TABLES LIKE '".LOGS_TABLE."'");
 $rows = $dbc->executeGetRows($result);
 if(count($rows)<1)                 
 {
   $query = "
    CREATE TABLE ".LOGS_TABLE." (
    id int(11) NOT NULL auto_increment,
    date_added int(11),
    script varchar(128) default NULL,
    output text default NULL,
    execution_time varchar(60) default NULL,
    PRIMARY KEY (id)
    )";
   $result = $dbc->prepare($query);
   $result = $dbc->execute($result);
 }
 $result = $dbc->prepare("SHOW TABLES LIKE '".PJS_TABLE."'");
 $rows = $dbc->executeGetRows($result);
 if(count($rows)<1)                 
 {
  $query="CREATE TABLE ".PJS_TABLE." (
  id int(11) NOT NULL auto_increment,
  scriptpath varchar(255) default NULL,
  name varchar(128) default NULL,
  time_interval int(11) default NULL,
  fire_time int(11) NOT NULL default '0',
  time_last_fired int(11) default NULL,
  run_only_once tinyint(1) NOT NULL DEFAULT '0',
  currently_running BOOLEAN NOT NULL DEFAULT '0', 
  PRIMARY KEY (id),
  KEY fire_time (fire_time))";
  $result = $dbc->prepare($query);
  $result = $dbc->execute($result);
 }
 //check logs table it uptodate
 $result = $dbc->prepare("SHOW COLUMNS FROM ".LOGS_TABLE." LIKE 'date_added' ");
 $rows = $dbc->executeGetRows($result);
 if(count($rows)<1)
 {    
  $result = $dbc->prepare("ALTER TABLE ".LOGS_TABLE." ADD date_added int AFTER id, CHANGE `id` `id` INT( 11 ) NOT NULL AUTO_INCREMENT;
                           ALTER TABLE ".LOGS_TABLE." CHANGE `id` `id` INT( 11 ) NOT NULL AUTO_INCREMENT ; ");
  $result = $dbc->execute($result);
 }  
 //check pjs_table is uptodate
 $result = $dbc->prepare("SHOW COLUMNS FROM ".PJS_TABLE." LIKE 'paused' ");
 $rows = $dbc->executeGetRows($result);
 if(count($rows)<1)
 {    
  $result = $dbc->prepare("ALTER TABLE ".PJS_TABLE." ADD `paused` BOOLEAN NOT NULL DEFAULT FALSE AFTER `currently_running`;");
  $result = $dbc->execute($result);
 }  
}

function time_unit($time_interval)
{
 global $app_name;
 $unit = array(0, 'type');
 //check if its minutes
 if ($time_interval <= (59 * 60))
 {
  $unit[0]=$time_interval/60;
  $unit[1]="<font color=\"#000000\">minute(s)</font>";
 }
 //check if its hours
 if ( ($time_interval > (59 * 60)) AND ($time_interval<= (23 * 3600)) )
 {
  $unit[0]=$time_interval/3600;
  $unit[1]="<font color=\"#ff0000\">hour(s)</font>";
 }
  // check if its days
 if ( ($time_interval > (23 * 3600)) AND ($time_interval <= (6 * 86400)) )
 {
  $unit[0]=$time_interval/86400;
  $unit[1]="<font color=\"#FF8000\">day(s)</font>";
 }
 if ($time_interval >(6 * 86400))
 {
  $unit[0]=$time_interval/604800;
  $unit[1]="<font color=\"#C00000\">week(s)</font>";
 }
 $thedomain = $_SERVER['HTTP_HOST'];
 return $unit;
}

function js_msg($msg)
{
 echo "<script><!--\n alert(\"$msg\");\n// --></script>";
}

function show_jobs()
{
 $dbc = dbc::instance();
 $result = $dbc->prepare("select * from ".PJS_TABLE);
 $rows = $dbc->executeGetRows($result);
 if(count($rows))  // check has got some
 {
  $table_rows="";
  $bg_colour="#FFFFFF";
  foreach ($rows AS $row)
  {
        foreach ($row AS $key => $value) $$key = $value;
        if ($time_last_fired==0)
        {
         $last_fire_hours = "<font color=\"#FF8000\">NOT yet fired</font>";
         $last_fire_date = "";
        }
        else
        {
         $last_fire_hours = strftime("%H:%M:%S ",$time_last_fired);
         $last_fire_date = strftime("on<br> %b %d, %Y",$time_last_fired);
        }
        $fire_hours = strftime("%H:%M:%S ",$fire_time);
        $fire_date = strftime("%b %d, %Y",$fire_time);
        if ($bg_colour=="#E9E9E9") $bg_colour="#FFFFFF"; else $bg_colour="#E9E9E9";
        $run_only_once_txt= $run_only_once ? "<i><font color=\"#ff0000\"> Will run just once</font></i>":"";
        $time_interval = time_unit($time_interval);
        $paused_txt= $paused?'<font color="#ff0000">PAUSED</font>':'';
        $table_rows.="
           <tr align=\"center\">
           <th align=\"left\" bgcolor=\"$bg_colour\">
           <div id=\"pjs$id\">
             <font color=\"#008000\">$paused_txt &quot;$name&quot;</font> - <a
             href=\"javascript:modify($id);\">MODIFY</a> -
             <a href=\"javascript:deletepjs('".PJS_TABLE."',$id,'$name');\">DELETE?</a> $run_only_once_txt<br>
             <small>Script path: <font color=\"#000000\">$scriptpath</font></small>
           </div>
           </th>
          <th align=\"center\" bgcolor=\"$bg_colour\">
           <div id=\"pjs$id\">
             $last_fire_hours $last_fire_date
           </div>
           </th>
           <th align=\"center\" bgcolor=\"$bg_colour\">
           <div id=\"pjs$id\">
             $fire_hours on<br> $fire_date
           </div>
           </th>
            <th align=\"center\" bgcolor=\"$bg_colour\">
           <div id=\"pjs$id\">
            $time_interval[0] $time_interval[1]
           </div>
           </th>
           </tr>";
  }
 }
 else $table_rows="<b><font color=\"#FF0000\">NO Jobs saved - to add a NEW scheduled job click the Add NEW schedule link above.</font></b><br><br>";
 echo $table_rows;
}

function show_logs($qstart)
{
 $num=20;// logs to display
 $next_logs=$num+$qstart;
 $dbc = dbc::instance();
 $query="select * from ".LOGS_TABLE." ORDER BY id DESC LIMIT $qstart, $num";
 $result = $dbc->prepare($query);
 $rows = $dbc->executeGetRows($result);
 if(count($rows))
 {
  $i = 0;
  $table_rows="";
  $bg_colour="#FFFFFF";
  foreach ($rows AS $row)
  {
   foreach ($row AS $key => $value) $$key = $value; 
   $log_date=strftime("Date: %d %b %Y  Time: %H:%M:%S",$date_added);
   if ($bg_colour=="#E9E9E9") $bg_colour="#FFFFFF"; else $bg_colour="#E9E9E9";
   if ($output!="") $show_hide="<a href=\"javascript:show_hide('$id');\">Show/Hide</a>";
   else $show_hide="NO data";
   $table_rows.="
     <tr align=\"center\">
      <th align=\"left\" bgcolor=\"$bg_colour\">
      <div id=\"pjs$id\">
        <small>Script: <font color=\"#000000\">$script</font>
            <br>Execution time: <font color=\"#000000\">$execution_time</font>
         Output: <font color=\"#FF8000\">*</font>
         $show_hide
         <div id=\"$id\" style=\"display:none;background-color:#FFE6E6;color:#FF0000\">
          <blockquote>$output <br></blockquote>
         </div>
        </small></small>
      </div>
     </th>
     <th align=\"center\" bgcolor=\"$bg_colour\">
      <small><div id=\"pjs$id\">$log_date <br>
       <a href=\"javascript:deletepjs('".LOGS_TABLE."',$id,'$script');\">DELETE?</a>
       <br></small></div>
     </th>
    </tr>";
    $i++;
  }
  $qend=$i+$qstart;
  echo "$table_rows </table></center></div></form> <center><strong>
      Currently displaying most recent logs from $qstart to $qend<br></strong>";
  $next_link="<strong><a href=\"error-logs.php?start=$next_logs\">Show Next $num logs &gt;&gt;</a>
             </strong><br><br><br>";
  if ($num==$i) echo $next_link;
  echo '<p align="center"><font color="#FF8000">* Maximum length of output will be
       <strong>'.MAX_ERROR_LOG_LENGTH.' characters</strong>. </font>To change this
       <a href="../readme.html#error_log">please see the readme file</a><br>';

 }
 else echo "<b><center><font color=\"#FF0000\">NO logs.</font>";
}

function fire_script($script,$id,$buffer_output=1)
{
 if(($buffer_output) AND (!DEBUG)) ob_start();//buffer output 
 $scriptRunning = new scriptStatus;
 $scriptRunning->script=$script;
 if ($scriptRunning->Running($id) )
 {
      if (DEBUG) echo "<br>Now running: $script - id=$id (debug ref. 3.9b)<br>";
      $start_time = microtime(true);
      $fire_type = (function_exists('curl_exec') ) ? " PHP CURL " : " PHP fsockopen ";
      //                 "://" satisfies both cases http:// and https://
      if (strstr($script,"://") ) fire_remote_script($script);
      else
       {
         include(LOCATION.$script);
         $fire_type=" PHP include ";
       }
      if(($buffer_output) AND (!DEBUG)) 
      {
        $scriptRunning->output=ob_get_contents();
        ob_end_clean();
      }
      if (!$buffer_output) $scriptRunning->output="";
      $scriptRunning->execution_time=number_format( (microtime(true) - $start_time), 5 )." seconds via".$fire_type;
      $scriptRunning->Stopped($id);
 }
}

function Clear($id)
{
 $dbc = dbc::instance();
 //If things go wrong, or script timeout CLEAR script so will run next time
 $result = $dbc->prepare("UPDATE ".PJS_TABLE." SET currently_running = '0' where id='$id' ");
 $result = $dbc->execute($result); 
}

class scriptStatus {
  public $script;
  public $output;
  public $executionTime;
  public function Running($id)
  {
   $dbc = dbc::instance();
   $result = $dbc->prepare("UPDATE ".PJS_TABLE." SET currently_running='1' where id='$id' ");
   $result = $dbc->execute($result);
   register_shutdown_function('Clear', $id);//registered incase execution times out before scriptStatus->Stopped called
   return $result;                          //register_shutdown_function always works, where destruct might not!
  }
  public function Stopped($id)
  {
   $dbc = dbc::instance();
   $result = $dbc->prepare("UPDATE ".PJS_TABLE." SET currently_running='0' where id='$id' ");
   $result = $dbc->execute($result);
   if (ERROR_LOG) //save log to db
   {
    $now = time();
    $this->script=clean_input($this->script);
    $this->output=substr(htmlentities($this->output), 0, MAX_ERROR_LOG_LENGTH);// truncate output to defined length     
    $query="INSERT INTO ".LOGS_TABLE." (`id`, `date_added`,`script`, `output`, `execution_time`)
                VALUES (NULL,'$now', '$this->script','$this->output','$this->execution_time') ";
    $result = $dbc->prepare($query);
    $result = $dbc->execute($result);
    if (DEBUG) echo "<br>QUERY to insert data to ".LOGS_TABLE." table:<br>$query (debug ref. 3.9c)<br>";
   }   
  }
}

function fire_remote_script($url)
{
  $url_parsed = parse_url($url);
  $scheme = $url_parsed["scheme"];
  $host = $url_parsed["host"];
  $port = isset($url_parsed["port"]) ? $url_parsed["port"] : 80;
  $path = isset($url_parsed["path"]) ? $url_parsed["path"] : "/";
  $query = isset($url_parsed["query"]) ? $url_parsed["query"] : "";
  $user = isset($url_parsed["user"]) ? $url_parsed["user"] : "";
  $pass = isset($url_parsed["pass"]) ? $url_parsed["pass"] : "";
  $useragent="phpJobScheduler (http://www.dwalker.co.uk/phpjobscheduler/)";
  $referer=$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
  $buffer="";
  if (function_exists('curl_exec'))
  {
   $ch = curl_init($scheme."://".$host.$path);
   curl_setopt($ch, CURLOPT_PORT, $port);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($ch, CURLOPT_HEADER, 0);
   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
   curl_setopt($ch, CURLOPT_FAILONERROR,1); // true to fail silently
   curl_setopt($ch, CURLOPT_AUTOREFERER,1);
   curl_setopt($ch, CURLOPT_POSTFIELDS,$query);
   curl_setopt($ch, CURLOPT_REFERER,$referer);
   curl_setopt($ch, CURLOPT_USERAGENT,$useragent);
   curl_setopt($ch, CURLOPT_USERPWD,$user.":".$pass);
   $buffer = curl_exec($ch);
   curl_close($ch);
  }
  elseif ( $fp = @fsockopen($host, $port, $errno, $errstr, 30) )
  {
   $header = "POST $path HTTP/1.0\r\nHost: $host\r\nReferer: $referer\r\n"
             ."Content-Type: application/x-www-form-urlencoded\r\n"
             ."User-Agent: $useragent\r\n"
             ."Content-Length: ". strlen($query)."\r\n";
   if($user!= "") $header.= "Authorization: Basic ".base64_encode("$user:$pass")."\r\n";
   $header.= "Connection: close\r\n\r\n";
   fputs($fp, $header);
   fputs($fp, $query);
   if ($fp) while (!feof($fp)) $buffer.= fgets($fp, 8192);
   @fclose($fp);
  }
 echo $buffer;
}

function version_check()
{
 global $phpJobScheduler_version;
 $version_url="HTTP://www.dwalker.co.uk/versions/";
 echo '<script src="'.$version_url.'" type="text/javascript"></script>
       <script language="JavaScript"><!--
        var phpJobScheduler_version = "'.$phpJobScheduler_version.'";

        var version_txt=phpJobScheduler_version;
        if (LATEST_phpJobScheduler_version==phpJobScheduler_version)
        {
         version_txt=version_txt+"<br><font color=#008000>which is the most recent version.</font>";
        }
        else
        {
          version_txt=version_txt+"<br><b><font color=#FF0000>UPGRADE REQUIRED";
          version_txt=version_txt+"<br>Please <a href=http://www.phpJobScheduler.co.uk/>visit here</a> ";
          version_txt=version_txt+"to download the latest version </b>";
        }
        document.write(version_txt);
       // --></script>';
}


class dbc extends PDO
{
 protected static $instance;

 public function __construct()
 {   
   $options = array(PDO::ATTR_PERSISTENT => true,
   PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
   PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES '".CHARSET."';" // this command will be executed during every connection to server - suggested by: vit.bares@gmail.com
   );
   try {
        $this->dbconn = new PDO(DBDRIVER.":host=".DBHOST.";port=".DBPORT.";dbname=".DBNAME,DBUSER,DBPASS,$options);
        return $this->dbconn;
       }
    catch (PDOException $e){ $this->reportDBError($e->getMessage()); }   
 }
 
 public function reportDBError($msg)
 {
  if (DEBUG) print_r('<div style="padding:10%;"><h3>'.nl2br($msg).'</h3>(debug ref. 3.9d)</div>');
  else
  {
   if(!session_id()) session_start();
   $_SESSION['mysql_errors'] = "\n\nDb error: ".$msg."\n";
  }
 }
 
 public static function instance()
 {
  if (!isset(self::$instance)) self::$instance = new self();
  return self::$instance;
 }

 public function prepare($query, $options = NULL) {
  try { return $this->dbconn->prepare($query); }
   catch (PDOException $e){ $this->reportDBError($e->getMessage()); }   
 }      

 public function bindParam($query) {
  try { return $this->dbconn->bindParam($query); }
   catch (PDOException $e){ $this->reportDBError($e->getMessage()); }     
 }

 public function query($query) {
  try {
       if ($this->query($query)) return $this->fetchAll();
       else return 0;
      } 
   catch (PDOException $e){ $this->reportDBError($e->getMessage()."<hr>".$e->getTraceAsString()); } }

 public function execute($result) {//use for insert/update/delete
  try { if ($result->execute()) return $result; } 
   catch (PDOException $e){ $this->reportDBError($e->getMessage()."<hr>".$e->getTraceAsString()); }     
 }
 public function executeGetRows($result) {//use to retrieve rows of data
  try { 
       if ($result->execute()) return $result->fetchAll(PDO::FETCH_ASSOC);
       else return 0;
      }
    catch (PDOException $e){ $this->reportDBError($e->getMessage()."<hr>".$e->getTraceAsString()); }     
 }

 public function __clone()
 {  //not allowed
 }
 public function __destruct()
 {
  $this->dbconn = null;
 }
}