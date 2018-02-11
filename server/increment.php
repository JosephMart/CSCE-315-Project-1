<?php
    $debug = false;
    include('CommonMethods.php');
    $COMMON = new Common($debug);

    // Increpent PeopleCounts
    $sql = "INSERT INTO `josephmart`.`PeopleCounts` (`id`, `time`) VALUES (NULL, CURRENT_TIMESTAMP)";
    $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

    // Respond to post request
    $data = [
        "status" => "success",
        "query" => $sql
    ];
    header('Content-Type: application/json');
    echo json_encode($data);
?>