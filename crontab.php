<?php

/* 
 * Setting cron for scheduling
 * 
 * 
 */

include('theme/verification.php');
include('theme/header.php');
include('functions/function.php');
include('functions/functionDb.php');
include('config.php');
include('init.php');
?>
    <div id="content" class="clearfix">
    Gestore del Cron:<br>
    <br>
    <center><div style="float:left; width:25%">
    <?php 
            echo'<form method="post" action="crontab.php" method="POST">'
            .   '<input type="submit" name="Status" value="Status del Cron" />'
            .   '</form>';
    
            if (isset($_POST["Status"])) {
            include ('scheduler/cron.php');
            //Launch cron.php?status
            $output = Status("status");
            echo $output;                    
    }
    ?>
    </div>
    <div style="float:left; width:25%">
    <?php 
            echo'<form method="post" action="crontab.php" method="POST">'
            .   '<input type="submit" name="Edit" value="Edit il Cron" />'
            .   '</form>';
    
            if (isset($_POST["Edit"])) {
            include ('scheduler/cron.php');
            $output = Status("edit");
            echo $output;                    
    }
    ?>
    </div>
    <div style="float:left; width:25%">
    <?php 
            echo'<form method="post" action="crontab.php" method="POST">'
            .   '<input type="submit" name="Kill" value="Kill il Cron" />'
            .   '</form>';
    
            if (isset($_POST["Status"])) {
            include ('scheduler/cron.php');
            $output = Status("kill");
            echo $output;                    
    }
    ?>
    </div>
    <div style="float:left; width:25%">
    <?php 
            echo'<form method="post" action="crontab.php" method="POST">'
            .   '<input type="submit" name="Force" value="Force il Cron" />'
            .   '</form>';
    
            if (isset($_POST["Force"])) {
            include ('scheduler/cron.php');
            $output = Status("force");
            echo $output;                    
    }
    ?>
    </div>
    </center>
</div>
<!-- Footer page -->
<?php include('theme/footer.php'); ?>