<?php
    if(isset($_POST)){
        $postDataString = file_get_contents("php://input");
        $postDataArray = json_decode($postDataString, true);
        $jsonString = stripslashes($postDataString);
        $userFile = fopen("database/datas.json", 'w+');
        fwrite($userFile, $jsonString);
        fclose($userFile);
        echo "{\"Entry\":true}";
    }
?>