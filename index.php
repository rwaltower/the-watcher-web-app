<?php
session_start();
if(!$_SESSION['loggedin']) {
        header('Location: http://' . $_SERVER['HTTP_HOST'] . '/the-watcher-web-app/login.php');
        exit;
    }
require_once('db-connect.php');
    $show_titles = array();
    $show_watched_status = array();
    $show_reviewed_status = array();
    $user= $_SESSION["user_id"];
    $disabled = "";
    $query = "SELECT show_id FROM user_has_shows WHERE user_id = '$user'";
    $results = mysqli_query($connection, $query) or die(mysqli_error($connect));
    if(mysqli_num_rows($results)) {
        $show_ids = mysqli_fetch_all($results);
        mysqli_free_result($results);
        foreach($show_ids as $id) {
            $this_id = $id[0];
            $query = "SELECT title FROM shows WHERE id = '$this_id'";
            $result = mysqli_query($connection, $query) or die(mysqli_error($connect));
            $show = mysqli_fetch_row($result);
            if(mysqli_num_rows($result)) {
                array_push($show_titles, $show[0]);
                $query = "SELECT watched, reviewed FROM user_has_shows WHERE show_id = '$this_id'";
                $result1 = mysqli_query($connection, $query) or die(mysqli_error($connect));
                $user_show = mysqli_fetch_row($result1);
                if(mysqli_num_rows($result1)) {
                    array_push($show_watched_status, $user_show[0]);
                    array_push($show_reviewed_status, $user_show[1]);
                }
                
            }
        
        }
    }
    
    $shows = array($show_titles, $show_watched_status, $show_reviewed_status);
    for($i = 0; $i < count($show_ids); $i++) {

        if($shows[1][$i] == true && $shows[2][$i] == true) {
            $user_shows .= "<tr><td>".$shows[0][$i]."</td><td>Watched</td><td>Reviewed</td></tr>";
        } else if ($shows[1][$i] == true && $shows[2][$i] == false) {
            $user_shows .= "<tr><td>".$shows[0][$i]."</td><td>Watched</td><td><button type='button' class='btn btn-default' data-toggle='modal' data-target='#add-review' onClick='setReviewTitle(\"".$shows[0][$i]."\")'>Add Review</button></td></tr>";
            } else {
                $encoded_show = htmlentities($shows[0][$i], ENT_QUOTES, 'UTF-8');
            $user_shows .= "<tr><td class='title'>".$shows[0][$i]."</td><td><a href='index.php?watched_show=".$encoded_show."'><button class='btn btn-default'>Add To Watched</button></a></td><td><button type='button' class='btn btn-default' data-toggle='modal' data-target='#add-review' onClick='setReviewTitle(\"".($shows[0][$i])."\")' disabled>Add Review</button></td></tr>";
        }
    }
    $review_titles = array();
    $review_ratings = array();
    $review_comments = array();
    
    $query = "SELECT show_id FROM user_has_reviews WHERE user_id = '$user'";
    $results = mysqli_query($connection, $query) or die(mysqli_error($connect));
    
    if(mysqli_num_rows($results)) {
        $show_ids = mysqli_fetch_all($results);
        mysqli_free_result($results);
        foreach($show_ids as $id) {
            $this_id = $id[0];
            $query = "SELECT title FROM shows WHERE id = '$this_id'";
            $result = mysqli_query($connection, $query) or die(mysqli_error($connect));
            $show = mysqli_fetch_row($result);
            if(mysqli_num_rows($result)){
                array_push($review_titles, $show[0]);
                $query = "SELECT rating, comments FROM user_has_reviews WHERE show_id = '$this_id'";
                $results = mysqli_query($connection, $query) or die(mysqli_error($connect));
                $review = mysqli_fetch_row($results);
                if(mysqli_num_rows($results)) {
                    array_push($review_ratings, $review[0]);
                    array_push($review_comments, $review[1]);
                }
                
            }
            
        }
    }
    $reviews = array($review_titles, $review_ratings, $review_comments);
    for($i = 0; $i < count($review_titles); $i++) {
        $user_reviews .= "<tr><td>".$reviews[0][$i]."</td><td>".$reviews[1][$i]."/10</td><td>".$reviews[2][$i]."</td></tr>";
    }
    if (isset($_GET['watched_show'])){
        $watched_show = $_GET['watched_show'];
        $watched_show = addslashes($watched_show);
        $query = "SELECT id FROM shows WHERE title = '$watched_show'";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connect));
        $show = mysqli_fetch_row($result);
        $this_show_id = $show[0];
        if(mysqli_num_rows($result)) {
            $query
             = "UPDATE user_has_shows SET watched = true WHERE user_id = '$user' AND show_id = '$this_show_id'";
             $result = mysqli_query($connection, $query) or die(mysqli_error($connect));
             if($result) {
                 //Redirect to home page
                header('Location: http://' . $_SERVER['HTTP_HOST'] . '/the-watcher-web-app/index.php');
             }
        }

    }
    
    
    
include_once('header.php');

?>

<div id="home">
<div id="shows" class="container">
    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#add-show">Add Show</button>
    <table class="table table-striped table-bordered">
        <caption><h2>Shows</h2></caption>

        <tbody>
        <?php echo $user_shows ?>

        </tbody>
    </table>

    
</div>
<br>

<div id="add-show" class="modal fade" role="dialog">
<div class="modal-dialog">
<div class="modal-content">

<?php

require_once('db-connect.php');
$theerror = "";
$user = $_SESSION['user_id'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
if(empty(trim($_POST['title']))) {
        $title_err = "Must add show title";
        
} else {
    $title = trim($_POST['title']);
    $title = addslashes($title);
    
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
    $query = "SELECT id FROM shows WHERE title='$title'";
            
    $result = mysqli_query($connection, $query) or die(mysqli_error($connect));
    $show = mysqli_fetch_object($result);
    $show_id = $show->id;
    $query = "INSERT INTO user_has_shows (show_id, user_id, watched, reviewed) VALUES ('$show_id','$user','$watched', false)";
    $result = mysqli_query($connection, $query);
    if($result) {
        header('Location: http://' . $_SERVER['HTTP_HOST'] . '/the-watcher-web-app/index.php');
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
<h2 class="modal-title">Add Show</h2>
            <?php echo $theerror ?>
    <div class="modal-body">
        <form id="add-show-form" class="form-group" method="post">
            <div class="form-group">
                <label for="title">Title: </label>
                <input type="text" class="form-control" name="title" required>
            </div>
            <div class="form-group">
            <label>Have you watched this show?</label>

            <div class="btn-group">
                <label class="btn btn-secondary">
                    <input type="radio" class="form-control" name="watched"value="yes" > Yes
                </label>
                <label class="btn btn-secondary">
                    <input type="radio" class="form-control" name="watched" value="no" checked> No
                </label>
            </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-default">Add</button>
            </div>
    </div>
    </form>
    </div>
    </div>
    </div>
</div>

<div id="add-review" class="modal fade" role="dialog">
<div class="modal-dialog">
<div class="modal-content">
<?php

require_once('db-connect.php');
$theerror = "";
$user = $_SESSION["user_id"];
$title = $_POST["review-show-title"];
$title = addslashes($title);

    if(empty(trim($_POST["rating"]))) {
        $rating_err = "You must rate the show out of 10";
    } else {
        $rating = trim($_POST['rating']);
    }

    if(empty(trim($_POST["comments"]))) {
        $comments = " ";
    } else {
        $comments = trim($_POST['comments']);
        $comments = addslashes($comments);
    }


    if(empty($rating_err)) {
        $query = "SELECT id FROM shows WHERE title = '$title'";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connect));
        $show = mysqli_fetch_object($result);
        
        $show_id = $show->id;
            
        $query = "INSERT INTO user_has_reviews (show_id, user_id, rating, comments) VALUES ('$show_id', '$user', '$rating', '$comments')";
        
        $result = mysqli_query($connection, $query);
        
        if ($result) {
            
            $query = "UPDATE user_has_shows SET reviewed = true WHERE user_id = '$user' AND show_id = '$show_id'";
            
             $result = mysqli_query($connection, $query) or die(mysqli_error($connect));
             if($result) {
                 //Redirect to home page
                header('Location: http://' . $_SERVER['HTTP_HOST'] . '/the-watcher-web-app/index.php');
                 
             }
                
            } else{
                echo "Something went wrong. Please try again later.";
            }
            
        }
    

include_once('header.php');


?>

    <h2 class="modal-title">Add Review</h2>
    <div class="modal-body">
    <form id="add-review-form" class="form-group" method="post">
        <div class="form-group">
        <input id="review-show-title" type="text" class="form-control" name="review-show-title" value="" readonly>
        </div>

        <div class="form-group">
            <label for="rating">Rating (out of 10): </label>
            <input type="number" class="form-control" name="rating" min="1" max="10" required>
        </div>
        <div class="form-group">
            <label for="comments">Comments: </label>
            <input type="text" class="form-control" name="comments">
        </div>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-default">Add</button>
        </div>
    </form>
    </div>

</div>
</div>
</div>

<div id="reviews" class="container">
    <table class="table table-striped table-bordered">
        <caption><h2>Reviews</h2></caption>
        <thead>
        <tr>
            <th>Title</th>
            <th>Rating</th>
            <th>Comments</th>
        </tr>
        </thead>
        <?php echo $user_reviews ?>
    </table>
</div>
</div>
</body>
</html>