<?php
/*****************************************
** File:    Increment.php
** Project: CSCE 315 Project 1, Spring 2018
**
** Hit this endpoint with a POST request with secret
** to increment PeopleCount by 1
**
***********************************************/

# Setup the logger
include('../logger.php');
$logger = new Logger();

# Return 403 if response if no secret or not a POST request
if (!array_key_exists('secret', $_POST) || $_SERVER['REQUEST_METHOD'] != 'POST') {
    http_response_code(403);
}

# Get secret in request
$secret = (int) $_POST['secret'];
$entering = 'true';

if (array_key_exists('entering', $_POST)) {
    $entering = $_POST['entering'];
}

if ($secret == 69) {
    # Setup CommonMethods for query execution
    $debug = false;
    include('../CommonMethods.php');
    $COMMON = new Common($debug);
    $logger->info("Increment request entering: ".$entering);

    // Increment PeopleCounts
    $sql = "INSERT INTO `PeopleCounts` (`id`, `time`, `entering`) VALUES (NULL, CURRENT_TIMESTAMP,".$entering.")";
    $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

    // Respond to request
    $data = [
        "status" => "success"
    ];

    header('Content-Type: application/json');
    echo json_encode($data);
} else {
    http_response_code(406);
}
?>