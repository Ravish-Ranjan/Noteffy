<?php 
    
?>

<?php
    
    function Delete_task(&$jsonData){ // this function is to let user delete a task
        if(isset($_GET["T_no"])){
            $t_no = $_GET["T_no"];
            $User = getUserNumber();
            $userName = getUser();
            for($i=0;$i<count($jsonData["User_Data"]);$i++){
                if($jsonData["User_Data"][$i]["identifier"]== $User){
                echo <<<_END
                    <script>
                        var d = new Date();
                        d.setTime(d.getTime()+24*60*60*1000);
                        let decodedCookie = decodeURIComponent(document.cookie);
                        decodedCookie = decodedCookie.split(';');
                        for (let i = 0; i < decodedCookie.length; i++) {
                            const temp = decodedCookie[i].split('=')
                            if (temp[0].trim() == 'comp_task') {
                                let t = JSON.parse(temp[1]);
                                console.log(parseInt($t_no))
                                for(let j=parseInt($t_no);j<Object.keys(t[$User]).length-1;j++){
                                    console.log('hello');
                                    t[$User][j] = t[$User][j+1];
                                }
                                t[$User][Object.keys(t[$User]).length-1] = [];
                                console.log(t);
                                document.cookie = "comp_task="+JSON.stringify(t)+";expires="+d.toUTCString()+";path=/";
                            }
                        }
                        </script>[
                    _END;
                    array_splice($jsonData["User_Data"][$User]["To-do"],$t_no,1);
                    echo "
                    <script>
                        window.location.href = '../php/main.php'
                    </script>";
                    return;
                }
            }
            echo "
            <Script>
                window.location.href = '../php/main.php'
            </script>";
        }
    }
    function task_compose(&$jsonData){ // this function is to let user create more tasks 
        if(isset($_GET['admin'])){
            return;
        }
        $user = getUserNumber();
        if(isset($_POST['T_Title']) && isset($_POST['T_Time']) && isset($_POST['T_Date'])){
            if(isset($_GET['task_no']))
                $to_do_count = $_GET['task_no'];
            else
                $to_do_count = count($jsonData["User_Data"][$user]["To-do"]);
                $jsonData["User_Data"][$user]["To-do"][$to_do_count]["Title"] = $_POST['T_Title'];
                $jsonData["User_Data"][$user]["To-do"][$to_do_count]["Time"] = $_POST['T_Time'];
                $jsonData["User_Data"][$user]["To-do"][$to_do_count]["Date"] = $_POST['T_Date'];
                $jsonData["User_Data"][$user]["To-do"][$to_do_count]["Priority"] = 1;
                $jsonData["User_Data"][$user]["To-do"][$to_do_count]["Tasks"]=explode("\n",$_POST['Task']);
                echo "<script>location.replace('main.php')</script>";
                return $user;
        }
        if($user!=-1)
            return $user;
    }
    function display_task(&$jsonData,$user){ // this function is to  the tasks of the user in scatter manner
        $count = count($jsonData['User_Data'][$user]['To-do']);
        for ($i=0; $i < $count; $i++){
            $item = $jsonData['User_Data'][$user]['To-do'][$i]; 
            date_default_timezone_set("Asia/Kolkata");

            $timeDiffernce = strtotime($item['Time']) - strtotime(date("H:i"));
            $dayDifference = strtotime($item['Date']) - strtotime(date("Y-m-d"));
            $temp = $timeDiffernce + $dayDifference;
        if ($temp >= 0) {
            $j = $i + 1;
            $noteimg = "../media/newNote" . priority_calc($item) . ".png";
            $pinimg = "../media/pin" . priority_calc($item) . ".png";
            $title = $item['Title'];
            $content = $item['Tasks']; //<label class=\"title\" id='title$i'>$j.$title</label>
            sanitize_array($content);
            // <a href='../php/main.php?T_no=$i&User=$user' style='text-decoration:none;color:black'>
            echo "<div class=\"divi\" style=\"background-image:url($noteimg);\" title='title:$title'>
                    <div class=\"topic\">
                        <img id=\"pin\" src=$pinimg alt=\"pin\">
                    </div>
                    <div class=\"data\">
                        <div class=\"screen\" id='tasks$i'><ul style=\"list-style-type:none;\">";
            for ($k = 0; $k < count($content); $k++) {
                echo "
                                <li>$content[$k]</li>
                            ";
            }
            echo "</ul></div>
                        <div class=\"control\">
                            <button onclick=\"\">
                            <a href='main.php?task_no=$i'>
                                <img title='edit the task' src=\"../media/edit.png\" alt=\"\">
                            </a>
                            </button>
                            <button onclick=\"getTasks($i)\">
                                <img title='copy the task to clipboard' src=\"../media/share.png\" alt=\"\">
                            </button>
                            <button onclick=\"\">
                                <a href='../php/main.php?T_no=$i' style='text-decoration:none;'>
                                    <img title='delete the task' src=\"../media/delete.png\" alt=\"\">
                                </a>
                            </button>
                        </div>
                    </div>
                </div>";
        }
        else{
            array_push($jsonData["User_Data"][$user]["recycle"], $jsonData["User_Data"][$user]["To-do"][$i]);
            array_splice($jsonData["User_Data"][$user]["To-do"], $i, 1);
        }
        }
    }
    function updateTask($jsonData){
        $user = getUserNumber();
        $date = '';
        $time = '';
        $title = '';
        $task = '';
        if($user!=-1){
            if(isset($_GET['task_no'])){
                $task_no = $_GET['task_no'];
                $date.= $jsonData["User_Data"][$user]["To-do"][$task_no]["Date"];
                $time.= $jsonData["User_Data"][$user]["To-do"][$task_no]["Time"];
                $title.= $jsonData["User_Data"][$user]["To-do"][$task_no]["Title"];
                for($i=0;$i<count($jsonData["User_Data"][$user]["To-do"][$task_no]["Tasks"]);$i++){
                    $newLinePos = strpos($jsonData["User_Data"][$user]["To-do"][$task_no]["Tasks"][$i],"\r");
                    if($newLinePos!==FALSE)
                        $task.= substr($jsonData["User_Data"][$user]["To-do"][$task_no]["Tasks"][$i],0,$newLinePos).'\n';
                    else
                        $task.= $jsonData["User_Data"][$user]["To-do"][$task_no]["Tasks"][$i];
                }
                echo "<script>
                        task_compose('$date','$time','$title','$task','$task_no');
                    </script>";
            }
        }
        else echo "<script>window.location.href = '../HTML/error.html'</script>";
    }
?>