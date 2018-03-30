<?php
/*****************************************
** File:    HourChart.php
** Project: CSCE 315 Project 1
** Date:    03/30/2018
**
**   This file display a graph and data on an hourly
** increment
**
**
***********************************************/

include('Partials.php');
include('Actions.php');
?>
<!DOCTYPE HTML>
<html>
    <head>
        <?php HtmlHeader('Today Chart') ?>

        <?php
            // Get Data
            $selectedDate = 'CURRENT_DATE()';
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $selectedDate = "'".$_POST['selectedDate']."'";
            }
            list($result, $resultCounts) = GetHourData($selectedDate);
        ?>
    </head>
    <body>
        <?php HtmlNavbar('charts'); ?>
        <div class="container">
            <h1>Today Chart</h1>
            
            <?php AnalysisTable($resultCounts); ?>

            <div id="chart_div" style="width: 800px; height: 500px;margin: auto;"></div>
            
            <form action="" method="post">
                <div class="form-row">
                    <div class="form-group col-md-4"></div>
                    <div class="form-group col-md-4">
                        <label for="selectedDate">Date</label>
                        <input type="date" class="form-control" id="selectedDate" name="selectedDate" placeholder="" required>
                    </div>
                    <div class="form-group col-md-4"></div>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>

        <script type="text/javascript">
            // DB data to JS
            var db_data = <?php echo json_encode($result) ?>;
            var resultCounts = <?php echo json_encode($resultCounts) ?>;
            var graph_data = [['Date Times', 'Entering', 'Exiting']];
            var row = {};
            

            for (var i = 0; i < db_data.length; i++) {
                row = db_data[i];
                graph_data.push([moment(row.date).format('hh:mm a'), parseInt(row.going_in, 10), parseInt(row.going_out, 10)]);
            }
            console.log(resultCounts);
            // Get Current range dates
            var start_date = graph_data[1][0];
            var end_date = graph_data[graph_data.length - 1][0];

            // Google Charts setup
            google.charts.load('current', {'packages':['corechart', 'bar']});
            google.charts.setOnLoadCallback(drawMonthView);
        </script>
    </body>
</html>