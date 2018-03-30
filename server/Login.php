<?php
/*****************************************
** File:    Login.php
** Project: CSCE 315 Project 1
** Date:    03/30/2018
**
**   This file display a basic login page and
** sets the cookies so that a user can stay
** logged in for 30 days
**
**
***********************************************/

include('Partials.php');

if (isset($_POST['password']) && $_POST['password'] == '1234') {
    setcookie("password", '1234', strtotime('+30 days'));
    header('Location: Admin.php');
    exit;
}
?>
<!DOCTYPE HTML>
<html>
    <head>
        <?php HtmlHeader('Login') ?>
    </head>
    <body>
        <div class="container">
            <form class="form-signin" method="POST">
                <h2 class="form-signin-heading">Enter Password</h2>
                <input type="password" id="inputPassword" class="form-control" placeholder="Password" name="password" required>
                <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
            </form>
        </div>
    </body>
</html>