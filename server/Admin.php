<?php
/*****************************************
** File:    Admin.php
** Project: CSCE 315 Project 1
** Date:    03/30/2018
**
**   This file is a basic administrative page
**
**
***********************************************/

include('Partials.php');

// Simple password protection
if (!isset($_COOKIE['password']) || $_COOKIE['password'] !== '1234') {
    header('Location: Login.php');
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
        <?php HtmlHeader('Admin') ?>
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
                            <a class="dropdown-item" href="MonthChart.php">Month</a>
                            <a class="dropdown-item" href="WeekChart.php">Week</a>
                            <a class="dropdown-item" href="DayChart.php">Day</a>
                            <a class="dropdown-item" href="HourChart.php">Hour</a>
                        </div>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="Admin.php">Admin</a>
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