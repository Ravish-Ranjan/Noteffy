<?php
include "hash.php";
include "initial.php";

header("Content-Type:application/json;character=Utf-8");
$resp = array();
$resp['data'] = array();
if (isset($_GET['term'])) {
    $data = file_get_contents("../data/Data.json");
    $data = json_decode($data, true);
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