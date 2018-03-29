<?php
    if (isset($_POST['password']) && $_POST['password'] == '1234') {
        setcookie("password", '1234', strtotime('+30 days'));
        header('Location: admin.php');
        exit;
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>CSCE 315 Project 1|Login</title>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="./main.css">
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