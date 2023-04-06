<?php
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
            sanitize($_POST['Note']);
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
    }
}
function updateNote($jsonData)
{
    $user = getUserNumber();
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
        echo "<script>window.location.href = '../HTML/error.html'</script>";
}
?>
