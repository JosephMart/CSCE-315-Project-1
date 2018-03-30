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
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $begin = $_POST['startDate'];
    $end = $_POST['endDate'];
}
list($result, $resultCounts) = GetMonthData($begin, $end);

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
                return moment(date).format('MMMM Y');
            });
        </script>
    </body>
</html>