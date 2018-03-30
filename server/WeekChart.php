<?php
/*****************************************
** File:    WeekChart.php
** Project: CSCE 315 Project 1
** Date:    03/30/2018
**
**   This file display a graph and data on an week
** increment
**
**
***********************************************/

include('Partials.php');
include('Actions.php');

// Get data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $begin = $_POST['startDate'];
    $end = $_POST['endDate'];
}

list($result, $resultCounts) = GetWeekData($begin, $end);
?>
<!DOCTYPE HTML>
<html>
    <head>
        <?php HtmlHeader('Week Chart') ?>
    </head>
    <body>
        <?php HtmlNavbar('charts'); ?>
        <div class="container">
            <h1>Week Chart</h1>

            <?php AnalysisTable($resultCounts); ?>

            <div id="chart_div" style="width: 800px; height: 500px;margin: auto;"></div>
            
            <form action="" method="post">
                <div class="form-row">
                    <div class="form-group col-md-3"></div>
                    <div class="form-group col-md-3">
                        <label for="startDate">Start Date</label>
                        <input type="date" class="form-control" id="startDate" name="startDate" placeholder="" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="endDate">End Date</label>
                        <input type="date" class="form-control" id="endDate" name="endDate" placeholder="" required>
                    </div>
                    <div class="form-group col-md-3"></div>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>

        <script type="text/javascript">
            // DB data to JS
            var dbData = <?php echo json_encode($result) ?>;

            LoadGraph(dbData, function(date) {
                d = date.split('-');
                year = parseInt(d[0], 10);
                week = parseInt(d[1], 10) + 1;
                return moment().day("Sunday").year(year).week(week).format('MM/DD/Y');
            });
        </script>
    </body>
</html>