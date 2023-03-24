<?php
function sanitize(&$data)
{
    $data = strip_tags($data);
}

function signIn(&$jsonData)
{ //this function uses the saved data to verify and let the old user sign in
    if (isset($_POST['User_Name_']) && isset($_POST['Password_'])) {
        $users_count = count($jsonData["Users"]);
        $errc = "uid";
        $name = "";
        for ($i = 0; $i < $users_count; $i++) {
            // echo $i.'<br>';
            if ($jsonData["Users"][$i]["identifier"] == $i) {
                if ($jsonData["Users"][$i]["Password"] === encrypt_data($_POST["Password_"], str_pad($_POST["User_Name_"], 32, '#', STR_PAD_RIGHT))) {
                    setcookie("user", $jsonData["Users"][$i]["User_Name"], 0, "/");
                    setcookie("user_number", $jsonData["Users"][$i]["identifier"], 0, "/");
                    echo "<script>window.location.href = window.location.href</script>";
                    return;
                } else {
                    $name = $jsonData["Users"][$i]["user_name"];
                    $errc = "upwd";
                }
            }
        }
        echo '<script>window.location.href="../HTML/signUp.html?err=' . $errc . '&name=' . $name . '&activity=' . ($errc == 'uid' ? "signup" : "signin") . '";</script>';
        return;
    }
}
function getUser()
{ // this function fetches the user from the data
    if (isset($_COOKIE["user"])) {
        return $_COOKIE["user"];
    } else
        return " ";
}
function Delete_Note(&$jsonData)
{
    if (isset($_GET["N_no"])) {
        $n_no = $_GET["N_no"];
        $userNumber = getUserNumber();
        for ($i = 0; $i < count($jsonData["User_Data"]); $i++) {
            if ($jsonData["User_Data"][$i]["identifier"] == $userNumber) {
                array_splice($jsonData["User_Data"][$userNumber]["Notes"], $n_no, 1);
                echo "<script>window.location.href = '../php/main.php'</script>";
                return;
            }
        }
        echo "<Script>window.location.href = '../HTML/error.html'</script>";
    }
}
function fetch_store(&$jsonData){
 // this function fetches and stores the new note created by by the user
    // $user = -1;
    // $User_count = count($jsonData['Users']);
    // $userName = getUser();
    // //Do not disturb until later
    // echo ' ';

    // for ($i = 0; $i < $User_count; $i++) {
    //     if ($jsonData['Users'][$i]['User_Name'] == $userName)
    //         $user = $i;
    // }
    // if (isset($_POST['Title']) && isset($_POST['Note']) && isset($_POST['Date'])) {
    //     if (isset($_GET['note_no'])) {
    //         $Note_count = $_GET['note_no'];
    //     } else
    //     $Note_count = count($jsonData['Users'][$user]['Notes']);
    //     $jsonData['Users'][$user]['Notes'][$Note_count]['Title'] = $_POST['Title'];
    //     $jsonData['Users'][$user]['Notes'][$Note_count]['Date'] = $_POST['Date'];
    //     $jsonData['Users'][$user]['Notes'][$Note_count]['Content'] = $_POST['Note'];
    //     echo "<script>location.replace('main.php')</script>";
    // }
    // return $user;
    $user = getUserNumber();
    if ($jsonData["User_Data"][$user]["identifier"] != $user)
        die("Could not find user");
    if (isset($_POST['Title']) && isset($_POST['Note']) && isset($_POST['Date'])) {
            if (isset($_GET['note_no'])) {
                $Note_count = $_GET['note_no'];
            } else
            $Note_count = count($jsonData['User_Data'][$user]['Notes']);
            $jsonData['User_Data'][$user]['Notes'][$Note_count]['Title'] = $_POST['Title'];
            $jsonData['User_Data'][$user]['Notes'][$Note_count]['Date'] = $_POST['Date'];
            $jsonData['User_Data'][$user]['Notes'][$Note_count]['Content'] = $_POST['Note'];
            $jsonData['User_Data'][$user]['Notes'][$Note_count]['Note_type'] = false;
            echo "<script>location.replace('main.php')</script>";
        }
    return $user;
}
function display(&$jsonData, $user)
{ // this function displays the user's notes in a scatter manner
    $count = count($jsonData['User_Data'][$user]['Notes']);
    for ($i = 0; $i < $count; $i++) {
        if (!$jsonData['User_Data'][$user]['Notes'][$i]["Note_type"]) {
            $item = $jsonData['User_Data'][$user]['Notes'][$i];
            $j = $i + 1;
            $noteimg = "../media/newNote" . rand(1, 3) . ".png";
            $pinimg = "../media/pin" . rand(1, 3) . ".png";
            $title = $item['Title'];
            $content = $item['Content'];
            sanitize($content);
            $visible = substr($content, 0, 25); //
            echo "<div class=\"divi\" style=\"background-image:url($noteimg);\" title='Title:$title'>
        <div class=\"topic\">
                        <img id=\"pin\" src=$pinimg alt=\"pin\">
                    </div>
                    <div class=\"data\">
                        <div class=\"screen\">
                            <p id='content$i'>$content</p>
                        </div>
                        <div class=\"control\">
                            <button onclick=\"\">
                            <a href=\"../php/main.php?note_no=$i\">
                                <img title='edit the note' src=\"../media/edit.png\" alt=\"\">
                            </a>
                            </button>
                            <button onclick=\"\" id='clip'>
                                <img title='copy the note to clipboard' src=\"../media/share.png\" alt=\"\" onClick='getContent($i)'>
                            </button>
                            <button onclick=\"\">
                                <a href='../php/main.php?N_no=$i&User=$user' style='text-decoration:none;'>
                                    <img title='delete the note' src=\"../media/delete.png\" alt=\"\">
                                </a>
                            </button>
                        </div>
                    </div>
                </div>";
        }
    // $count = count($jsonData['Users'][$user]['Notes']);
    // for ($i = 0; $i < $count; $i++) {
    //     $item = $jsonData['Users'][$user]['Notes'][$i];
    //     $j = $i + 1;
    //     $noteimg = "../media/newNote" . rand(1, 3) . ".png";
    //     $pinimg = "../media/pin" . rand(1, 3) . ".png";
    //     $title = $item['Title'];
    //     $content = $item['Content'];
    //     sanitize($content);
    //     $visible = substr($content, 0, 25); //
    //     echo "<div class=\"divi\" style=\"background-image:url($noteimg);\" title='title:$title'>
    //     <div class=\"topic\">
    //                     <img id=\"pin\" src=$pinimg alt=\"pin\">
    //                 </div>
    //                 <div class=\"data\">
    //                     <div class=\"screen\">
    //                         <p id='content$i'>$content</p>
    //                     </div>
    //                     <div class=\"control\">
    //                         <button onclick=\"\">
    //                         <a href=\"../php/main.php?note_no=$i\">
    //                             <img title='edit the note' src=\"../media/edit.png\" alt=\"\">
    //                         </a>
    //                         </button>
    //                         <button onclick=\"\" id='clip'>
    //                             <img title='copy the note to clipboard' src=\"../media/share.png\" alt=\"\" onClick='getContent($i)'>
    //                         </button>
    //                         <button onclick=\"\">
    //                             <a href='../php/main.php?N_no=$i&User=$user' style='text-decoration:none;'>
    //                                 <img title='delete the note' src=\"../media/delete.png\" alt=\"\">
    //                             </a>
    //                         </button>
    //                     </div>
    //                 </div>
    //             </div>";
    }
}
function updateNote($jsonData)
{
    $user = isset($_COOKIE['user_number']) ? $_COOKIE['user_number'] : false;
    $date = '';
    $title = '';
    $note = '';
    if ($user != -1) {
        if (isset($_GET['note_no'])) {
            $note_no = $_GET['note_no'];
            $date .= $jsonData["User_Data"][$user]["Notes"][$note_no]["Date"];
            $title .= $jsonData["User_Data"][$user]["Notes"][$note_no]["Title"];
            $note .= $jsonData["User_Data"][$user]["Notes"][$note_no]["Content"];
            echo "<script>
                        note_compose('$date','$title','$note','$note_no');
                    </script>";
        }
    } else
        return;
}
?>
