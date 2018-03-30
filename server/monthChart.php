<?php
/*****************************************
** File:    MonthChart.php
** Project: CSCE 315 Project 1
** Date:    03/30/2018
**
**   This file display a graph and data on an month
** increment
**
**
***********************************************/

include('Partials.php');
?>
<!DOCTYPE HTML>
<html>
    <head>
        <?php HtmlHeader('Month Chart') ?>
        <?php
            // Execute Query
            include('./CommonMethods.php');
            $COMMON = new Common(false);

            $sql = "SELECT 
                    COUNT(DISTINCT id) AS count, 
                    SUM(
                        CASE WHEN entering = 'true' THEN 1 ELSE 0 END
                    ) AS going_in, 
                    SUM(
                        CASE WHEN entering = 'false' THEN 1 ELSE 0 END
                    ) AS going_out, 
                    CONCAT(YEAR(time),'-',MONTH(time)) AS date 
                FROM 
                    PeopleCounts";

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $begin = $_POST['start_date'];
                $end = $_POST['end_date'];
                $sql = $sql.' '."WHERE time >= '".$begin."' AND time <= '".$end."'";
            }

            $sql = $sql.' GROUP BY date';
            $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
            $result = $rs->fetchAll();

            // Analysis queries
            $countSql = "SELECT 
                SUM(going_in) as totalIn, 
                AVG(going_in) as averageIn, 
                MIN(going_in) as minIn, 
                MAX(going_in) as maxIn,
                SUM(going_out) as totalOut, 
                AVG(going_out) as averageOut, 
                MIN(going_out) as minOut, 
                MAX(going_out) as maxOut
            FROM (".$sql.") as sub_q";
            $rs = $COMMON->executeQuery($countSql, $_SERVER["SCRIPT_NAME"]);
            $resultCounts = $rs->fetchAll()[0];
        ?>
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
                    <li class="nav-item dropdown active">
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
            <h1>Month Chart</h1>

            <h3>Entering</h3>

            <table class="table">
                <thead>
                    <tr>
                        <th>Mean</th>
                        <th>Median</th>
                        <th>Mode</th>
                        <th>Max</th>
                        <th>Min</th>
                        <th>Count</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $resultCounts["averageIn"] ?></td>
                        <td>-1</td>
                        <td>-1</td>
                        <td><?php echo $resultCounts["maxIn"] ?></td>
                        <td><?php echo $resultCounts["minIn"] ?></td>
                        <td><?php echo $resultCounts["totalIn"] ?></td>
                    </tr>
                </tbody>
            </table>

            <h3>Leaving</h3>

            <table class="table">
                <thead>
                    <tr>
                        <th>Mean</th>
                        <th>Median</th>
                        <th>Mode</th>
                        <th>Max</th>
                        <th>Min</th>
                        <th>Count</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $resultCounts["averageOut"] ?></td>
                        <td>-1</td>
                        <td>-1</td>
                        <td><?php echo $resultCounts["maxOut"] ?></td>
                        <td><?php echo $resultCounts["minOut"] ?></td>
                        <td><?php echo $resultCounts["totalOut"] ?></td>
                    </tr>
                </tbody>
            </table>

            <div id="chart_div" style="width: 800px; height: 500px;margin: auto;"></div>
            
            <form action="" method="post">
                <div class="form-row">
                    <div class="form-group col-md-3"></div>
                    <div class="form-group col-md-3">
                        <label for="start_date">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" placeholder="" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="end_date">End Date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" placeholder="" required>
                    </div>
                    <div class="form-group col-md-3"></div>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>

        <script type="text/javascript">
            // DB data to JS
            var db_data = <?php echo json_encode($result) ?>;
            var graph_data = [['Date Times', 'Entering', 'Exiting']];
            var row = {};

            for (var i = 0; i < db_data.length; i++) {
                row = db_data[i];
                graph_data.push([moment(row.date).format('MMMM Y'), parseInt(row.going_in, 10), parseInt(row.going_out, 10)]);
            }

            // Get Current range dates
            var start_date = graph_data[1][0];
            var end_date = graph_data[graph_data.length - 1][0];

            // Google Charts setup
            google.charts.load('current', {'packages':['corechart', 'bar']});
            google.charts.setOnLoadCallback(drawMonthView);
        </script>
    </body>
</html>