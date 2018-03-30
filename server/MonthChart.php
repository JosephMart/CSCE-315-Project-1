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
include('Actions.php');

// Get Data
extract($_POST);
list($result, $resultCounts) = GetMonthData($startDate, $endDate);
?>
<!DOCTYPE HTML>
<html>
    <head>
        <?php HtmlHeader('Month Chart'); ?>
    </head>
    <body>
        <?php HtmlNavbar('charts'); ?>
        <div class="container">
            <h1>Month Chart</h1>

            <?php AnalysisTable($resultCounts); ?>

            <div id="chart_div" style="width: 800px; height: 500px;margin: auto;"></div>

            <?php StandardChartForm(); ?>
        </div>

        <script type="text/javascript">
            // DB data to JS
            var dbData = <?php echo json_encode($result) ?>;

            LoadGraph(dbData, function(date) {
                return moment(date).format('MMMM Y');
            });
        </script>
    </body>
</html>