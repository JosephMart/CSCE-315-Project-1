<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>CSCE 315 Project 1</title>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="./main.css">
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment.min.js"></script>

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
                    PeopleCounts 
                GROUP BY date";

            $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
            $result = $rs->fetchAll();
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
                    <li class="nav-item active">
                        <a class="nav-link" href="charts.php">Charts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#">Numerical Analysis</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#">Admin</a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="container">
            <div id="chart_div" style="width: 800px; height: 500px;margin: auto;"></div>
            
            <form action="">
                <div class="form-row">
                    <div class="form-group col-md-3"></div>
                    <div class="form-group col-md-3">
                        <label for="inputEmail4">Start Date</label>
                        <input type="date" class="form-control" id="start_date" placeholder="">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputPassword4">End Date</label>
                        <input type="date" class="form-control" id="end_date" placeholder="">
                    </div>
                    <div class="form-group col-md-3"></div>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                </form>
        </div>

        <script type="text/javascript">
            // Google Charts setup
            google.charts.load('current', {'packages':['corechart', 'bar']});
            google.charts.setOnLoadCallback(drawStuff);

            // DB
            var db_data = <?php echo json_encode($result) ?>;
            var graph_data = [['Date Times', 'Entering', 'Exiting']];
            var row = {};

            for (var i = 0; i < db_data.length; i++) {
                row = db_data[i];
                graph_data.push([moment(row.date).format('MMMM  Y'), parseInt(row.going_in, 10), parseInt(row.going_out, 10)]);
            }
            var start_date = graph_data[1][0];
            var end_date = graph_data[graph_data.length - 1][0];

            console.log(graph_data);

            function drawStuff() {
                var chartDiv = document.getElementById('chart_div');
                var data = google.visualization.arrayToDataTable(graph_data);

                var materialOptions = {
                    width: 900,
                    chart: {
                        title: 'Rec Center Counts',
                        subtitle: start_date + ' - ' + end_date
                    },
                    series: {
                        0: { axis: 'Entering' }, // Bind series 0 to an axis named 'distance'.
                        1: { axis: 'Exiting' } // Bind series 1 to an axis named 'brightness'.
                    },
                    axes: {
                        y: {
                            distance: {label: 'Number of People'}, // Left y-axis.
                            brightness: {side: 'right', label: 'Date Time'} // Right y-axis.
                        }
                    }
                };

                function drawMaterialChart() {
                    var materialChart = new google.charts.Bar(chartDiv);
                    materialChart.draw(data, google.charts.Bar.convertOptions(materialOptions));
                }

                drawMaterialChart();
            };
        </script>
    </body>
</html>