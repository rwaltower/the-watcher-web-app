<?php

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: /#home");
    exit;
} else {
    header("location: /#login");
}
require_once('db-connect.php');

//retrieve user shows and reviews here
function displayUserShows() {
    require_once('db-connect.php');

    $user= $_SESSION["user_id"];

    $sql = "SELECT show_id FROM user_has_shows WHERE user_id = '$user'";
    $results = $link->query($sql);
    $show_ids = mysqli_fetch_assoc($results);
    $implode_arr = implode(',', $show_ids);

    $show_titles = array();
    $show_status = array();
    foreach($show_ids as $id) {
        $sql = "SELECT title FROM shows WHERE id IN ('$implode_arr')";
        $title = $link->query($sql);
        array_push($show_titles, $title);

        $sql = "SELECT watched FROM user_has_shows WHERE show_id = '$id'";
        $watched = $link->query($sql);
        array_push($show_status, $watched);
    }

    $shows = array($show_titles, $show_status);

    for ($i = 0; $i < count($show_ids); $i++) {
        if ($shows[1][$i] == true) {
            echo "<tr class='active show'><td class='title'>$shows[0][$i]<input id='watched' type='checkbox' name='watched' onclick='watchShow($shows[0][$i])' value='$shows[0][$i]' checked/></td></tr>";

        } else if ($shows[1][$i] == false) {
            echo "<tr class='show'><td class='title'>$shows[0][$i]</td><input id='watched' type='checkbox' name='watched' onclick='watchShow($shows[0][$i])' value='$shows[0][$i]'/></tr>";

        }
    }

}

function displayUserReviews() {
    require_once('db-connect.php');

    $user= $_SESSION["user_id"];

    $sql = "SELECT show_id FROM user_has_reviews WHERE user_id = '$user'";
    $results = $link->query($sql);
    $show_ids = mysqli_fetch_assoc($results);
    $implode_arr = implode(',', $show_ids);

    $review_titles = array();
    $review_ratings = array();
    $review_comments = array();

    foreach($show_ids as $id) {
        $sql = "SELECT title FROM shows WHERE id IN ('$implode_arr')";
        $title = $link->query($sql);
        array_push($review_titles, $title);

        $sql = "SELECT rating FROM user_has_reviews WHERE show_id = '$id'";
        $rating = $link->query($sql);
        array_push($review_ratings, $rating);

        $sql = "SELECT comments FROM user_has_reviews WHERE show_id = '$id'";
        $comments = $link->query($sql);
        array_push($review_comments, $comments);

    }

    $reviews = array($review_titles, $review_ratings, $review_comments);

    for ($i = 0; $i < count($show_ids); $i++) {
        echo "<tr><td>$reviews[0][$i]</td><td>$reviews[1][$i]</td><td>$reviews[2][$i]</td></tr>";
    }

}

function watchShow($show) {
    $user= $_SESSION["user_id"];
    $sql = "SELECT id FROM shows WHERE id = '$show'";

    $show_id = $link->query($sql);

    $sql = "UPDATE user_has_shows SET watched = CASE WHEN watched = true THEN false WHEN watched = false THEN true ELSE watched END WHERE user_id = '$user', show_id = '$show_id'";

    $link->query($sql);
}

?>

<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            //show register form on click
            $("#register-button").click(function (e) {
                $("#login").css('display: none');
                $("#register").css('display: ""');
            });

            $(".show").click(function (e) {

                //populate review show title with value in title cell of show you clicked
                var title = $(this).closest('tr').children('td.title').text();
                $('input[type=text][name=review-show-title]').val(title);
            })
        })
    </script>

</head>
<body>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">The Watcher</a>
        </div>
    <ul class="nav navbar-nav">
        <li><a href="#shows">Shows</a></li>
        <li><a href="#reviews">Reviews</a></li>
        <li><a href="#add-show">Add Show</a></li>
        <li><a href="#add-review">Add Review</a></li>
    </ul>
    </div>
</nav>

<div id="register" class="container" <?php if ($_SESSION['loggedin'] == true) echo " style='display: none"; else echo " style='display: ''";?>>
    <form id="register-form" class="form-group" action="/register.php" method="post">
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
            <label for="confirm-password">Password: </label>
            <input type="password" class="form-control" name="confirm-password" required>
        </div>
        <button id="#register-button" type="submit" class="btn btn-default">Register</button>
    </form>
</div>

<div id="login" class="container" <?php if ($_SESSION['loggedin'] == true) echo " style='display: none"; else echo " style='display: ''";?>>
    <form id="login-form" class="form-group" action="/login.php" method="post">
        <div class="form-group">
            <label for="username">Username: </label>
            <input type="text" class="form-control" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Password: </label>
            <input type="password" class="form-control" name="password" required>
        </div>
        <button type="submit" class="btn btn-default">Login</button>
    </form>
    <button type="button" 
</div>

<div id="home" <?php if ($_SESSION['loggedin'] == false) echo " style='display: none"; else echo " style='display: ''";?>>
<div id="shows" class="container">

    <table class="table table-hover">
        <caption>Shows</caption>

        <tbody>
        <tr>
            <th>Unwatched</th>
            <th class="active">Watched</th>
        </tr>
        <?php displayUserShows()?>
        </tbody>
        <tr>

        </tr>
    </table>

    <button type="button" class="btn btn-default">Add Show</button>
</div>

    <div id="add-show" class="container">
        <h2>Add Show</h2>
        <form id="add-show-form" class="form-group" action="/add-show.php" method="post">
            <div class="form-group">
                <label for="title">Title: </label>
                <input type="text" class="form-control" name="title" required>
            </div>
            <div class="form-group">
                <label for="watched">Watched? </label>
                <input type="radio" class="form-control" name="yes" > Yes
                <input type="radio" class="form-control" name="no" checked> No

            </div>

            <button type="submit" class="btn btn-default">Add</button>
    </div>
    </form>
</div>

<div id="add-review" class="container">
    <h2 id="review-title">Add Review</h2>
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

<div id="reviews" class="container">
    <table class="table">
        <caption>Reviews</caption>
        <tr>
            <th>Title</th>
            <th>Rating</th>
            <th>Comments</th>
        </tr>
            <?php displayUserReviews()?>
    </table>
</div>
</div>
</body>
</html>