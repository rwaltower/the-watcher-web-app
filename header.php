<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    

</head>
<body>
<script>
        
        function setReviewTitle(title) {
            $("#review-show-title").val(title);
        }
    </script>
<nav class="navbar navbar-default">
    <div class="container-fluid">
    <h2>Welcome, <?php echo $_SESSION['username']?>!</h2>
        <div class="navbar-header">
            <a class="navbar-brand" href="index.php">The Watcher</a>
        </div>

    <ul class="nav navbar-nav">
        <li><a href="index.php">Home</a></li>
        <li><a href="logout.php">Logout</a></li>

    </ul>
    </div>
</nav>