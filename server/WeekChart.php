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
extract($_POST);
list($result, $resultCounts) = GetWeekData($startDate, $endDate);
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
            <?php StandardChartForm(); ?>
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