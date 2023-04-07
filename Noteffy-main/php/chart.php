<?php
require_once("jsonpath-0.8.1.php");
require_once("initial.php");
require_once("hash.php");
function changePassword(){
    header("Content-Type:application/json;character=Utf-8");
    $status = "failure";
    $status = encrypt_data($status, "");
    $pass_change_status = "failure";
    $pass_change_status = encrypt_data($pass_change_status, "");
    $response = array("status" => $status,"pass_change_status"=>$pass_change_status);

    $details = file_get_contents("../data/Details.json");
    $details = json_decode($details, true);
    $user = getUserNumber();
    $user_details = $details["Users"][$user];
    $userName = $user_details["User_Name"];
    if(isset($_GET['pass'])){
        $pass = $user_details["Password"];
        // $enteredPass = encrypt_data($_GET['pass'], str_pad($userName, 32, "#", STR_PAD_RIGHT));
        $enteredPass = $_GET['pass'];
        if ($pass == $enteredPass) {
            $temp = "success";
            $response['status'] = encrypt_data($temp, "");
        }
        echo json_encode($response);
    }
    else if(isset($_GET['old_pass']) && isset($_GET['new_pass'])){
        if($_GET['old_pass']==$details["Users"][$user]["Password"])
            $details["Users"][$user]["Password"] = $_GET['new_pass'];
        else
            die();
        $temp = "success";
        $response['pass_change_status'] = encrypt_data($temp, str_pad($details["Users"][$user]["User_Name"], 32, "#", STR_PAD_RIGHT));
        $details = json_encode($details);
        file_put_contents("../data/Details.json",$details);
        echo json_encode($response);
    }
}
changePassword();
function changePic(){
    header("Content-Type:application/json;charset=utf-8");
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
function changeUserName(){
    header("Content-Type:application/json;charset=utf-8");
    $details = file_get_contents("../data/Details.json");
    $details = json_decode($details, true);
    $response = array("status" => "failure");
    if(isset($_GET['userName'])){
        $userName = decrypt_data($_GET['userName'],"");
        $user = getUserNumber();
        $details["Users"][$user]["User_Name"] = $userName;
        $response['status'] = "success";

        $details = json_encode($details);
        file_put_contents("../data/Details.json",$details);
        setcookie("user", $_GET['userName'], 0, "/");
        echo json_encode($response);
        die();
    } 
}
changeUserName();
?>