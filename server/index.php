<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>CSCE 313 Counts</title>

        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="container">
            <?php
                $debug = false;
                include('CommonMethods.php');
                $COMMON = new Common($debug);

                // Select all for display
                $sql = "SELECT * FROM `PeopleCounts`";
                $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
            ?>
            <h1>People</h1>
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
                            while($row = $rs->fetch(PDO::FETCH_ASSOC))
                            {
                                echo("<tr><td>".$row['id']."</td><td>".$row['time']."</td><td>\n");
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>