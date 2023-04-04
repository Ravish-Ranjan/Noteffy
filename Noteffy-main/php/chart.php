<?php
require_once("jsonpath-0.8.1.php");
require_once("initial.php");
require_once("hash.php");
function changePassword(){
    header("Content-Type:application/json;character=Utf-8");
    $response = array("status" => "failure","pass_change_status"=>"failure");

    $details = file_get_contents("../data/Details.json");
    $details = json_decode($details, true);
    $user = getUserNumber();
    $user_details = jsonPath($details, "$.Users[$user]");
    $userName = $user_details[0][$user]["User_Name"];
    if(isset($_GET['pass'])){
        $pass = $user_details[0][$user]["Password"];
        $pass = decrypt_data($pass,str_pad($userName,32,"#",STR_PAD_RIGHT));
        if ($pass == $_GET['pass']) {
            $response['status'] = "success";
        }
        echo json_encode($response);
    }
    else if(isset($_GET['change']) && isset($_GET['new_pass']) && $_GET['change']){
        $temp = "12345678";
        $details["Users"][$user]["Password"] = encrypt_data($_GET['new_pass'], str_pad($userName, 32, "#", STR_PAD_RIGHT));
        $response['pass_change_status'] = "success";
        $details = json_encode($details);
        file_put_contents("../data/Details.json",$details);
        echo json_encode($response);
    }
}
changePassword();
function changePic(){
    $details = file_get_contents("../data/Details.json");
    $details = json_decode($details, true);
    $user = getUserNumber();
    $response = array("status"=> true);
    if(isset($_GET['img'])){
        $temp = "";
        preg_match("/(red|yellow|teal)/",$_GET['img'],$temp);
        $details["Users"][$user]["Profile_Pic"] = $temp[0];
        $response['pic'] = $temp[0];
        $details = json_encode($details);
        file_put_contents("../data/Details.json",$details);
        echo json_encode($response);
        die();
    }
}
changePic();
?>