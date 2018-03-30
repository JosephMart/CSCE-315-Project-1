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

// Get Data
$selectedDate = 'CURRENT_DATE()';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $selectedDate = "'".$_POST['selectedDate']."'";
}
list($result, $resultCounts) = GetHourData($selectedDate);
?>
<!DOCTYPE HTML>
<html>
    <head>
        <?php HtmlHeader('Today Chart') ?>
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
            var dbData = <?php echo json_encode($result) ?>;

            LoadGraph(dbData, function(date) {
                return moment(date).format('hh:mm a');
            });
        </script>
    </body>
</html>