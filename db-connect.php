<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'thewatcherdbinstance.crtbtchlupnh.us-east-1.rds.amazonaws.com');
define('DB_USERNAME', 'thewatchadmin');
define('DB_PASSWORD', 'thewatcher112618');
define('DB_NAME', 'the_watcher');

/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>