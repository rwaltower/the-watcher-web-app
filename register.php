<?php
session_start();
require_once('db-connect.php');
$theerror = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
if (isset($_POST['username']) && isset($_POST['password'])){
        $name = $_POST['name'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm-password'];
        
        if ($password != $confirm_password) {
            $theerror = "<div class = 'alert alert-danger'> Your passwords do not match</div>";
            
        } else {
        
        $query = "INSERT INTO `users` (`name`, `username`, `password`) VALUES ('$name','$username','$password')";
        $result = mysqli_query($connection, $query);
        
        
        $query = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connect));
        $user = mysqli_fetch_row($result);
        if(mysqli_num_rows($result)){
            $_SESSION['user_id'] = $user[0];
            $_SESSION['username'] = $username;
            $_SESSION['loggedin'] = true;
            header('Location: http://' . $_SERVER['HTTP_HOST'] . '/the-watcher-web-app/index.php');
        } else {
            echo "There was an error. Try again.";
        }
        }
    }
}
?>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div id="register" class="container">
    <h2>Create Account</h2>
    <?php echo $theerror ?>

    <form id="register-form" class="form-group" method="POST">
        <div class="form-group">
            <label for="name">Name: </label>
            <input type="text" class="form-control" name="name" required>
        </div>
        <div class="form-group">
            <label for="username">Username: </label>
            <input type="text" class="form-control" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Password: </label>
            <input type="password" class="form-control" name="password" required>
        </div>
        <div class="form-group">
            <label for="confirm-password">Confirm Password: </label>
            <input type="password" class="form-control" name="confirm-password" required>
        </div>
        <button id="#register-button" type="submit" class="btn btn-default">Submit</button>
    </form>
</div>
</body>
</html>