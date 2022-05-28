<?php
    header('Content-Type: application/json');
    $test=json_decode(file_get_contents("php://input"), true);
    
    echo json_encode($test["user_id"]);
?>