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
        <?php HtmlHeader('Admin'); ?>
    </head>
    <body>
        <?php HtmlNavbar('admin'); ?>
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