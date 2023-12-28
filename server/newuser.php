<?php
    session_start();
    if(isset($_POST)){
        $postDataString = file_get_contents("php://input");
        $postDataArray = json_decode($postDataString, true);
        if(isset($postDataArray["session"])){
            $_SESSION['user'] = $postDataArray["session"];
            echo "{\"Status\":\"Success\"}";
        } else {
            $rawData = file_get_contents("../database/datas.json");
            $existingData = json_decode($rawData, true);
            echo json_encode($existingData['staffs']);
        }
    }
?>