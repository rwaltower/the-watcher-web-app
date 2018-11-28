<?php

require_once('db-connect.php');
$theerror = "";
$user = $_SESSION['user_id'];
if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(empty(trim($_POST['title']))) {
        $title_err = "Must add show title";
        $theerror = $title_err;
    } else {
        $title = trim($_POST['title']);
    }

    if($_POST['watched'] == 'yes') {
        $watched = true;
    } else {
        $watched = false;
    }

    if(empty($title_err)) {
        $query = "INSERT INTO shows (title) VALUES ('$title')";
        
        $result = mysqli_query($connection, $query);
        
        if($result) {
            $query = "SELECT LAST_INSERT_ID()";
            
            $result = mysqli_query($connection, $query) or die(mysqli_error($connect));
            $show_id = mysqli_fetch_object($result);
            
            $query = "INSERT INTO user_has_shows (show_id, user_id, watched, reviewed) VALUES ('$show_id','$user','$watched', false)";
            $result = mysqli_query($connection, $query);
            if($result) {
                header('Location: http://' . $_SERVER['HTTP_HOST'] . '/the-watcher-web-app-master/index.php');
            } else{
                        echo "Something went wrong. Please try again later.";
                    }
            
        } else{
                echo "Something went wrong. Please try again later.";
            }
    }
    

}

include_once('header.php');
?>
 <div id="add-show" class="container">
        <h2>Add Show</h2>
            <?php echo $theerror ?>

        <form id="add-show-form" class="form-group" method="post">
            <div class="form-group">
                <label for="title">Title: </label>
                <input type="text" class="form-control" name="title" required>
            </div>
            <div class="form-group">
                <label for="watched">Watched? </label>
                <input type="radio" class="form-control" name="watched" > Yes
                <input type="radio" class="form-control" name="watched" checked> No

            </div>

            <button type="submit" class="btn btn-default">Add</button>
    </div>
    </form>
</div>
</body>