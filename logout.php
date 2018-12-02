<?php
session_start();

if(!empty($_SESSION['username'])){
    session_destroy();
}
header('Location: http://' . $_SERVER['HTTP_HOST'] . '/the-watcher-web-app/login.php');
?>