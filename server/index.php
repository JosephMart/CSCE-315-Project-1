<?php
/*****************************************
** File:    index.php
** Project: CSCE 315 Project 1
** Date:    03/30/2018
**
**   This file display a table of the data along with
** entering/exiting counts since the start of recording
**
**
***********************************************/

include('Partials.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <?php HtmlHeader('Table') ?>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="#">315 Project 1</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Table</a>
                    </li>
                    <li class="nav-item dropdown ">
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
                    <li class="nav-item">
                        <a class="nav-link" href="admin.php">Admin</a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="container">
            <?php
                # Setup CommonMethods for query execution
                $debug = false;
                include('CommonMethods.php');
                $COMMON = new Common($debug);

                # Select all items in PeopleCounts for display
                $sql = "SELECT * FROM `PeopleCounts` ORDER BY `PeopleCounts`.`time` DESC LIMIT 100";
                $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

                # Count number of items in PeopleCounts
                $countSql = "SELECT
                    SUM(
                        CASE WHEN entering = 'true' THEN 1 ELSE 0 END
                    ) AS entering,
                    SUM(
                        CASE WHEN entering = 'false' THEN 1 ELSE 0 END
                    ) AS leaving
                    FROM `PeopleCounts`";
                $countRs = $COMMON->executeQuery($countSql, $_SERVER["SCRIPT_NAME"]);
                $count = $countRs->fetchAll()[0];
            ?>
            <h1>People Counts</h1>
            <?php echo('<p>Number of Entering: ' . $count['entering'] . '</p>') ?>
            <?php echo('<p>Number of Leaving: ' . $count['leaving'] . '</p>') ?>
            <p id="counts" class="font-italic font-weight-light" style="font-size:10px;"></p>
            
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <td>Time</td>
                            <td>Entering</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            # Display table data
                            while($row = $rs->fetch(PDO::FETCH_ASSOC))
                                echo("<tr><td>".$row['time']."</td><td>".$row['entering']."</td><tr>\n");
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <script>
            // Set the time the table was last updated
            document.getElementById("counts").innerHTML = new Date();
        </script>
    </body>
</html>