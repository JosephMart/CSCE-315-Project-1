<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="refresh" content="1">
        <title>CSCE 315 Project 1</title>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="./main.css">
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="#">313 Project 1</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Table</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="charts.php">Charts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Numerical Analysis</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Admin</a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="container">
            <?php
                # Setup CommonMethods for query execution
                $debug = false;
                include('CommonMethods.php');
                $COMMON = new Common($debug);

                # Select all items in PeopleCounts for display
                $sql = "SELECT * FROM `PeopleCounts` ORDER BY `PeopleCounts`.`time` DESC";
                $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

                # Count number of items in PeopleCounts
                $countSql = 'SELECT COUNT(*) from `PeopleCounts`';
                $countRs = $COMMON->executeQuery($countSql, $_SERVER["SCRIPT_NAME"]);
                $count = $countRs->fetchColumn();
            ?>
            <h1>People Counts</h1>
            <?php echo('<p>Number of People: ' . $count . '</p>') ?>
            <p id="counts" class="font-italic font-weight-light" style="font-size:10px;"></p>
            
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <td>Time</td>
                            <td>Entering</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            # Display table data
                            while($row = $rs->fetch(PDO::FETCH_ASSOC))
                                echo("<tr><td>".$row['time']."</td><td>".$row['entering']."</td><tr>\n");
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <script>
            // Set the time the table was last updated
            document.getElementById("counts").innerHTML = new Date();
        </script>
    </body>
</html>