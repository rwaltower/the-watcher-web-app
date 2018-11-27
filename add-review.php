<?php

require_once('db-connect.php');

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(empty(trim($_POST["review-show-title"]))) {
        $title_err = "You must have a show to review";
    } else {
        $title = trim($_POST['review-show-title']);
    }

    if(empty(trim($_POST["rating"]))) {
        $rating_err = "You must rate the show out of 10";
    } else {
        $rating = trim($_POST['rating']);
    }

    $comments = trim($_POST['comments']);

    if(empty($title_err) && empty($rating_err)) {
        $sql = "SELECT id FROM shows WHERE title = '$title'";
        $show_id = $link->query($sql);

        $sql = "INSERT INTO user_has_reviews (show_id, user_id, rating, comments) VALUES (?, ?, ?, ?)";

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sss", $show_id, $_SESSION['id'], $rating, $comments);
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: /index.php/#home");
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
        mysqli_stmt_close($stmt);

    }

    mysqli_close($link);

}