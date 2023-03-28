<?php
    function checkAdmin(&$jsonData){
        if(!isset($_GET["op"]) || $_GET["op"]!="checkadmin"){
            return;
        }
        header("Content-Type: application/json;charset=utf-8");
        $resp = array();
        if ($_GET["op"]=="checkadmin") {
            $userNumber = getUserNumber();
            for ($i = 0; $i < count($jsonData["Users"]); $i++) {
                if ($jsonData["Users"][$i]["identifier"] == $userNumber) {
                    $resp["not"] = $jsonData["Users"][$i]["User_Name"];
                    if($jsonData["Users"][$i]["Type"]){
                        $resp["Message"] = "admin true";
                    }
                    else{
                        $resp["Message"] = "admin false";
                    }
                    echo json_encode($resp);die();
                }
            }
            $resp["Message"] = "user does not exist";
            echo json_encode($resp);
        }
        die();
    }
    function allowAdmin(&$jsonData){
        if(!isset($_GET["op"]) || $_GET["op"]!="chadmin"){
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
                        $jsonData["Users"][$i]["Type"] = true;
                    }
                    else{
                    $resp["Message"] = "admin present";
                    }
                    echo json_encode($resp);
                    file_put_contents("../data/Details.json", json_encode($jsonData));die();
                }
            }
            $resp["Message"] = "failure";
            echo json_encode($resp);
        }
        die();
    }
?>