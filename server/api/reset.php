<?php
/*****************************************
** File:    Reset.php
** Project: CSCE 315 Project 1, Spring 2018
**
** Hit this endpoint with a DELETE request to clear
** the contents of PeopleCounts and reset increment
** index back to 1
**
***********************************************/

# Setup the logger
include('../logger.php');
$logger = new Logger();

# Return forbidden error code (403) if not a DELETE request
if ($_SERVER['REQUEST_METHOD'] != 'DELETE')
    http_response_code(403);

# Setup CommonMethods for query execution
$debug = false;
include('../CommonMethods.php');
$COMMON = new Common($debug);

// Delete users
$sql = "DELETE FROM `PeopleCounts`";
$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

// Reset AutoIncrement
$alter = 'ALTER TABLE `PeopleCounts` AUTO_INCREMENT = 1';
$rs = $COMMON->executeQuery($alter, $_SERVER["SCRIPT_NAME"]);

// Respond to request
$data = [
    "status" => "success"
];

$logger->info('PeopleCounts has been reset');
header('Content-Type: application/json');
echo json_encode($data);
?>