<?php

require_once('db-connect.php');

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(empty(trim($_POST['title']))) {
        $title_err = "Must add show title";
    } else {
        $title = trim($_POST['title']);
    }

    if (isset($_POST['yes'])) {
        $watched = true;
    } else {
        $watched = false;
    }

    if(empty($title_err)) {
        $sql = "INSERT INTO shows (title) VALUES (?)";

        if($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_title);
            $param_title = $title;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                $sql = "SELECT LAST_INSERT_ID()";
                $show_id = $link->query($sql);

                $sql = "INSERT INTO user_has_shows (show_id, user_id, watched) VALUES (?,?,?)";

                if($stmt) {
                    mysqli_stmt_bind_param($stmt, "sss", $show_id, $_SESSION['id'], $watched);
                    if(mysqli_stmt_execute($stmt)){
                        // Redirect to login page
                        header("location: /index.php/#home");
                    } else{
                        echo "Something went wrong. Please try again later.";
                    }
                }

            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);

}