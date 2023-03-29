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
function createClass(&$personal, &$classData)
{
    $user = getUserNumber();

    $personal = json_decode($personal, true);
    $userc = count($personal["Users"]);
    $orgs = count($classData["Organizations"]);
    $admin = -1;
    if ($user != -1) {
        if (isset($_POST['ClassName'])) {
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
                    return;
                }
            }
        }
    } else
        echo "<script>window.location.href = '../HTML/error.html'</script>";
}
function displayClass(&$classData)
{
    $user = getUserNumber();

    $orgs = count($classData["Organizations"]);
    if ($user != -1) {
        for ($j = 0; $j < $orgs; $j++) {
            if ($user == $classData["Organizations"][$j]["Admin"]) {
                for ($k = 0; $k < count($classData["Organizations"][$user]["classes"]); $k++) {
                    $title = $classData["Organizations"][$user]["classes"][$k]["Cname"];
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
?>