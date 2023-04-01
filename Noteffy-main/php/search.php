<?php
include "hash.php";
include "initial.php";
include "priority_Calc.php";

header("Content-Type:application/json;character=Utf-8");
$resp = array();
$data = file_get_contents("../data/Data.json");
$data = json_decode($data, true);
$resp['data'] = array();
if (isset($_GET['term'])) {
    $user = getUserNumber();
    $pattern = $_GET['term'];
    for ($i = 0; $i < count($data["User_Data"]); $i++) {
        if ($data["User_Data"][$i]["identifier"] == $user) {
            for ($j = 0; $j < count($data["User_Data"][$i]["Notes"]); $j++) {
                if (preg_match("/$pattern/i", ($data["User_Data"][$i]["Notes"][$j]["Content"]))) {
                    array_push($resp['data'], $data["User_Data"][$i]["Notes"][$j]);
                    $resp['index_j'] = $j;
                }
            }
        }
    }
    echo json_encode($resp);
}
else if(isset($_GET['task_term'])){
    $user = getUserNumber();
    $pattern = $_GET['task_term'];
    for ($i = 0; $i < count($data["User_Data"]); $i++) {
        if ($data["User_Data"][$i]["identifier"] == $user) {
            for ($j = 0; $j < count($data["User_Data"][$i]["To-do"]); $j++) {
                if (preg_match("/$pattern/i", json_encode($data["User_Data"][$i]["To-do"][$j]["Tasks"]))) {
                    array_push($resp['data'], $data["User_Data"][$i]["To-do"][$j]);
                    $resp['index_j'] = $j;
                    $resp['priority'] = priority_calc($data["User_Data"][$i]["To-do"][$j]);
                }
            }
        }
    }
    echo json_encode($resp);
}


?>