<?php
    function Delete_task(&$jsonData){ // this function is to let user delete a task
        if(isset($_GET["T_no"]) && isset($_GET["User"])){
            $t_no = $_GET["T_no"];
            $User = $_GET["User"];
            $userName = getUser($jsonData);
            for($i=0;$i<count($jsonData["Users"]);$i++){
                if($jsonData["Users"][$i]["User_Name"]== $userName && $i==$User){
                    array_splice($jsonData["Users"][$User]["To-do"],$t_no,1);
                    echo "<script>window.location.href = '../php/main.php'</script>";
                    return;
                }
            }
            echo "<Script>window.location.href = '../php/main.php'</script>";
        }
    }
    function task_compose(&$jsonData){ // this function is to let user create more tasks 
        $user = -1;
        $User_count = count($jsonData['Users']);
        $userName = getUser($jsonData);
        for($i=0;$i<$User_count;$i++){
            if($jsonData["Users"][$i]["User_Name"]==$userName){
                $user = $i;
            }
        }
        if(isset($_POST['T_Title']) && isset($_POST['T_Time']) && isset($_POST['T_Date'])){
            $to_do_count = count($jsonData["Users"][$user]["To-do"]);
            $jsonData["Users"][$user]["To-do"][$to_do_count]["Title"] = $_POST['T_Title'];
            $jsonData["Users"][$user]["To-do"][$to_do_count]["Time"] = $_POST['T_Time'];
            $jsonData["Users"][$user]["To-do"][$to_do_count]["Date"] = $_POST['T_Date'];
            $jsonData["Users"][$user]["To-do"][$to_do_count]["Priority"] = 1;
            $jsonData["Users"][$user]["To-do"][$to_do_count]["Tasks"]=explode("\n",$_POST['Task']);
        }
        if($user!=-1)
            return $user;
    }
    function display_task($jsonData,$user){ // this function is to  the tasks of the user in scatter manner
        $count = count($jsonData['Users'][$user]['To-do']);
        for ($i=0; $i < $count; $i++){
            $item = $jsonData['Users'][$user]['To-do'][$i]; 
            // calculating priority
            date_default_timezone_set("Asia/Kolkata");
            
            $j = $i+1;
            $noteimg = "../media/note".rand(1,3).".png";
            $pinimg = "../media/pin".priority_calc($item).".png";
            $title = substr(explode(' ',$item['Title'])[0],0,8);
            $content = $item['Tasks'];
            // <a href='../php/main.php?T_no=$i&User=$user' style='text-decoration:none;color:black'>
            echo "<div class=\"divi\" style=\"background-image:url($noteimg);\">
                    <div class=\"topic\">
                        <label class=\"title\" id='title$i'>$j.$title</label>
                        <img id=\"pin\" src=$pinimg alt=\"pin\">
                    </div>
                    <div class=\"data\">
                        <div class=\"screen\" id='tasks$i'><ul style=\"list-style-type:none;\">";
                        for($k=0;$k<count($content);$k++){
                            echo "
                                <li>$content[$k]</li>
                            ";
                        }
            echo        "</ul></div>
                        <div class=\"control\">
                            <button onclick=\"\">
                                <img src=\"../media/edit.png\" alt=\"\">
                            </button>
                            <button onclick=\"getTasks($i)\">
                                <img src=\"../media/share.png\" alt=\"\">
                            </button>
                            <button onclick=\"\">
                                <a href='../php/main.php?T_no=$i&User=$user' style='text-decoration:none;'>
                                    <img src=\"../media/delete.png\" alt=\"\">
                                </a>
                            </button>
                        </div>
                    </div>
                </div>";
        }
    }
?>