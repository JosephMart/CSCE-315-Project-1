<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="refresh" content="3">
        <title>CSCE 313 Project 1</title>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    </head>
    <body>
        <div class="container">
            <?php
                # Setup CommonMethods for query execution
                $debug = false;
                include('CommonMethods.php');
                $COMMON = new Common($debug);

                # Select all items in PeopleCounts for display
                $sql = "SELECT * FROM `PeopleCounts` ORDER BY `PeopleCounts`.`id` DESC";
                $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

                # Count number of items in PeopleCounts
                $countSql = 'SELECT COUNT(*) from `josephmart`.`PeopleCounts`';
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
                            <td>ID</td>
                            <td>Time</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            # Display table data
                            while($row = $rs->fetch(PDO::FETCH_ASSOC))
                                echo("<tr><td>".$row['id']."</td><td>".$row['time']."</td><td>\n");
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