<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
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
        <li><a href="index.php/#shows">Shows</a></li>
        <li><a href="index.php/#reviews">Reviews</a></li>
        <li><a href="add-show.php">Add Show</a></li>
        <li><a href="add-review.php">Add Review</a></li>
    </ul>
    </div>
</nav>