<?php

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: /#home");
    exit;
}

//retrieve user shows and reviews here

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
            //hide home onload
            $("#home").hide();

            //hide register form onload
            $("#register").hide();

            //show register form on click
            $("#register-button").click(function (e) {
                $("#login").hide();
                $("#register").show();
            });
            //show home after registering
            $("#register-form").submit(function(e) {
                $("#register").hide();
                $("#home").show();
            });

            //show home after logging in
            $("#login-form").submit(function (e) {
                $("#login").hide();
                $("#home").show();
            });

            $(".show").click(function (e) {

                //populate review show title with value in title cell of show you clicked
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
        <li><a href="#add-review">Add Review</a></li>
    </ul>
    </div>
</nav>

<div id="register" class="container">
    <form id="register-form" class="form-group" action="/register.php" method="post">
        <div class="form-group">
            <label for="name">Name: </label>
            <input type="text" class="form-control" name="name">
        </div>
        <div class="form-group">
            <label for="username">Username: </label>
            <input type="text" class="form-control" name="username">
        </div>
        <div class="form-group">
            <label for="password">Password: </label>
            <input type="password" class="form-control" name="password">
        </div>
        <div class="form-group">
            <label for="confirm-password">Password: </label>
            <input type="password" class="form-control" name="confirm-password">
        </div>
        <button id="#register-button" type="submit" class="btn btn-default">Register</button>
    </form>
</div>

<div id="login" class="container">
    <form id="login-form" class="form-group" action="/login.php" method="post">
        <div class="form-group">
            <label for="username">Username: </label>
            <input type="text" class="form-control" name="username">
        </div>
        <div class="form-group">
            <label for="password">Password: </label>
            <input type="password" class="form-control" name="password">
        </div>
        <button type="submit" class="btn btn-default">Login</button>
    </form>
    <button type="button" 
</div>

<div id="home">
<div id="shows" class="container">

    <table class="table table-hover">
        <caption>Shows</caption>
        <tr>
            <th>Unwatched</th>
            <th>Watched</th>
        </tr>
        <tbody>
            <tr>
                //use php to add the users shows to rows
                <?php ?>
            </tr>
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
                <input type="text" class="form-control" name="title">
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
            <input id="show-title" type="text" class="form-control" name="review-show-title" readonly>
        </div>

        <div class="form-group">
            <label for="rating">Rating: </label>
            <input type="number" class="form-control" name="rating" min="1" max="10"> out of 10
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
        <tr>
            //use php to add the users reviews to rows
            <?php ?>
        </tr>
    </table>
</div>
</div>
</body>
</html>