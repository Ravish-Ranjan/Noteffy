<?php
    require_once("initial.php");require_once("hash.php");
    function getmembers(){
    if(!isset($_GET["op"]) || ($_GET["op"] != "getmembers")){
        return;
    }
    header("Content-Type: application/json;charset=utf-8");
    $orgs = file_get_contents("../data/Organizations.json");
    $orgs = json_decode($orgs,true);
    $resp = array();

    $user = getUserNumber();$class = $_GET["class"];
    for($k = 0;$k < count($orgs["Organizations"]);$k++){
        if($user == $orgs["Organizations"][$k]["Admin"]){
            for ($j = 0; $j < count($orgs["Organizations"][$k]["classes"]); $j++) {
                if ($orgs["Organizations"][$k]["classes"][$j]["Cname"]==$class) {
                   $memlist = $orgs["Organizations"][$k]["classes"][$j]["group"];
                   $mems = array();
                   foreach($memlist as $uid){
                        $mname = seekUserName($uid);
                        if($mname!=-1)
                            {array_push($mems,array($uid=>$mname));}
                        else{
                            //Splice array here,remove non members
                        }
                   }
                   $resp["Message"] = "success";
                   $resp["list"] = $mems;$resp = json_encode($resp);
                   echo $resp;die();
                }
            }
            $resp["Message"] = "success";
            $resp["list"] = array();$resp = json_encode($resp);
            echo $resp;die();
        }
    }
    $resp["Message"] = "failure";$resp = json_encode($resp);
    echo $resp;die();
}
    getmembers();
?>
<?php
    function fetchtodo(&$orgs){
        date_default_timezone_set("Asia/Kolkata");
        // require_once("initial.php");require_once("hash.php");
        if(!isset($_COOKIE['user_number'])){
            echo '<script>window.replace("index.php")</script>';return;
        }
        if(!isset($_GET["admin"]) || !isset($_GET["todo"])){
            return;
        }
        header("Content-Type: application/json;charset=utf-8");
        $orgs = file_get_contents("../data/Organizations.json");
        $orgs = json_decode($orgs,true);
        $respdata = array("To-do"=>array());
        
        $user = getUserNumber();
        for($k = 0;$k < count($orgs["Organizations"]);$k++){
            for($l = 0;$l < count($orgs["Organizations"][$k]["classes"]);$l++){
                $classitem["Name"] = $orgs["Organizations"][$k]["classes"][$l]["Cname"];
                $classitem["Tasks"] = array();
                if (in_array($user,$orgs["Organizations"][$k]["classes"][$l]["group"])) {
                       $todolist = $orgs["Organizations"][$k]["classes"][$l]["To-do"];
                       for($iter=0;$iter<count($todolist);$iter++){
                        $dayDifference = strtotime($todolist[$iter]['Date']) - strtotime(date("Y-m-d"));
                        $timeDifference = strtotime($todolist[$iter]['Time']) - strtotime(date("H:i"));
                        $diff = $dayDifference + $timeDifference;
                        if(in_array($user,$todolist[$iter]["assignees"]) && $diff>=0){
                            $cleantasks = $todolist[$iter];unset($cleantasks["assignees"]);
                            array_push($classitem["Tasks"],$cleantasks);
                        }
                        else if($diff<0){
                            array_push($orgs["Organizations"][$k]["classes"][$l]["Recycle"], $todolist[$iter]);
                            array_splice($orgs["Organizations"][$k]["classes"][$l]["To-do"], $iter,1);
                        }
                       }
                    }
                    if($classitem["Tasks"]!=null)
                       { array_push($respdata["To-do"],$classitem);}
                }
            }
        $orgs1 = json_encode($orgs,true);
        file_put_contents("../data/Organizations.json",$orgs1);
        $respdata["Message"] = ($respdata["To-do"]==null)?"failure":"success";
        $respdata = json_encode($respdata);echo $respdata;
        die();
    }
    fetchtodo($jdata);
?>
<?php

function allowAdmin(&$jsonData)
{
    if (!isset($_GET["op"])) {
        return;
    } else if (!($_GET["op"] == "chadmin" || $_GET["op"] == "checkadmin")) {
        return;
    }
    header("Content-Type: application/json;charset=utf-8");
    $resp = array();
    if ($_GET["op"] == "chadmin") {
        $userNumber = getUserNumber();
        for ($i = 0; $i < count($jsonData["Users"]); $i++) {
            if ($jsonData["Users"][$i]["identifier"] == $userNumber) {
                $resp["not"] = $jsonData["Users"][$i]["User_Name"];
                if (!$jsonData["Users"][$i]["Type"]) {
                    $resp["Message"] = "admin success";
                    $jsonData["Users"][$i]["Type"] = true;
                } else {
                    $resp["Message"] = "admin present";
                }
                echo json_encode($resp);
                file_put_contents("../data/Details.json", json_encode($jsonData));
                die();
            }
        }
        $resp["Message"] = "failure";
        echo json_encode($resp);
        die();
    } else if ($_GET["op"] == "checkadmin") {
        $userNumber = getUserNumber();
        for ($i = 0; $i < count($jsonData["Users"]); $i++) {
            if ($jsonData["Users"][$i]["identifier"] == $userNumber) {
                $resp["not"] = $jsonData["Users"][$i]["User_Name"];
                if ($jsonData["Users"][$i]["Type"]) {
                    $resp["Message"] = "admin true";
                } else {
                    $resp["Message"] = "admin false";
                }
                echo json_encode($resp);
                die();
            }
        }
        $resp["Message"] = "user does not exist";
        echo json_encode($resp);
    }
    die();
}
function isInOrganization($user,$classData){
    for($i=0;$i<count($classData["Organizations"]);$i++){
        for($j=0;$j<count($classData["Organizations"][$i]["classes"]);$j++){
            if(in_array($user,$classData["Organizations"][$i]["classes"][$j]["group"])){
                return true;
            }
        }
    }
    return false;
}
function createClass(&$personal, &$classData)
{
    $user = getUserNumber();

    $personal = json_decode($personal, true);
    $userc = count($personal["Users"]);
    $orgs = count($classData["Organizations"]);
    $admin = -1;
    if ($user != -1) {
        if (isset($_POST['ClassName']) && ($_POST['ClassName']) != '') {
            $className = $_POST['ClassName'];
            $classCode = $_POST['ClassCode'];
            $classDesc = $_POST['ClassDesc'];
            $classLimit = $_POST['ClassLimit'];

            $flag = 0;
            for ($u = 0; $u <= $userc; $u++) {
                if ($personal["Users"][$u]["identifier"] == $user) {
                    array_push($personal["Users"][$u]["Organization_Code"], $classCode);
                    $flag = 1;
                    $personal1 = json_encode($personal, true);
                    file_put_contents("../data/Details.json", $personal1);
                    break;
                }
            }
            if ($flag == 0) {
                echo "<script>window.location.href = '../HTML/error.html'</script>";
            }
            for ($u = 0; $u < $orgs; $u++) {
                if ($classData["Organizations"][$u]["Admin"] == $user) {
                    $classes = count($classData["Organizations"][$u]["classes"]);
                    $classData["Organizations"][$u]["classes"][$classes]['Cname'] = $className;
                    $classData["Organizations"][$u]["classes"][$classes]['Cdesc'] = $classDesc;
                    $classData["Organizations"][$u]["classes"][$classes]['CLimit'] = $classLimit;
                    $classData["Organizations"][$u]["classes"][$classes]['Organization_code'] = $classCode;
                    $classData["Organizations"][$u]["classes"][$classes]['group'] = array();
                    $classData["Organizations"][$u]["classes"][$classes]['To-do'] = array();
                    $classData["Organizations"][$u]["classes"][$classes]['Recycle'] = array();
                    return;
                }
            }
        } else if (isset($_POST['JClassCode']) && $_POST['ClassName'] == '') {
            $code = $_POST['JClassCode'];
            for ($u = 0; $u < $orgs; $u++) {
                    for ($c = 0; $c < count($classData["Organizations"][$u]["classes"]); $c++) {
                        if ($classData["Organizations"][$u]["classes"][$c]["Organization_code"] == $code && $user!=$classData["Organizations"][$u]["Admin"]) {
                            array_push($classData["Organizations"][$u]["classes"][$c]["group"], $user);
                            return true;
                        }
                    }
            }
            return false;
        } 
        
    }
}
function displayClass(&$classData)
{
    $user = getUserNumber();
    $orgs = count($classData["Organizations"]);
    if ($user != -1) {
        for ($j = 0; $j < $orgs; $j++) {
            //Classes created by user
            if ($user == $classData["Organizations"][$j]["Admin"]) {
                for ($k = 0; $k < count($classData["Organizations"][$user]["classes"]); $k++) {
                    $title = $classData["Organizations"][$user]["classes"][$k]["Cname"];
                    echo "
                    <div class='class'>
                    <div class='backg'>
                        <h2>$title</h2>
                    </div>
                    <div class='options' onclick=\"task_compose('', '', '', '', '',1,this)\"><button>opt1</button><button>opt2</button></div>
                </div>
                    ";
                }
            }
            //Classes in which user is a member
            else if($user != $classData["Organizations"][$j]["Admin"] && isInOrganization($user,$classData)){
                for ($k = 0; $k < count($classData["Organizations"][$j]["classes"]); $k++) {
                    if (in_array($user, $classData["Organizations"][$j]["classes"][$k]["group"])) {
                        $title = $classData["Organizations"][$j]["classes"][$k]["Cname"];
                        echo "
                    <div class='class'>
                    <div class='backg'>
                        <h2>$title</h2>
                    </div>
                    <div class='options'><button>opt1</button><button>opt2</button></div>
                </div>
                    ";
                    }
                }
            }
        }
    }
    }
function createAdminTask(&$users,&$orgs){
    if(!isset($_GET["admin"]) || !isset($_GET["class"]) || $_GET["admin"]!="true"){
        return;
    }
    $user = getUserNumber();
    $orgcount = count($orgs["Organizations"]);
    if ($user != -1) {
        // echo $_POST['T_Title'];
        if(isset($_POST['T_Title']) && isset($_POST['T_Time']) && isset($_POST['T_Date'])){
            for ($j = 0; $j < $orgcount; $j++) {
                if ($user == $orgs["Organizations"][$j]["Admin"]) {
                    // echo "<script>location.replace('res.php')</script>";
                    $id = count($orgs["Organizations"][$j]["classes"]);
                    for ($k = 0; $k < count($orgs["Organizations"][$j]["classes"]); $k++) {
                        if($orgs["Organizations"][$j]["classes"][$k]["Cname"]==$_GET["class"]){

                            $to_do_count = count($orgs["Organizations"][$j]["classes"][$k]["To-do"]);
                            $orgs["Organizations"][$j]["classes"][$k]["To-do"][$to_do_count]["Title"] = $_POST['T_Title'];
                            $orgs["Organizations"][$j]["classes"][$k]["To-do"][$to_do_count]["Time"] = $_POST['T_Time'];
                            $orgs["Organizations"][$j]["classes"][$k]["To-do"][$to_do_count]["Date"] = $_POST['T_Date'];
                            $orgs["Organizations"][$j]["classes"][$k]["To-do"][$to_do_count]["Priority"] = 1;
                            $orgs["Organizations"][$j]["classes"][$k]["To-do"][$to_do_count]["Tasks"]=explode("\n",$_POST['Task']);

                            $ids = array();
                            foreach($_POST['assignedmems'] as $memes){
                                array_push($ids,(int) $memes);

                            }
                            $orgs["Organizations"][$j]["classes"][$k]["To-do"][$to_do_count]["assignees"] = $ids;
                            echo "<script>location.replace('main.php')</script>";
                        }
                    }
                }
            }
                
        }
    }
}
?>