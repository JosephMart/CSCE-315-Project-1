<?php
    // Simple password protection
    if (!isset($_COOKIE['password']) || $_COOKIE['password'] !== '1234') {
        header('Location: login.php');
        exit;
    }
    include('./CommonMethods.php');
    $COMMON = new Common($debug);

    if (isset($_POST["enter"])) {
        $sql = "INSERT INTO `PeopleCounts` (`id`, `time`, `entering`) VALUES (NULL, CURRENT_TIMESTAMP, 'true')";
        $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
    }

    if (isset($_POST["exit"])) {
        $sql = "INSERT INTO `PeopleCounts` (`id`, `time`, `entering`) VALUES (NULL, CURRENT_TIMESTAMP, 'false')";
        $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
    }

    if (isset($_POST["reset"])) {
        echo 'delete';
        // Delete users
        // $sql = "DELETE FROM `PeopleCounts`";
        // $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

        // // Reset AutoIncrement
        // $alter = 'ALTER TABLE `PeopleCounts` AUTO_INCREMENT = 1';
        // $rs = $COMMON->executeQuery($alter, $_SERVER["SCRIPT_NAME"]);
    }
?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>CSCE 315 Project 1|Admin</title>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="./main.css">

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment.min.js"></script>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="#">315 Project 1</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Table</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Charts
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="monthChart.php">Month</a>
                            <a class="dropdown-item" href="weekChart.php">Week</a>
                            <a class="dropdown-item" href="dayChart.php">Day</a>
                            <a class="dropdown-item" href="hourChart.php">Hour</a>
                        </div>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="admin.php">Admin</a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="container">
            <h1>Admin</h1>
            <div class="row">
                <div class="col-md-4">
                    <form class="form-inline" method="POST">
                        <input type="hidden" name="enter">
                        <button type="submit" class="btn btn-primary mb-2">Increment Entering</button>
                    </form>
                </div>
                <div class="col-md-4">
                    <form class="form-inline" method="POST">
                        <input type="hidden" name="exit">
                        <button type="submit" class="btn btn-primary mb-2">Increment Exit</button>
                    </form>
                </div>
                <div class="col-md-4">
                    <form class="form-inline" method="POST">
                        <input type="hidden" name="reset">
                        <button type="submit" class="btn btn-primary mb-2">Reset</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>