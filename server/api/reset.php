<?php
    include('../logger.php');
    $logger = new Logger();

    $secret = (int) $_POST['secret'];

    if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
        $debug = false;
        include('../CommonMethods.php');
        $COMMON = new Common($debug);

        // Delete users
        $sql = "DELETE FROM `josephmart`.`PeopleCounts`";
        $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

        // Reset AutoIncrement
        $alter = 'ALTER TABLE `josephmart`.`PeopleCounts` AUTO_INCREMENT = 1';
        $rs = $COMMON->executeQuery($alter, $_SERVER["SCRIPT_NAME"]);

        // Respond to request
        $data = [
            "status" => "success",
            "query" => $sql
        ];

        $logger->info('data has been reset');
        header('Content-Type: application/json');
        echo json_encode($data);
    } else {
        http_response_code(406);
    }
?>