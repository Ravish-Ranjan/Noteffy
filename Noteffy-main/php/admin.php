<?php
    require_once("initial.php");require_once("hash.php");
    require_once("jsonpath-0.8.1.php");
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
                            $cleantasks = $todolist[$iter];
                            for($sn = 0;$sn < count($cleantasks["Tasks"]);$sn++){
                                for($ui = 0;$ui < count($cleantasks["status"]);$ui++){
                                    if($cleantasks["status"][$ui]["member"]==$user){
                                        $cleantasks["completed"] = $cleantasks["status"][$ui]["completed"];
                                    }
                                }
                            }
                            unset($cleantasks["assignees"]);unset($cleantasks["status"]);
                            array_push($classitem["Tasks"],$cleantasks);
                        }
                        else if($diff<0){
                            array_push($orgs["Organizations"][$k]["classes"][$l]["Recycle"], $todolist[$iter]);

                            if($iter==count($todolist)-1){
                                $temp1 = array_pop($orgs["Organizations"][$k]["classes"][$l]["To-do"]);
                            }
                            else{
                            $temp = array_splice($orgs["Organizations"][$k]["classes"][$l]["To-do"], $iter, 1);
                            }
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
    function insertStat(&$data,$admin,$class,$user,$prior){
        for($org = 0;$org < count($data['Organizations']);$org++){
            if($data['Organizations'][$org]['Admin']==$admin){
                for($clas = 0;$clas < count($data['Organizations'][$org]['classes']);$clas++){
                    $currclass = $data['Organizations'][$org]['classes'][$clas];
                    if($currclass['Cname']==$class){
                        for($st = 0;$st < count($currclass['Stats']);$st++){
                            if($currclass['Stats'][$st]['user']==$user){
                                if($prior>0) $list = 'comptasks'.((string) $prior);
                                else if($prior==0) $list = 'expired';
                                $daynow = date("Y-m-d");
                                $dates = $currclass['Stats'][$st][$list]['dates'];$counts = $currclass['Stats'][$st][$list]['count'];
                                if(in_array($daynow,$dates)){
                                    $index = array_search($daynow,$dates);
                                    $data['Organizations'][$org]['classes'][$clas]['Stats'][$st][$list]['count'][$index]+=1;
                                }
                                else{
                                    array_push($data['Organizations'][$org]['classes'][$clas]['Stats'][$st][$list]['dates'],$daynow);
                                    array_push($data['Organizations'][$org]['classes'][$clas]['Stats'][$st][$list]['count'],1);
                                }
                                return 1;
                            }
                        }
                    }
                }
            }
        }
        return -1;
    }
     function removeadmintask(){
        date_default_timezone_set("Asia/Kolkata");
        // require_once("initial.php");require_once("hash.php");
        if(!isset($_COOKIE['user_number'])){
            echo '<script>window.replace("index.php")</script>';return;
        }
        if(!isset($_GET["admin"]) || !isset($_GET["remtodo"]) || !isset($_GET["class"]) || !isset($_GET["todon"]) || !isset($_GET["tno"])){
            return;
        }
        //Sanitize requests
        if($_GET["class"]=='' || $_GET["tno"]=='' || $_GET["todon"]==''){
            echo json_encode(array('Message'=>'failure'));die();
        }
        header("Content-Type: application/json;charset=utf-8");
        $orgs = file_get_contents("../data/Organizations.json");
        $orgs = json_decode($orgs,true);
        $adminstats = file_get_contents("../data/admintask.json");
        $adminstats = json_decode($adminstats,true);

        $user = getUserNumber();
        for($j = 0;$j < count($orgs["Organizations"]);$j++){
            for($k = 0;$k < count($orgs["Organizations"][$j]["classes"]);$k++){
                if (in_array($user,$orgs["Organizations"][$j]["classes"][$k]["group"])) {
                        $class = $orgs["Organizations"][$j]["classes"][$k];
                        $to_do_count = count($orgs["Organizations"][$j]["classes"][$k]["To-do"]);
                        for($tn = 0;$tn < $to_do_count;$tn++){

                           if($orgs["Organizations"][$j]["classes"][$k]["To-do"][$tn]['Title']==$_GET["todon"]){

                            $todolist = $orgs["Organizations"][$j]["classes"][$k]["To-do"][$tn];
                            $status_count = count($orgs["Organizations"][$j]["classes"][$k]["To-do"][$tn]["status"]);
                            for($sn = 0;$sn < $status_count;$sn++){

                                if($orgs["Organizations"][$j]["classes"][$k]["To-do"][$tn]["status"][$sn]["member"]==$user){
                                    $status = $orgs["Organizations"][$j]["classes"][$k]["To-do"][$tn]["status"][$sn];
                                    $comlen = count($status["completed"]);
                                    if(!in_array($_GET["tno"],$status["completed"])){
                                        $orgs["Organizations"][$j]["classes"][$k]["To-do"][$tn]["status"][$sn]["completed"][$comlen] = (int) $_GET["tno"];

                                        //Put into admin's statistics chart here
                                        $c = insertStat($adminstats,$orgs["Organizations"][$j]["Admin"],$class["Cname"],$user,$todolist['Priority']);
                                        if($c==-1) die();
                                        $findus = array_search($user,$orgs["Organizations"][$j]["classes"][$k]["To-do"][$tn]["assignees"]);
                                        if(count($orgs["Organizations"][$j]["classes"][$k]["To-do"][$tn]["Tasks"])==count($orgs["Organizations"][$j]["classes"][$k]["To-do"][$tn]["status"][$sn]["completed"])){
                                            array_splice($orgs["Organizations"][$j]["classes"][$k]["To-do"][$tn]["assignees"],$findus,1);
                                        }
                                        $orgs1 = json_encode($orgs);
                                        file_put_contents("../data/Organizations.json",$orgs1);
                                        $adminstats1 = json_encode($adminstats);
                                        file_put_contents("../data/admintask.json",$adminstats1);
                                        $respdata = array("Message"=>"Success");echo json_encode($respdata);
                                        die();
                                    }
                                }
                            }
                        }
                    }
                    }
                }
            }
            $adminstats1 = json_encode($adminstats);
            file_put_contents("../data/admintask.json",$adminstats1);
            echo json_encode(array('Message'=>'failure'));die();
    }
    removeadmintask();
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
    $stats = file_get_contents("../data/admintask.json");
    $stats = json_decode($stats,true);

    $personal = json_decode($personal, true);
    $userc = count($personal["Users"]);
    $orgs = count($classData["Organizations"]);
    $statorgs = count($stats["Organizations"]);
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
                    $classData["Organizations"][$u]["classes"][$classes]['Events'] = array();
                    return;
                }
            }
            for ($u = 0; $u < $statorgs; $u++) {
                if ($stats["Organizations"][$u]["Admin"] == $user) {
                    $classes = count($classData["Organizations"][$u]["classes"]);
                    $stats["Organizations"][$u]["classes"][$classes]['Cname'] = $className;
                    $stats["Organizations"][$u]["classes"][$classes]['Stats'] = array();
                    return;
                }
            }
        } else if (isset($_POST['JClassCode'])) {
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
                    <div class='options'>
                        <button onclick=\"task_compose('', '', '', '', '',1,this)\">Assign Task</button>
                        <button>Edit</button>
                    </div>
                </div>";
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
                            $orgs["Organizations"][$j]["classes"][$k]["To-do"][$to_do_count]["status"] = array();
                            for($tt = 0;$tt < count($ids);$tt++){
                                //Still have to delete expired tasks
                                $orgs["Organizations"][$j]["classes"][$k]["To-do"][$to_do_count]["status"][$tt]["member"] =$ids[$tt];
                                $orgs["Organizations"][$j]["classes"][$k]["To-do"][$to_do_count]["status"][$tt]["completed"]=array();
                            }
                            echo "<script>location.replace('main.php')</script>";
                        }
                    }
                }
            }
                
        }
    }
}
function exploreClasses(){
    $response = array("result"=>"failure");
    if(isset($_GET['classes']) && $_GET['classes']=='true'){
        header("Content-Type:application/json;character=Utf-8");
        $response["result"] = "success";
        $response['cls'] = array();
        $orgs = file_get_contents("../data/Organizations.json");
        $orgs = json_decode($orgs, true);
        $user = getUserNumber();
        for($i=0;$i<count($orgs['Organizations']);$i++){
            if($orgs['Organizations'][$i]["Admin"] == $user){
                for($j=0;$j<count($orgs['Organizations'][$i]["classes"]);$j++){
                    array_push($response['cls'], $orgs['Organizations'][$i]["classes"][$j]["Cname"]);
                }
            }
            else{
                for($k=0;$k<count($orgs['Organizations'][$i]["classes"]);$k++){
                    if(in_array($user,$orgs['Organizations'][$i]["classes"][$k]["group"])){
                        array_push($response['cls'], $orgs['Organizations'][$i]["classes"][$k]["Cname"]);
                    }
                }
            }
        }
        echo json_encode($response);
        die();
    }
}
exploreClasses();
function classMembers(){
    if(!isset($_COOKIE['user_number'])){
        return;
    }
    if(isset($_GET['className']) ){
        $resp = array();
        $resp['name'] = array();$resp['stats'] = array();
        $className = $_GET['className'];
        $orgs = file_get_contents("../data/Organizations.json");
        $orgs = json_decode($orgs, true);
        $adtasks = file_get_contents("../data/admintask.json");
        $adtasks = json_decode($adtasks, true);
        $details = file_get_contents("../data/details.json");
        $details = json_decode($details,true);
        $user = getUserNumber();

        for($i=0;$i<count($orgs['Organizations']);$i++){
            for($j=0;$j<count($orgs['Organizations'][$i]["classes"]);$j++){
                if($orgs['Organizations'][$i]["classes"][$j]["Cname"] == $className){
                    $resp['id'] = $orgs['Organizations'][$i]["classes"][$j]["group"];
                }
            }
        }
        for($iter=0;$iter<count($resp['id']);$iter++){
            $temp = ($resp['id'][$iter]);
            array_push($resp['name'], $details["Users"][$temp]["User_Name"]);
        }
        for($i=0;$i<count($adtasks['Organizations']);$i++){
            if($adtasks['Organizations'][$i]['Admin']==$user){
            for($j=0;$j<count($adtasks['Organizations'][$i]["classes"]);$j++){
                if($adtasks['Organizations'][$i]["classes"][$j]["Cname"] == $className){
                    $resp['stats'] = $adtasks['Organizations'][$i]["classes"][$j]["Stats"];
                }
            }
        }
        }
        echo json_encode($resp);
        die();
    }
}
classMembers();
function storeEvents(){
    $orgs = file_get_contents("../data/Organizations.json");
    $orgs = json_decode($orgs, true);
    $user = getUserNumber();
    $userCheck = jsonPath($orgs, "$..Organizations[*].Admin");
    $flag = in_array($user, $userCheck) ? true : false;
    if(isset($_POST['E_Date']) && isset($_POST['E_Time']) && isset($_POST['E_Title']) && isset($_POST['Description']) && $flag){
        $data = jsonPath($orgs, "$..Organizations[$user].classes[*].Cname");
        $workspace = null;
        for ($d = 0; $d < count($data);$d++){
            if($data[$d] == $_POST['workspace-choice-2']){
                $workspace = $d;
            }
        }
        $temp_arr = array();
        $temp_arr["Date"] = $_POST['E_Date'];
        $temp_arr['Time'] = $_POST['E_Time'];
        $temp_arr['Title'] = $_POST['E_Title'];
        $temp_arr['Description'] = $_POST['Description'];
        array_push($orgs["Organizations"][$user]["classes"][$workspace]["Events"],$temp_arr);
        $orgs = json_encode($orgs);
        file_put_contents("../data/Organizations.json", $orgs);
        echo "<script>window.location.href='../HTML/control.html'</script>";
    }
}
?>