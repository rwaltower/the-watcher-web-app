<?php
session_start();

if(empty($_SESSION['loggedin'])) {
        header('Location: http://' . $_SERVER['HTTP_HOST'] . '/the-watcher-web-app-master/login.php');
        exit;
    }
require_once('db-connect.php');
    $shows = "";
    $reviews = "";

    $user= $_SESSION["user_id"];

    $query = "SELECT show_id FROM user_has_shows WHERE user_id = '$user'";
    $results = mysqli_query($connection, $query) or die(mysqli_error($connect));
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
            $show = "<tr class='active show'><td class='title'>" .$shows[0][$i]."<input id='watched' type='checkbox' name='watched' onclick='watchShow(".$shows[0][].")' value='".$shows[0][$i]."' checked/></td></tr>";

        } else if ($shows[1][$i] == false) {
            $show = "<tr class='show'><td class='title'>" .$shows[0][$i]."<input id='watched' type='checkbox' name='watched' onclick='watchShow(".$shows[0][].")' value='".$shows[0][$i]."'/></td></tr>";

        }
    }

    $query = "SELECT show_id FROM user_has_reviews WHERE user_id = '$user'";
    $results = mysqli_query($connection, $query) or die(mysqli_error($connect));
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
        $reviews = "<tr><td>".$reviews[0][$i]."</td><td>".$reviews[1][$i]."</td><td>".$reviews[2][$i]."</td></tr>";
    }

function watchShow($show) {
    $user= $_SESSION["user_id"];
    $sql = "SELECT id FROM shows WHERE id = '$show'";

    $show_id = $link->query($sql);

    $sql = "UPDATE user_has_shows SET watched = CASE WHEN watched = true THEN false WHEN watched = false THEN true ELSE watched END WHERE user_id = '$user', show_id = '$show_id'";

    $link->query($sql);
}


include_once('header.php');

?>

<div id="home">
<div id="shows" class="container">

    <table class="table">
        <caption>Shows</caption>

        <tbody>
        <tr>
            <th>Unwatched</th>
            <th class="active">Watched</th>
        </tr>
        </tbody>
        <tr>

        </tr>
    </table>

    <button type="button" class="btn btn-default"><a href="add-show.php">Add Show</button>
</div>
<br>
<div id="reviews" class="container">
    <table class="table">
        <caption>Reviews</caption>
        <tr>
            <th>Title</th>
            <th>Rating</th>
            <th>Comments</th>
        </tr>
    </table>
</div>
</div>
</body>
</html>