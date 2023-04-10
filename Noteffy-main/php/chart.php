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
        $flag = preg_match("/(red|yellow|teal)/",$_GET['img'],$temp);
        if($flag){
            $details["Users"][$user]["Profile_Pic"] = $temp[0];
            $response['pic'] = $temp[0];
        }
        else{
            $temp = str_replace('q.png',"",basename($_GET['img']));
            $temp = str_replace('logo',"",$temp);
            $details["Users"][$user]["Profile_Pic"] = $temp;
            $response['pic'] = $temp;
        }
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
        $old_user_name = $details["Users"][$user]["User_Name"];
        $old_pass = decrypt_data($details["Users"][$user]["Password"], str_pad($old_user_name, 32, "#", STR_PAD_RIGHT));

        $details["Users"][$user]["User_Name"] = $userName;
        $new_pass = encrypt_data($old_pass, str_pad($userName, 32, "#", STR_PAD_RIGHT));
        $details["Users"][$user]["Password"] = $new_pass;
        $response['status'] = "success";

        $details = json_encode($details);
        file_put_contents("../data/Details.json",$details);
        setcookie("user", $_GET['userName'], 0, "/");
        echo json_encode($response);
        die();
    } 
}
changeUserName();
function acceptAvatar(){
    $response = array("status" => false);
    if(isset($_FILES["avatar"])){
        $filename = $_FILES['avatar']['name'];
        $tempname = $_FILES['avatar']['tmp_name'];
        $targetPath = "../media/uploads/";

        $temp = "logo" . $filename;
        $ext = preg_replace('/\.png/', "q.png", $temp);
        $ext = preg_replace('/ +/',"",$ext);
        $targetFile = $targetPath . basename($ext);
        $filetype = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $filesize = $_FILES['avatar']['size'];
        if($filetype=="png"){
            move_uploaded_file($_FILES['avatar']['tmp_name'], $targetFile);
            $response['status'] = true;
            $response['size'] = $filesize;
            $response['name'] = $ext;
        }
        echo json_encode($response);
        die();
    }
}
acceptAvatar();
function deleteFromOrganization(&$orgs,$user){
    // $group = $orgs["Organizations"][0];
    for ($iter1 = 0; $iter1 < count($orgs["Organizations"]);$iter1++){
        for($iter2=0;$iter2<count($orgs["Organizations"][$iter1]["classes"]);$iter2++){
            for($iter3=0;$iter3<count($orgs["Organizations"][$iter1]["classes"][$iter2]["To-do"]);$iter3++){
                $temp = $orgs["Organizations"][$iter1]["classes"][$iter2]["To-do"][$iter3];
                if(array_search($user, $temp["assignees"])!==false){
                    $index = array_search($user, $temp["assignees"]);
                    array_splice($orgs["Organizations"][$iter1]["classes"][$iter2]["To-do"][$iter3]["assignees"], $index, 1);
                }
            }
        }
    }

    for ($i = 0; $i < count($orgs["Organizations"]);$i++){
        if(count($orgs["Organizations"][$i]["classes"])!=0){
            for($j=0;$j<count($orgs["Organizations"][$i]["classes"]);$j++){
                if(count($orgs["Organizations"][$i]["classes"][$j]["group"])!=0){
                    for($k=0;$k<count($orgs["Organizations"][$i]["classes"][$j]["group"]);$k++){
                        $temp = $orgs["Organizations"][$i]["classes"][$j]["group"][$k];
                        if ($temp > $user){
                            $orgs["Organizations"][$i]["classes"][$j]["group"][$k] -= 1;
                        }
                        else if($temp == $user){
                            array_splice($orgs["Organizations"][$i]["classes"][$j]["group"],$k,1);

                        }
                    }
                }
            }
        }
    }
}
function deleteFromTasks($user){
    $tasks = file_get_contents("../data/task.json");
    $adminTasks = file_get_contents("../data/admintask.json");
    $tasks = json_decode($tasks, true);
    $adminTasks = json_decode($adminTasks, true);

    // tasks
    for($i=0;$i<count($tasks);$i++){
        if($tasks[$i]["User"]==$user){
            array_splice($tasks, $i, 1);
        }
        if ($tasks[$i]["User"] == $user && $i == count($tasks) - 1)
            array_splice($tasks, $i);        
    }
    // admin tasks
    for($iter1=0;$iter1<count($adminTasks["Organizations"]);$iter1++){
        if($adminTasks["Organizations"][$iter1]["Admin"]!=$user){
            for ($iter = 0; $iter < count($adminTasks["Organizations"][$iter1]["group"]);$iter++){
                if ($adminTasks["Organizations"][$iter1]["group"][$iter] == $user)
                    array_splice($adminTasks["Organizations"][$iter1]["group"], $iter, 1);
                else if ($adminTasks["Organizations"][$iter1]["group"][$iter] > $user)
                    $adminTasks["Organizations"][$iter1]["group"][$iter] -= 1;
            }
            for($iter2=0;$iter2<count($adminTasks["Organizations"][$iter1]["classes"]);$iter2++){
                for($iter3=0;$iter3<count($adminTasks["Organizations"][$iter1]["classes"][$iter2]["Stats"]);$iter3++){
                    if ($adminTasks["Organizations"][$iter1]["classes"][$iter2]["Stats"][$iter3]["user"] == $user)
                        array_splice($adminTasks["Organizations"][$iter1]["classes"][$iter2]["Stats"], $iter3, 1);
                    else if ($adminTasks["Organizations"][$iter1]["classes"][$iter2]["Stats"][$iter3]["user"] > $user)
                        $adminTasks["Organizations"][$iter1]["classes"][$iter2]["Stats"][$iter3]["user"]-=1;
                }
            }
        }
    }
    for($k=0;$k<count($adminTasks["Organizations"]);$k++){
        if($adminTasks["Organizations"][$k]["Admin"]==$user){
            array_splice($adminTasks["Organizations"], $i, 1);
            return;
        }
    }

    $tasks = json_encode($tasks);
    $adminTasks = json_encode($adminTasks);
    file_put_contents("../data/task.json", $tasks);
    file_put_contents("../data/admintask.json", $adminTasks);
}
function deleteAccount(){
    if(isset($_GET['delete'])){
        $user = getUserNumber();
        $details = file_get_contents("../data/Details.json");
        $data = file_get_contents("../data/Data.json");
        $orgs = file_get_contents("../data/Organizations.json");

        $details = json_decode($details, true);
        $data = json_decode($data, true);
        $orgs = json_decode($orgs, true);
        deleteFromOrganization($orgs, $user);
        deleteFromTasks($user);
        
        // deleting the account
        if (array_key_exists($user, $details["Users"])) {
            array_splice($details["Users"],$user,1);
            for ($i = $user; $i < count($details["Users"]);$i++){
                $details["Users"][$i]["identifier"] = $i;
            }
            $resp['details_status'] = true;
        }
        else
            $resp['details_status'] = false;
        if (array_key_exists($user, $data["User_Data"])) {
            array_splice($data["User_Data"], $user, 1);
            for ($i = $user; $i < count($data["User_Data"]);$i++){
                $data["User_Data"][$i]["identifier"] = $i;
            }
            $resp['data_status'] = true;
        }
        else
            $resp['data_status'] = false;
        if (array_key_exists($user, $orgs["Organizations"])){
            array_splice($orgs["Organizations"],$user,1);
            for ($i = $user; $i < count($orgs["Organizations"]);$i++){
                $orgs["Organizations"][$i]["Admin"] = $i;
            }
            $resp['organization_status'] = true;
        }
        else
            $resp['organization_status'] = false;

        $details = json_encode($details);
        $data = json_encode($data);
        $orgs = json_encode($orgs);
        file_put_contents("../data/Details.json",$details);
        file_put_contents("../data/Data.json",$data);
        file_put_contents("../data/Organizations.json",$orgs);
        echo json_encode($resp);
        die();
    }
}
deleteAccount();
?>