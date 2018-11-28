<?php

require_once('db-connect.php');
$theerror = "";

if (isset($_POST['username']) && isset($_POST['password'])){
        $name = $_POST['name'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm-password'];
        
        if ($password != $confirm_password) {
            $therror = "<div class = 'alert alert-danger'> Your passwords do not match</div>";
            
        } else {
        
        $query = "INSERT INTO `users` (`name`, `username`, `password`) VALUES ('$name','$username','$password')";
        $result = mysqli_query($connection, $query);
        if($result){
            $_SESSION['username'] = $username;
            $_SESSION['loggedin'] = true;
            header('Location: http://' . $_SERVER['HTTP_HOST'] . '/the-watcher-web-app-master/index.php');
        } else {
            echo $result;
        }
        }
    }
  

include_once('header.php');

?>

<div id="register" class="container">
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