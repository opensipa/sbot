<?php
// site: https://katyscode.wordpress.com/2006/10/17/phpcron-running-scheduled-tasks-from-php-on-a-web-server/
// PHPCron v1.01
// written by Katy Coe - http://www.djkaty.com
// (c) Intelligent Streaming 2006

// Usage from command-line:
// php cron.php [--param]

// Usage from web browser:
// http://www.yourdomain.com/path/to/cron/cron.php[?param]

// Parameters:
// status - get running state of PHPCron
// edit   - edit crontab (from web browser only)
// kill   - kill running instances of PHPCron
// force  - kill running instances of PHPCron and create one new instance

// v1.00 (15-Oct-2006)
// First working version
//
// v1.01 (21-Nov-2006)
// Added email reporting capability and stderr capture ($reportType, REPORTING_*)
// Added ability to assign job names (as first parameter in cronjob line)

// Cronjob execution report types
define('REPORTING_ALL', 1);         // Report all executions whether they produced output or not
define('REPORTING_OUTPUT', 2);      // Report executions that produced output or errors
define('REPORTING_ERROR', 3);       // Report executions that produced errors
define('REPORTING_NONE', 4);        // Don't report any executions

// Define function for running cron

function Status($status) {
   Launch ($status);
}

function Run ($job) {
// Get configuration
include "cron.config.php";

// No timeout expiration
set_time_limit(0);

// Running from command line
if (!is_web_environment())
{
    // Status report requested?
    if (array_search('--status', $_SERVER['argv']) !== false)
    {
        echo "Cron is " . (file_exists($exitFile)? 'waiting to exit' :
                            (file_exists($pidFile)? '' : 'not ') . 'running') . ".\r\n";
        exit;
    }
    
    echo "Starting cron from the command line.\r\n";
    
    // Start cron
    cron($cronFile, $pidFile, $exitFile, $stderrFile, $reportType, $adminEmail,
        array_search('--force', $_SERVER['argv']) !== false,
        array_search('--kill', $_SERVER['argv']) !== false);
}

// Running from web server
else
{
    // Run the crontab editor interface if 'edit' supplied as GET parameter
    if (isset($_GET['edit']))
    {
        cron_edit($cronFile);
        exit;
    }
    
    // Continue running script upon user abort (when running from web server)
    ignore_user_abort(true);

    // Close connection to browser before running shutdown function
    header("Pragma: public");
    header("Content-Type: text/plain; name=\"cron.txt\"");
    header("Content-Disposition: inline; filename=\"cron.txt\"");
    header("Cache-Control: no-store");
    header("Connection: close");
    
    ob_start();

    // Status report requested?
    //if (isset($_GET['status']))
    if (isset($job))
    {
        $output = "Cron is " . (file_exists($exitFile)? 'waiting to exit' :
                            (file_exists($pidFile)? '' : 'not ') . 'running') . ".\r\n";
        return $output;
        exit;
    }
    else
        echo "Starting cron from a web server environment.\r\n";
        
    // Start cron
    cron($cronFile, $pidFile, $exitFile, $stderrFile, $reportType, $adminEmail,
            isset($_GET['force']),
            isset($_GET['kill']));
}
exit;
}


// Class representing a single cronjob
// Rules for crontab file format and scheduling conditions taken from:
// http://en.wikipedia.org/wiki/Cron
class CronJob {
    public $minutes;
    public $hours;
    public $dates;
    public $months;
    public $weekdays;
    public $job;
    public $name;
    
    public function __construct($jobText)
    {
        // Get parameters
        $jobText = trim($jobText);
        $jobText = preg_replace('#\s{2,}#', ' ', $jobText);
        
        // Determine if cron entry starts with a name
        if (preg_match('/[\*0-9]/', substr($jobText, 0, 1)) === 0)
        {
            $jobParams = split(' ', $jobText, 7);
            $this->name = str_replace('_', ' ', $jobParams[0]);
            array_shift($jobParams);
        }
        else
        {
            $jobParams = split(' ', $jobText, 6);
            $this->name = 'Unnamed job';
        }
        
        // If insufficient parameters supplied, abort silently
        if (count($jobParams) < 6)
            return;
        
        // Parse time parameters
        $this->minutes = $this->parse_param($jobParams[0], 0, 59);
        $this->hours = $this->parse_param($jobParams[1], 0, 23);
        $this->dates = $this->parse_param($jobParams[2], 1, 31);
        $this->months = $this->parse_param($jobParams[3], 1, 12);
        $this->weekdays = $this->parse_param($jobParams[4], 0, 7);
        
        // 0 and 7 are both counted as Sunday
        if ($this->weekdays == 7)
            $this->weekdays = 0;
        
        // Shell job command
        $this->job = implode(' ', array_slice($jobParams, 5));
    }
    
    private function parse_param($text, $min, $max)
    {
        $result = array();
        
        // * - all possible values
        if ($text == '*')
            for ($i = $min; $i <= $max; $i++)
                $result[] = $i;
                
        // "*/n" syntax - starts at $min and recurs every n
        elseif (substr($text, 0, 2) == '*/')
            for ($i = $min; $i <= $max; $i += substr($text, 2))
                $result[] = $i;
        
        else
        {
            // Split by commas
            $timeItems = split(',', $text);
            
            foreach ($timeItems as $timeItem)
            {
                // X-Y syntax - starts at X and increments by 1 to Y inclusive,
                // wrapping around from $max to $min if necessary
                if (strpos($timeItem, '-') !== false)
                {
                    list ($first, $last) = split('-', $timeItem, 2);
                    
                    // Bound specified range within min/max parameters
                    $first = max(min($first, $max), $min);
                    $last = max(min($last, $max), $min);
                    
                    // Non-wrapping range
                    if ($first <= $last)
                        for ($i = $first; $i <= $last; $i++)
                            $result[] = $i;
                    
                    // Wrapping range
                    else {
                        for ($i = $first; $i <= $max; $i++)
                            $result[] = $i;
                            
                        for ($i = $min; $i <= $last; $i++)
                            $result[] = $i;
                    }
                }
                
                // Single number
                else
                    $result[] = $timeItem;
            }
        }
        return $result;
    }
}

// Crontab scheduler
function cron($cronFile, $pidFile, $exitFile, $stderrFile, $reportType, $adminEmail, $force, $kill)
{
    // Forced execution if force flag set
    if ($force || $kill)
    {
        // Check we aren't already waiting
        if (file_exists($exitFile))
        {
            echo "Cron is already waiting to die.\r\n";
            end_output();
            exit;
        }
        
        // Check there is another instance running
        if (!file_exists($pidFile))
        {
            echo "There are no instances of cron running.\r\n";
            end_output();
            exit;
        }
        
        // Signal other instances to exit
        FileUtils::Lock($exitFile);
        
        // Kill all instances including this one if kill flag set
        if ($kill) {
            echo "Killing all instances of cron.\r\n";
            end_output();
            exit;
        }
        
        // Otherwise wait for other instances to die if force flag set
        if ($force) {
            echo "Waiting for other instances of cron to die.\r\n";
            while (file_exists($pidFile))
                sleep(1);
            echo "Resuming cron.\r\n";
        }
    }
    
    // Don't allow multiple instances
    if (file_exists($pidFile))
    {
        echo "Cron is already running.\r\n";
        end_output();
        exit;
    }
    
    // Read cron file
    if (!file_exists($cronFile))
    {
        echo "No crontab file found.\r\n";
        end_output();
        exit;
    }

    // Configure cleanup    
    register_shutdown_function('cron_cleanup', $pidFile, $exitFile);

    // Make web browser connection close here if not already done
    echo "Cron startup successful.\r\n";
    end_output();
        
    // Create lockfile
    FileUtils::Lock($pidFile);
    
    $jobsText = file($cronFile);
    
    $jobs = array();
    foreach ($jobsText as $jobText)
        $jobs[] = new CronJob($jobText);
        
    // Enter processing and wait loop
    while (!file_exists($exitFile))
    {
        $nowStamp = time();
        $now = getdate($nowStamp);
        
        // Iterate through each job determining whether it's time to run it,
        // and execute those which match the time criteria
        foreach ($jobs as $job)
            if (    array_search($now['minutes'],   $job->minutes) !== false
                and array_search($now['hours'],     $job->hours) !== false
                and array_search($now['mon'],       $job->months) !== false
                and (array_search($now['mday'],     $job->dates) !== false
                    or array_search($now['wday'],   $job->weekdays) !== false))
                    {
                        echo "Running job: " . $job->name . "\r\n";
                        
                        // Redirect output on non-Windows platforms so process executes in background
                        if (substr(strtoupper(PHP_OS), 0, 3) == 'WIN')
                            @exec($job->job);
                            
                        // On UNIX, output and error capture and reporting is available
                        else
                        {
                            // Remove old output and errors
                            unset($output);
                            @unlink($stderrFile);
                            
                            // Execute job
                            @exec("{$job->job} 2> $stderrFile", $output);
                            
                            // Send report
                            cron_report($job->name, $job->job, $reportType, $adminEmail,
                                        implode('\n', $output),
                                        file_get_contents($stderrFile));
                            
                            // Remove error output in case it contains sensitive data
                            @unlink($stderrFile);
                        }
                    }
        
        // Wait until 60 seconds expired since last check
        // (might be less than a minute if the jobs took a while to execute
        // as we are single-threaded)
        while (time() < $nowStamp + 60)
            sleep(1);
    }
}

function cron_cleanup($pidFile, $exitFile)
{
    FileUtils::Unlock($pidFile);
    FileUtils::Unlock($exitFile);
}

function cron_report($jobName, $jobExec, $reportType, $email, $stdout, $stderr)
{
    $report = false;
    
    switch ($reportType) {
        case REPORTING_ALL:
            $report = true;
            break;
    
        case REPORTING_ERROR:
            $report = (strlen($stderr) > 0);
            break;
        
        case REPORTING_OUTPUT:
            $report = (strlen($stderr) > 0 || strlen($stdout) > 0);
            break;
        
        case REPORTING_NONE:
            $report = false;
            break;
    }
    
    if ($report)
    {
        if (strlen($stdout) == 0)
            $stdout = '<none>';
        
        if (strlen($stderr) == 0)
            $stderr = '<none>';
        
        $execTime = strftime('%T %Z on %a %d %B %Y');
        $subject = "PHPCron Report for task $jobName";
        $body = <<<EndOfEmail
PHPCron Execution Report

Task: $jobName
Execute time: $execTime

$jobExec

Job Output
==========
$stdout

Job Errors
==========
$stderr
EndOfEmail;

        @mail($email, $subject, $body);
    }
}

// Crontab editor
function cron_edit($cronFile)
{
    header("Content-type: text/html");
    ?>
    <html>
        <head>
            <title>Cron Editor</title>
        </head>
        <body style="font-family: Verdana, sans-serif; font-size: x-small">
            <?php
            if (isset($_POST['crontab'])):
            
                // Negate escaping
                if (get_magic_quotes_gpc())
                {
        			if (ini_get('magic_quotes_sybase'))
        				$data = strtr($_POST['crontab'], array("''" => "'"));
        			else
        				$data = stripslashes($_POST['crontab']);
                }
                else
                    $data = $_POST['crontab'];

                $result = @file_put_contents($cronFile, $data);
                
                if ($result):
                    ?><p style="color: red">The crontab file was updated successfully.</p><?php
                else:
                    ?><p style="color: red">The crontab file could not be updated.</p><?php
                endif;
            endif;
            ?>
            <p>Syntax:
                <ul>
                    <li>One job per line</li>
                    <li>Line format: [Job_Name] &lt;minutes 0-59> &lt;hours 0-23> &lt;days of month 1-31> &lt;months 1-12> &lt;days of week 0-7> &lt;shell command to run></li>
                    <li>Job Name is optional and must not have spaces; underscores (_) will be converted to spaces when displaying the job name</li>
                    <li>Formats of each argument:
                        <ul>
                            <li>* - all possible values</li>
                            <li>*/n - every nth value (eg. */4 as month field = 1, 5, 9)</li>
                            <li>m-n - every value between m and n inclusive</li>
                            <li>a,b,c,d... - values a, b, c, d and so on</li>
                            <li>Dashed ranges can be used with commas eg. 1,5-18,19,30</li>
                        </ul>
                    </li>
                    <li>Days of week start at 0 = Sunday, 1 = Monday etc.; 7 is equivalent to Sunday</li>
                    <li>Job will be executed if minutes, hours, months and either dates or week days match</li>
                    <li>To run a php job, specify the shell command as "php &lt;script name to run>"</li>
                    <li>To run php embedded code, specify the shell command as "php -r "&lt;code to run without php tags>". Dollar signs in embedded code must be escaped with a backslash.</li>
                </ul>
            </p>
            
            <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
                <div>
                    <textarea name="crontab" cols="80" rows="20"><?php
                        if (file_exists($cronFile))
                            echo file_get_contents($cronFile);
                        ?></textarea>
                    <p><b>Edit crontab and press Save to commit changes. Cron must be restarted manually for the changes to take effect.</b></p>
                    <input type="submit" value="Save" />
                </div>
            </form>
            
            <a href="<?php echo substr($_SERVER['REQUEST_URI'], 0, strrpos($_SERVER['REQUEST_URI'], '?')) . '?force'; ?>">Restart cron</a>
        </body>
    </html>
    <?php
}

function is_web_environment()
{
    return ($_SERVER['argc'] == 0 || $_SERVER['argv'][0] != $_SERVER['PHP_SELF']);
}

function end_output()
{
    if (is_web_environment())
    {
        header("Content-Length: " . ob_get_length());
        ob_end_flush();
        flush();
    }
}

// Helper functions
class FileUtils
{
    // Prevent instantiation
    private function __construct() {}
    
    // Modified from http://no2.php.net/manual/en/function.flock.php user comments (hhw at joymail dot com / 16-Apr-2003 08:50)
    public static function Lock($lockFile)
    {
        while (file_exists($lockFile))
        {
            clearstatcache();
            usleep(rand(5, 70));
        }
        $file = fopen($lockFile, 'wb');
        fwrite($file, 'lock');
        fclose($file);
    }
    
    public static function Unlock($lockFile)
    {
        @unlink($lockFile);
    } 
}
?>