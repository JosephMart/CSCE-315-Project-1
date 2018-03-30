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

// Get Data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $begin = $_POST['startDate'];
    $end = $_POST['endDate'];
}
list($result, $resultCounts) = GetDayData($begin, $end);
?>
<!DOCTYPE HTML>
<html>
    <head>
        <?php HtmlHeader('Day Chart') ?>
    </head>
    <body>
        <?php HtmlNavbar('charts'); ?>
        <div class="container">
            <h1>Day Chart</h1>

            <?php AnalysisTable($resultCounts); ?>

            <div id="chart_div" style="width: 800px; height: 500px;margin: auto;"></div>
            
            <?php StandardChartForm(); ?>
        </div>

        <script type="text/javascript">
            // DB data to JS
            var dbData = <?php echo json_encode($result) ?>;

            LoadGraph(dbData, function(date) {
                return moment(date).format('MM/DD/Y');
            });
        </script>
    </body>
</html>