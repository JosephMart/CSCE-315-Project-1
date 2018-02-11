<?php
    include('../logger.php');
    $logger = new Logger();

    # Return 403 if response if no secret or not a POST request
    if (!array_key_exists('secret', $_POST) || $_SERVER['REQUEST_METHOD'] != 'POST') {
        http_response_code(403);
    }

    # Get secret in request
    $secret = (int) $_POST['secret'];

    if ($secret == 69) {
        $debug = false;
        include('../CommonMethods.php');
        $COMMON = new Common($debug);

        // Increment PeopleCounts
        $sql = "INSERT INTO `josephmart`.`PeopleCounts` (`id`, `time`) VALUES (NULL, CURRENT_TIMESTAMP)";
        $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

        // Respond to request
        $data = [
            "status" => "success"
        ];

        header('Content-Type: application/json');
        echo json_encode($data);
    } else {
        http_response_code(403);
    }
?>