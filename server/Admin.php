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
include('Actions.php');

// Simple password protection
if (!isset($_COOKIE['password']) || $_COOKIE['password'] !== '1234') {
    header('Location: Login.php');
    exit;
}

if (isset($_POST["enter"])) {
    Increment('true');
}

if (isset($_POST["exit"])) {
    Increment('false');
}

if (isset($_POST["reset"])) {
    ResetDb();
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