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

# Setup CommonMethods for query execution
$debug = false;

# Flags for testing
$deleteStatus = false;
$addStatus = false;

include('CommonMethods.php');
$COMMON = new Common($debug);

// Delete users
$sql = "DELETE FROM `PeopleCounts`";
$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

// Reset AutoIncrement
$alter = 'ALTER TABLE `PeopleCounts` AUTO_INCREMENT = 1';
$rs = $COMMON->executeQuery($alter, $_SERVER["SCRIPT_NAME"]);

// Check count is 0
$sql = "SELECT COUNT(*) FROM `PeopleCounts`";
$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
$count = $rs->fetchColumn();

if ($count == 0) {
    $deleteStatus = true;
}

for ($x = 0; $x < 10; $x++) {
    $sql = "INSERT INTO `PeopleCounts` (`id`, `time`) VALUES (NULL, CURRENT_TIMESTAMP)";
    $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
}

// Check count is 10
$sql = "SELECT COUNT(*) FROM `PeopleCounts`";
$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
$count = $rs->fetchColumn();

if ($count == 10) {
    $addStatus = true;
}

// Respond with results
$data = [
    "delete" => $deleteStatus,
    "add" => $addStatus
];

header('Content-Type: application/json');
echo json_encode($data);
?>