<?php
$hostname="thewatcherdbinstance.crtbtchlupnh.us-east-1.rds.amazonaws.com";
$username="thewatchadmin";
$password="thewatcher112618";
$dbname="the_watcher";

// Create connection
$connection = new mysqli($hostname, $username, $password, $dbname);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
?>