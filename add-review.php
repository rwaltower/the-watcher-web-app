<?php

require_once('db-connect.php');
$theerror = "";
if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(empty(trim($_POST["review-show-title"]))) {
        $title_err = "You must have a show to review";
        $theerror = $title_err;
    } else {
        $title = trim($_POST['review-show-title']);
    }

    if(empty(trim($_POST["rating"]))) {
        $rating_err = "You must rate the show out of 10";
        $theerror = $rating_err;
    } else {
        $rating = trim($_POST['rating']);
    }

    if(empty(trim($_POST["comments"]))) {
        $comments = " ";
    } else {
        $comments = trim($_POST['comments']);
    }


    if(empty($title_err) && empty($rating_err)) {
        $sql = "SELECT id FROM shows WHERE title = '$title'";
        $show_id = $link->query($sql);

        $sql = "INSERT INTO user_has_reviews (show_id, user_id, rating, comments) VALUES (?, ?, ?, ?)";

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sss", $show_id, $_SESSION['user_id'], $rating, $comments);
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header('Location: http://' . $_SERVER['HTTP_HOST'] . '/index.php');
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
        mysqli_stmt_close($stmt);

    }

    mysqli_close($link);

}

include_once('header.php');


?>

<div id="add-review" class="container">
    <h2 id="review-title">Add Review</h2>
    <div class = alert alert-danger><?php echo $theerror ?></div>
    <form id="add-review-form" class="form-group" action="/add-review.php" method="post">
        <div class="form-group">
            <input type="text" class="form-control" name="review-show-title" readonly>
        </div>

        <div class="form-group">
            <label for="rating">Rating (out of 10): </label>
            <input type="number" class="form-control" name="rating" min="1" max="10" required>
        </div>
        <div class="form-group">
            <label for="comments">Comments: </label>
            <input type="text" class="form-control" name="comments">
        </div>
        <button type="submit" class="btn btn-default">Add</button>
        </div>
    </form>
</div>
</body>
</html>