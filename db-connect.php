<?php
$connection = mysqli_connect('thewatcherdbinstance.crtbtchlupnh.us-east-1.rds.amazonaws.com', 'thewatchadmin', 'thewatcher112618');
if (!$connection) {
    die("Database Connection Failed" . mysqli_error($connection));
}
$select_db = mysqli_select_db($connection, 'the_watcher');
if (!$select_db) {
    die("Database Selection Failed" . mysqli_error($connection));
}

?>