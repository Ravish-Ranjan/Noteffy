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
            $tasks_storage[$stored_task_no]["User"] = getUserNumber($jsonData);
            $tasks_storage = json_encode($tasks_storage);
            file_put_contents("../data/task.json",$tasks_storage);
            array_splice($jsonData["Users"][$userNumber]["To-do"],$t_no,1);
            echo "<script>window.location.href = 'main.php'</script>";
        }
    }
    function comp_task($i,$jsonData){
        if(isset($_COOKIE['comp_task'])){
            $temp = json_decode($_COOKIE['comp_task'],true);
            if(array_key_exists(getUserNumber($jsonData),$temp)){
                if(array_key_exists($i,$temp[getUserNumber($jsonData)])){
                    return $temp[getUserNumber($jsonData)][$i];
                }
                else
                    return false;
            }
        }
        else
            return false;
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
            $c_task = comp_task($i,$jsonData); //gets the js object containing completed tasks
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
                            <label class=\"title\">$j.$title</label>
                            <img id=\"pin\" src=$pinimg alt=\"pin\">
                        </div>
                        <div class=\"data\">
                            <div class=\"screen\" id='scrn'><ul style=\"list-style-type:none;\">";
                            echo "<form action='main.php' method='post' id='tks$i'>";
                            for($k=0;$k<count($content);$k++){
                                $checked = "";
                                $lineThrough = "";
                                if($c_task!==false && $c_task !==null){
                                    $content[$k] = str_replace("\r","",$content[$k]);
                                    $checked = in_array($content[$k],$c_task)!=false ? $checked."checked" : "";
                                    $lineThrough = in_array($content[$k],$c_task)!=false ? $lineThrough."text-decoration-line:line-through" : "none";
                                }
                                $task = substr($content[$k],3);
                                $id = "tsk$k$i";
                                $task_json = json_decode(file_get_contents("../data/task.json"),true);
                                
                                echo "
                                <input type='checkbox' id='tsk$k$i' name='task$i$k' $checked><label for='tsk$k$i' style=$lineThrough>$content[$k]</label><br>
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
        function getUser(){
            decodedCookie = decodeURIComponent(document.cookie);
            decodedCookie = decodedCookie.split(';');
            for(var i in decodedCookie){
                let c = decodedCookie[i];
                c = c.split('=');
                if(c[0].trim() == 'user_number')
                    return c[1];
            }
            return false;
        }
        function getTask(){
            let user = getUser();
            var obj = {};
            obj[user] = {};
            decodedCookie = decodeURIComponent(document.cookie);
            decodedCookie = decodedCookie.split(';');
            for(var i in decodedCookie){
                let c = decodedCookie[i];
                c = c.split('=');
                if(c[0].trim() == 'comp_task'){
                    obj = JSON.parse(c[1]);
                    return obj;
                }
            }
            return obj;
        }
        function removeTask(user,t,task_no){
            var count = Object.keys(t[user]).length;
            for(j=task_no;j<count-1;j++){
                t[user][j] = t[user][j+1];
            }
            t[user][count-1] = [];
        }


        var user = getUser();
        var task_no;
        var to = document.getElementById('divi3')
        let t = getTask();
        let fm;
            to.addEventListener('click',(e)=>{
                var id = e.target.id;
                if(id!=''){
                var l = document.getElementById(id);
                fm = document.getElementById(l.parentElement.id);
                task_no = fm.id.substring(3);
                if((user in t) && t[user][task_no] === undefined)
                    t[user][task_no] = Array();
                else if(!(user in t)){
                    t[user] = {};
                    t[user][task_no] = Array();
                }
                var temp = document.querySelector('label[for='+id+']');
                
                if(l.checked && temp!=null){
                    temp.style.textDecorationLine = 'line-through';
                    t[user][task_no].push(temp.innerText);
                }
                else if(!l.checked && temp!=null){
                    temp.style.textDecorationLine = 'none';
                    t[user][task_no].pop(t[user][task_no].indexOf(temp.innerText));
                }
            }
            if(fm!=null && fm.length-1 == t[user][task_no].length){
                removeTask(user,t,task_no);
                fm.submit();
            }
            var d = new Date();
            d.setTime(d.getTime()+24*60*60*1000);
            document.cookie = 'comp_task='+JSON.stringify(t)+';expires='+d.toUTCString()+';path=/';
        });
        </script>";
    }
?>