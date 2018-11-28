<?php
session_start();
require_once('db-connect.php');

$theerror = "";
if(isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
        $password = $_POST['password'];
        $query = "SELECT * FROM users WHERE username = '$username' and password = '$password'";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connect));
        
        if($result) {
            $_SESSION['username'] = $username;
            $_SESSION['loggedin'] = true;
            header('Location: http://' . $_SERVER['HTTP_HOST'] . '/the-watcher-web-app-master/index.php');
        } else {
            $therror = "<div class = 'alert alert-danger'>Username/password combination invalid</div>";
        }
}

include_once('header.php');
?>

<div id="login" class="container">
<?php echo $theerror ?>
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
        <button type="button" class="btn btn-default"><a href="register.php">Make Account</a></button>
    </form>
     
</div>
</body>
</html>