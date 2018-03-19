<?php
require_once("./modules/phpChart_Lite/conf.php");
?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>CSCE 313 Project 1</title>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="./main.css">
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="#">313 Project 1</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Table</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="charts.php">Charts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#">Numerical Analysis</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#">Admin</a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <?php
                        $pc0 = new C_PhpChartX(array(array(11, 9, 5, 12, 14)),'basic_chart0');
                        $pc0->set_animate(true);
                        $pc0->set_title(array('text'=>'Basic Chart Animated'));
                        $pc0->draw();
                    ?>
                </div>
                <div class="col-md-4">
                    <?php
                        $pc1 = new C_PhpChartX(array(array(11, 9, 5, 12, 14)),'basic_chart1');
                        $pc1->set_animate(true);
                        $pc1->set_title(array('text'=>'Basic Chart Animated'));
                        $pc1->draw();
                    ?>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            window.onload = function() {
                var elements = document.getElementsByClassName("pg_notify");

                for (var i = 0; i < elements.length; i++) {
                    elements[i].style.display = "none";
                }
            }
        </script>
    </body>
</html>