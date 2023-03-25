<?php
    function percent($i,$jsonData){
        if(isset($_COOKIE['percent'])){
            $temp = json_decode($_COOKIE['percent'],true);
            if(array_key_exists(getUserNumber(),$temp)){
                if(array_key_exists("$i",$temp[getUserNumber()])){
                    return $temp[getUserNumber()]["$i"]."% task completed";
                } 
                else
                    return "0% task completed";
            } else
            return "0% task completed";
        }
    }
    function complete(&$jsonData){
        $userNumber = getUserNumber();
        if(isset($_POST['Task_no']))
            $t_no = $_POST['Task_no'];
        else
            return;
        $flag = true;
        for($i=0;$i<count($jsonData["User_Data"][$userNumber]["To-do"][$t_no]["Tasks"]);$i++){
            if(!isset($_POST["task$t_no$i"])){
                $flag = false;
                break;
            }
        }
        if($flag){
            $tasks_storage = file_get_contents("../data/task.json");
            $tasks_storage = json_decode($tasks_storage,true);
            $stored_task_no = count($tasks_storage);
            $tasks_storage[$stored_task_no] = $jsonData["User_Data"][$userNumber]["To-do"][$t_no];
            $tasks_storage[$stored_task_no]["User"] = getUserNumber();
            $tasks_storage = json_encode($tasks_storage);
            file_put_contents("../data/task.json",$tasks_storage);
            array_splice($jsonData["User_Data"][$userNumber]["To-do"],$t_no,1);
            echo "<script>window.location.href = 'main.php'</script>";
        }
    }
    function comp_task($i,$jsonData){
        if(isset($_COOKIE['comp_task'])){
            $temp = json_decode($_COOKIE['comp_task'],true);
            if(array_key_exists(getUserNumber(),$temp)){
                if(array_key_exists($i,$temp[getUserNumber()])){
                    return $temp[getUserNumber()][$i];
                }
                else
                    return false;
            }
        }
        else
            return false;
    }
    function display_todo($jsonData,$user){
        $count = count($jsonData['User_Data'][$user]['To-do']);
        for ($i=0; $i < $count; $i++){
            $c_task = comp_task($i,$jsonData); //gets the js object containing completed tasks
            $item = $jsonData['User_Data'][$user]['To-do'][$i]; 
            date_default_timezone_set("Asia/Kolkata");
            if($item["Date"] === (date("Y-m-d")) && $item['Priority']!=0){
                $j = $i+1;
                $noteimg = "../media/newNote".priority_calc($item).".png";
                $pinimg = "../media/pin".priority_calc($item).".png";
                $title = $item['Title'];
                $content = $item["Tasks"]; //<label class=\"title\">$j.$title</label>
                sanitize_array($content);
            $percent = percent($i, $jsonData);
                echo "<div class=\"divi\" style=\"background-image:url($noteimg);\" id='$j' title='$percent'>
                        <div class=\"topic\">
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
                echo        "</ul></div>
                            <div class=\"control\">
                                <button onclick=\"\">
                                    <img title='edit the note' src=\"../media/edit.png\" alt=\"\">
                                </button>
                                <button onclick=\"\">
                                    <a href='https://web.whatsapp.com/' style='text-decoration:none;'>
                                        <img title='copy the to-do list to clipboard' src=\"../media/share.png\" alt=\"\">
                                    </a>
                                </button>
                                <button onclick=\"\">
                                    <a href='../php/main.php?T_no=$i&User=$user' style='text-decoration:none;'>
                                        <img title='delete the to-do list' src=\"../media/delete.png\" alt=\"\">
                                    </a>
                                </button>
                            </div>
                        </div>
                    </div>";
            }
            // else{
            //     echo "<script>window.location.href = 'main.php?T_no=$i</script>";
            // }
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
        function getPercent(){
            let user = getUser();
            var percent = {};
            percent[user] = {};
            decodedCookie = decodeURIComponent(document.cookie);
            decodedCookie = decodedCookie.split(';');
            for(var i in decodedCookie){
                let c = decodedCookie[i];
                c = c.split('=');
                if(c[0].trim() == 'percent'){
                    percent = JSON.parse(c[1]);
                    return percent;
                }
            }
            return percent;
        }
        function removePercent(user,p,task_no){
            var count = Object.keys(p[user]).length;
            for(j=parseInt(task_no);j<count-1;j++){
                p[user][j] = p[user][j+1];
            }
            p[user][count-1] = 0;
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
            for(j=parseInt(task_no);j<count-1;j++){
                t[user][j] = t[user][j+1];
            }
            t[user][count-1] = [];
        }


        var user = getUser();
        var task_no;
        var to = document.getElementById('divi3')
        let t = getTask();
        let p = getPercent();
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
                if((user in p) && p[user][task_no] === undefined)
                    p[user][task_no] = 0;
                else if(!(user in p)){
                    p[user] = {};
                    p[user][task_no] = 0;
                }
                var temp = document.querySelector('label[for='+id+']');
                
                if(l.checked && temp!=null && fm!=null){
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
                removePercent(user,p,task_no);
                fm.submit();
            }
            var d = new Date();
            d.setTime(d.getTime()+24*60*60*1000);
            var divi = fm.parentElement;
            while(divi.className!='divi'){
                divi = divi.parentElement;
            }
            p[user][task_no] = (t[user][task_no].length*100/(fm.length-1)).toPrecision(2);
            divi.setAttribute('title',p[user][task_no]+'% task completed');
            document.cookie = 'percent='+JSON.stringify(p)+';expires='+d.toUTCString()+';path=/';
            document.cookie = 'comp_task='+JSON.stringify(t)+';expires='+d.toUTCString()+';path=/';
        });
        </script>";
    }
?>