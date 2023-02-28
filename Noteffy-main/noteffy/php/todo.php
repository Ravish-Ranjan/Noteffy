<?php
    function complete(&$jsonData){
        $userNumber = getUserNumber($jsonData);
        if(isset($_POST['Task_no']))
            $t_no = $_POST['Task_no'];
        else
            return;
        $flag = true;
        for($i=0;$i<count($jsonData["Users"][$userNumber]["To-do"][$t_no]["Tasks"]);$i++){
            if(!isset($_POST["task$t_no$i"])){
                $flag = false;
                break;
            }
        }
        if($flag){
            $tasks_storage = file_get_contents("../data/task.json");
            $tasks_storage = json_decode($tasks_storage,true);
            $stored_task_no = count($tasks_storage);
            $tasks_storage[$stored_task_no] = $jsonData["Users"][$userNumber]["To-do"][$t_no];
            $tasks_storage = json_encode($tasks_storage);
            file_put_contents("../data/task.json",$tasks_storage);
            array_splice($jsonData["Users"][$userNumber]["To-do"],$t_no,1);
            echo "<script>window.location.href = 'main.php'</script>";
        }
    }
    // This function gives the index of the user in the json file
    function getUserNumber($jsonData){
        for($i=0;$i<count($jsonData["Users"]);$i++){
            if($jsonData["Users"][$i]["User_Name"]==getUser($jsonData)){
                return $i;
            }
        }
        echo "<script>window.location.href='../HTML/error.html'</script>";
    }
    function display_todo($jsonData,$user){
        $count = count($jsonData['Users'][$user]['To-do']);
        for ($i=0; $i < $count; $i++){
            $item = $jsonData['Users'][$user]['To-do'][$i]; 
            date_default_timezone_set("Asia/Kolkata");
            if($item["Date"] === (date("Y-m-d"))){
                
                // calculating priority 
                $j = $i+1;
                $noteimg = "../media/note".rand(1,3).".png";
                $pinimg = "../media/pin".priority_calc($item).".png";
                $title = substr(explode(' ',$item['Title'])[0],0,8);
                $content = $item["Tasks"];
                
    
                echo "<div class=\"divi\" style=\"background-image:url($noteimg);\" id='$j' >
                        <div class=\"topic\">
                            <label id=\"topic\">$j.$title</label>
                            <img id=\"pin\" src=$pinimg alt=\"pin\">
                        </div>
                        <div class=\"data\">
                            <div class=\"screen\" id='scrn'><ul style=\"list-style-type:none;\">";
                            echo "<form action='main.php' method='post' id='tks$i'>";
                            for($k=0;$k<count($content);$k++){
                                $task = substr($content[$k],3);
                                $id = "tsk$k$i";
                                $task_json = json_decode(file_get_contents("../data/task.json"),true);
                                
                                echo "
                                <input type='checkbox' id='tsk$k$i' name='task$i$k'><label for='tsk$k$i'>$content[$k]</label><br>
                                ";
                            }
                            echo "<input type='hidden' value='$i' name='Task_no'>";
                            echo "</form>";
                echo        "<ul></div>
                            <div class=\"control\">
                                <button onclick=\"\">
                                    <img src=\"../media/edit.png\" alt=\"\">
                                </button>
                                <button onclick=\"\">
                                    <a href='https://web.whatsapp.com/' style='text-decoration:none;'>
                                        <img src=\"../media/share.png\" alt=\"\">
                                    </a>
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
        // adds a line through the tasks that are completed
        echo "
        <script>
        var to = document.getElementById('divi')
        let fm;
        let counter=0;
            to.addEventListener('click',(e)=>{
                var id = e.target.id;
                if(id!=''){
                var l = document.getElementById(id);
                fm = document.getElementById(l.parentElement.id);
                var temp = document.querySelector('label[for='+id+']');
                
                if(l.checked && temp!=null){
                    temp.style.textDecorationLine = 'line-through';
                    counter++;
                }
                else if(temp!=null){
                    temp.style.textDecorationLine = 'none';
                    counter--;
                }
            }
            if(fm!=null && counter==fm.length-1)
                fm.submit();
        });
        </script>";
    }
?>