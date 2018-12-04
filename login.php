<?php
session_start();
require_once('db-connect.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
if(isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
        $password = $_POST['password'];
        $query = "SELECT * FROM users WHERE username = '$username' and password = '$password'";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connect));
        $user = mysqli_fetch_row($result);
        if(mysqli_num_rows($result)) {
            $_SESSION['user_id'] = $user[0];
            $_SESSION['username'] = $username;
            $_SESSION['loggedin'] = true;
            header('Location: http://' . $_SERVER['HTTP_HOST'] . '/the-watcher-web-app/index.php');
        } else {
            echo 'Username/password combination invalid.';
        }
}
}
?>

<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div id="login" class="container">
    <h2>Login</h2>
    <form id="login-form" class="form-group" method="POST">
        <div class="form-group">
            <label for="username">Username: </label>
            <input type="text" class="form-control" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Password: </label>
            <input type="password" class="form-control" name="password" required>
        </div>
        <button type="submit" class="btn btn-default">Login</button>
        <a href="register.php"><button type="button" class="btn btn-default">Create Account</button></a>
    </form>
     
</div>
</body>
</html>