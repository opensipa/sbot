<?php
// File containing cronjobs
$cronFile = dirname(__FILE__) . '/crontab';

// Lockfile to prevent multiple instances
$pidFile = dirname(__FILE__) . '/cron.lock';

// Exit file to signal a running instance to exit
$exitFile = dirname(__FILE__) . '/cron.exit';

// Temp file to store cronjob stderr output in
$stderrFile = dirname(__FILE__) . '/job.stderr';

// Cron execution reporting option
$reportType = REPORTING_OUTPUT;

// Email address to send administrative reports to
$adminEmail = 'admin@yourdomain.com';
?>