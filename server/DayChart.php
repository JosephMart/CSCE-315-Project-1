<?php
/*****************************************
** File:    DayChart.php
** Project: CSCE 315 Project 1
** Date:    03/30/2018
**
**   This file display a graph and data on an day
** increment
**
**
***********************************************/

include('Partials.php');
include('Actions.php');
include_once('./CommonMethods.php');
?>
<!DOCTYPE HTML>
<html>
    <head>
        <?php HtmlHeader('Day Chart') ?>

        <?php
            $COMMON = new Common(false);

            $sql = "SELECT 
                    COUNT(DISTINCT id) AS count, 
                    SUM(
                        CASE WHEN entering = 'true' THEN 1 ELSE 0 END
                    ) AS going_in, 
                    SUM(
                        CASE WHEN entering = 'false' THEN 1 ELSE 0 END
                    ) AS going_out, 
                    CONCAT(YEAR(time),'-',MONTH(time),'-',DAY(time)) AS date 
                FROM 
                    PeopleCounts";

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $begin = $_POST['start_date'];
                $end = $_POST['end_date'];
                $sql = $sql." WHERE time >= '".$begin."' AND time <= '".$end."'";
            }

            $sql = $sql." GROUP BY date";

            $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
            $result = $rs->fetchAll();

            $resultCounts = AnalyzeQuery($sql);
        ?>
    </head>
    <body>
        <?php HtmlNavbar('charts'); ?>
        <div class="container">
            <h1>Day Chart</h1>

            <?php AnalysisTable($resultCounts); ?>

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
                graph_data.push([moment(row.date).format('MM/DD/Y'), parseInt(row.going_in, 10), parseInt(row.going_out, 10)]);
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