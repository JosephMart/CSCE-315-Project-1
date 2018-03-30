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
include('../Logger.php');
include('../Actions.php');
$logger = new Logger();

# Return 403 if response if no secret or not a POST request
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    http_response_code(403);
}

# Get secret in request
$entering = 'true';

if (array_key_exists('entering', $_POST)) {
    $entering = $_POST['entering'];
}

Increment($entering);
# Setup CommonMethods for query execution
$logger->info("Increment request entering: ".$entering);

// Respond to request
$data = [
    "status" => "success"
];

header('Content-Type: application/json');
echo json_encode($data);
?>