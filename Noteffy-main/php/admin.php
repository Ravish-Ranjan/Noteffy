<?php

    function allowAdmin(&$jsonData){
        if(!isset($_GET["op"])){
            return;
        }
        header("Content-Type: application/json;charset=utf-8");
        $resp = array();
        if ($_GET["op"]=="chadmin") {
            $userNumber = getUserNumber();
            for ($i = 0; $i < count($jsonData["Users"]); $i++) {
                if ($jsonData["Users"][$i]["identifier"] == $userNumber) {
                    $resp["not"] = $jsonData["Users"][$i]["User_Name"];
                    if(!$jsonData["Users"][$i]["Type"]){
                        $resp["Message"] = "admin success";
                    }
                    else{
                        $resp["Message"] = "admin present";
                    }
                    echo json_encode($resp);
                    file_put_contents("../data/Details.json", json_encode($jssonData));die();
                }
            }
            $resp["Message"] = "failure";
            echo json_encode($resp);
        }
        die();
    }
?>