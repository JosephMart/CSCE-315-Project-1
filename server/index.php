<?php
/*****************************************
** File:    index.php
** Project: CSCE 315 Project 1
** Date:    03/30/2018
**
**   This file display a table of the data along with
** entering/exiting counts since the start of recording
**
**
***********************************************/

include('Partials.php');
include('Actions.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <?php HtmlHeader('Table'); ?>
    </head>
    <body>
        <?php HtmlNavbar('table'); ?>
        <div class="container">
            <?php
                # Setup CommonMethods for query execution
                $debug = false;
                include_once('CommonMethods.php');
                $COMMON = new Common($debug);

                # Select all items in PeopleCounts for display
                $sql = "SELECT * FROM `PeopleCounts` ORDER BY `PeopleCounts`.`time` DESC LIMIT 100";
                $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
                $count = GetAllCounts();
            ?>
            <h1>People Counts</h1>
            <?php echo('<p>Number of Entering: ' . $count['entering'] . '</p>') ?>
            <?php echo('<p>Number of Leaving: ' . $count['leaving'] . '</p>') ?>
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