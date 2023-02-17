<html>
    <head>
        <title>Main Page</title>

        <!-- stylesheets -->
        <link rel="stylesheet" href="../Stylesheets/message.css">
        <link rel="stylesheet" href="../Stylesheets/main.css">
        <link rel="stylesheet" href="../Stylesheets/compose.css">

        <!-- favicon -->
        <link rel="shortcut icon" href="../media/logo5mix.png" type="image/x-icon">

        <!-- scripts -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <script src="../Script/compose.js"></script>
        <script src="../Script/main.js"></script>
        <script src="../Script/message.js"></script>
        
    </head>
    <body onload="pos()">
    <!-- <a href="https://web.whatsapp.com://send?text='hello'">Send</a> -->
        <!-- this div is for the top bar of the main page to display logo and user status-->
        <div class="top">
            <img src="../media/noteffytitle.png" id="logo">
            <div id="prof">
                <a href="../HTML/signUp.html" id="prof" style="margin:0 2% 0 2%;">
                    <img src="..\media\goldbody2.png" alt="prof" height="75" >
                    <?php
                        include("hash.php");
                        include("priority_calc.php");
                        $storage = file_get_contents("../data/storage.aes") or die("Could Not open the file");
                        $storage = decrypt_data($storage);
                        $storage = json_decode($storage,True);
                        if(getUser()==" "){
                            echo "<p>Sign Up</p>";
                        }
                        else{
                             echo "<p>".getUser()."<br>
                             <a href = '../html/signUp.html' id = 'logout' onclick = 'clearCookies()'>Log Out</a></p>" ;
                        }
                    ?>
                </a>
            </div>
        </div>
        <div class="tab">
            <button class="tbs" onclick="openTab(event, '0')">Notes</button>
            <button class="tbs" onclick="openTab(event, '1')">Tasks</button>
            <button class="tbs" onclick="openTab(event, '2')">To-do</button>
        </div>
        <div class="main" id="0">
            <div class="scat">
                <?php
                function signUp(&$jsonData){ // this function signups the new user and save there auth data for further use
                    if(isset($_POST['Username']) && isset($_POST['Password']) && isset($_POST['Password1']) && isset($_POST['Email'])){
                        if($_POST['Password']!==$_POST['Password1']){
                            echo "<script>
                            message('Sign Up failed','message_failure');
                            </script>";
                        }
                        else if($_POST['Password']===$_POST['Password1']){
                            $users_count = count($jsonData['Users']);
                            str_pad($_POST["Username"],32,'#',STR_PAD_RIGHT);
                            $jsonData['Users'][$users_count]['User_Name'] = $_POST['Username'];
                            $jsonData['Users'][$users_count]['Password'] = encrypt_data($_POST['Password'],str_pad($_POST["Username"],32,'#',STR_PAD_RIGHT));
                            $jsonData['Users'][$users_count]['Email'] = $_POST['Email'];
                            $jsonData['Users'][$users_count]['Notes'] = array();
                            $jsonData['Users'][$users_count]['To-do'] = array();
                            $email = $jsonData["Users"][$users_count]["Email"];
                            $type = 1;
                            $data = '';
                            $command = "python C:/Users/DELL/OneDrive/Documents/GitHub/Noteffy/Noteffy-main/noteffy/python/mail.py $email $type $data";
                            $otp = (int)exec($command);
                            echo <<<_END
                                <script>
                                    //Insert Some loading screen here
                                    let val = prompt("Enter otp");
                                    if(val!=$otp){
                                         // Changed
                                        window.location.href = '../html/signUp.html?err=iotp&activity=signup&mail=$email';
                                    }
                                </script>
                            _END;
                            
                            if(isset($_COOKIE["user"])){
                                echo "<script>clearCookies();</script>";
                            }
                            setcookie("user",$_POST['Username'],time()+(24*60*60),"/");
                            echo "<script>message('Successfully Logged in','message_success'); window.location.href = window.location.href</script>";
                        }
                    }
                }
                function signIn(&$jsonData){ //this function uses the saved data to verify and let the old user sign in
                    if(isset($_POST['User_Name_']) && isset($_POST['Password_'])){
                        $users_count = count($jsonData["Users"]);
                        $errc = "uid";$name = "";
                        for($i = 0;$i < $users_count;$i++){
                            // echo $i.'<br>';
                            if($jsonData["Users"][$i]["User_Name"] === $_POST['User_Name_']){
                                if($jsonData["Users"][$i]["Password"]===encrypt_data($_POST["Password_"],str_pad($_POST["User_Name_"],32,'#',STR_PAD_RIGHT))){
                                    setcookie("user",$jsonData["Users"][$i]["User_Name"]);
                                    echo "<script>window.location.href = window.location.href</script>";
                                    return ;
                                }
                                else{
                                    $name = $jsonData["Users"][$i]["User_Name"];
                                    $errc = "upwd";
                                }
                            }
                        }
                        echo '<script>window.location.href="../html/signUp.html?err='.$errc.'&name='.$name.'&activity='.($errc=='uid'?"signup":"signin").'";</script>';
                        return;
                        
                        }
                    }
                function getUser(){ // this function fetches the user from the data
                    if(isset($_COOKIE["user"])){
                        return $_COOKIE["user"];
                    }
                    else
                        return " "; 
                }
                function Delete_Note(&$jsonData){
                    if(isset($_GET["N_no"]) && isset($_GET["User"])){
                        $n_no = $_GET["N_no"];
                        $User = $_GET["User"];
                        $userName = getUser($jsonData);
                        for($i=0;$i<count($jsonData["Users"]);$i++){
                            if($jsonData["Users"][$i]["User_Name"]== $userName && $i==$User){
                                array_splice($jsonData["Users"][$User]["Notes"],$n_no,1);
                                echo "<script>window.location.href = '../php/main.php'</script>";
                                return;
                            }
                        }
                        echo "<Script>window.location.href = '../HTML/error.html'</script>";
                    }
                }
                function fetch_store(&$jsonData){ // this function fetches and stores the new note created by by the user
                    $user = -1;
                    $User_count = count($jsonData['Users']);
                    $userName = getUser($jsonData);
                    //Do not disturb until later
                    echo ' ';
                    
                    for($i=0;$i<$User_count;$i++){
                        if($jsonData['Users'][$i]['User_Name']==$userName)
                          $user = $i;
                    }
                    if(isset($_POST['Title']) && isset($_POST['Note']) && isset($_POST['Date'])){
                        $Note_count = count($jsonData['Users'][$user]['Notes']);
                        $jsonData['Users'][$user]['Notes'][$Note_count]['Title'] = $_POST['Title'];
                        $jsonData['Users'][$user]['Notes'][$Note_count]['Date'] = $_POST['Date'];
                        $jsonData['Users'][$user]['Notes'][$Note_count]['Content'] = $_POST['Note'];
                    }
                    return $user;
                }
                function display(&$jsonData,$user){ // this function displays the user's notes in a scatter manner
                    $count = count($jsonData['Users'][$user]['Notes']);
                    for ($i=0; $i < $count; $i++){
                        $item = $jsonData['Users'][$user]['Notes'][$i];
                        $j = $i+1;
                        $noteimg = "../media/note".rand(1,3).".png";
                        $pinimg = "../media/pin".rand(1,3).".png";
                        $title = substr(explode(' ',$item['Title'])[0],0,5);
                        $content = $item['Content'];
                        $visible = substr($content,0,25);
                        echo "<div class=\"divi\" style=\"background-image:url($noteimg);\">
                                <div class=\"topic\">
                                    <label id=\"topic\">$j.$title</label>
                                    <img id=\"pin\" src=$pinimg alt=\"pin\">
                                </div>
                                <div class=\"data\">
                                    <div class=\"screen\">
                                        $content
                                    </div>
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
                                            <a href='../php/main.php?N_no=$i&User=$user' style='text-decoration:none;'>
                                                <img src=\"../media/delete.png\" alt=\"\">
                                            </a>
                                        </button>
                                    </div>
                                </div>
                            </div>";
                    }
                }
                signUp($storage);
                signIn($storage);
                Delete_Note($storage);
                $storage = json_encode($storage);
                $storage = encrypt_data($storage);
                file_put_contents("../data/storage.aes",$storage) or die("Failed to encode");
                
                // $user = 0;
                $storage = file_get_contents("../data/storage.aes") or die("Could Not open file");
                $storage = decrypt_data($storage);
                $storage = json_decode($storage,true);
                $user = fetch_store($storage);
                display($storage,$user);
                ?>
            </div>
            <!-- this div is to let user create more notes -->
            <div class="menu" id="comp1" onclick = "note_compose()">
                <a id="btn1" style="background-color:yellow;">
                    <label style="font-size:30;">Compose</label>
                </a>
            </div>
        </div>
        <div class="main" id="1" >
            <div class="scat" style="background-image:url('../media/background_4.png');">
                <?php
                function Delete_task(&$jsonData){ // this function is to let user delete a task
                    if(isset($_GET["T_no"]) && isset($_GET["User"])){
                        $t_no = $_GET["T_no"];
                        $User = $_GET["User"];
                        $userName = getUser($jsonData);
                        for($i=0;$i<count($jsonData["Users"]);$i++){
                            if($jsonData["Users"][$i]["User_Name"]== $userName && $i==$User){
                                array_splice($jsonData["Users"][$User]["To-do"],$t_no,1);
                                // echo "<script>window.location.href = '../php/main.php'</script>";
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
                                    <label id=\"topic\">$j.$title</label>
                                    <img id=\"pin\" src=$pinimg alt=\"pin\">
                                </div>
                                <div class=\"data\">
                                    <div class=\"screen\"><ul style=\"list-style-type:none;\">";
                                    for($k=0;$k<count($content);$k++){
                                        echo "
                                            <li>$content[$k]</li>
                                        ";
                                    }
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
                $u = task_compose($storage);
                Delete_task($storage);
                $storage = json_encode($storage);
                $storage = encrypt_data($storage);
                file_put_contents("../data/storage.aes",$storage) or die("Failed to encode");
                $storage = file_get_contents("../data/storage.aes") or die("Could Not open file");
                $storage = decrypt_data($storage);
                $storage = json_decode($storage,true);
                display_task($storage,$u);
                ?>
                </div>
            </div>
            <!-- this div is for user to create more tasks -->
            <div class="menu" id="comp2" onclick = "task_compose()">
                <a id="btn1" style="background-color:teal;">
                    <label style="font-size:30;">Compose</label>
                </a>
            </div>
        </div>
        <div class="main" id="2">
            <div class="scat" style="background-image:url('../media/background_6.png');">
            <?php
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

                        // calculating priority 
                        date_default_timezone_set("Asia/Kolkata");

                        $j = $i+1;
                        $noteimg = "../media/note".rand(1,3).".png";
                        $pinimg = "../media/pin".priority_calc($item).".png";
                        $title = substr(explode(' ',$item['Title'])[0],0,8);
                        $content = $item["Tasks"];

                        echo "<div class=\"divi\" style=\"background-image:url($noteimg);\">
                                <div class=\"topic\">
                                    <label id=\"topic\">$j.$title</label>
                                    <img id=\"pin\" src=$pinimg alt=\"pin\">
                                </div>
                                <div class=\"data\">
                                    <div class=\"screen\"><ul style=\"list-style-type:none;\">";
                                    for($k=0;$k<count($content);$k++){
                                        $task = substr($content[$k],3);
                                        echo "
                                        <input  type='checkbox' id='tsk$i'><label for='tsk$i' onclick='strikeThrough(this)'>$content[$k]</label><br>
                                        ";
                                    }
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
                $storage = file_get_contents("../data/storage.aes") or die("Could Not open file");
                $storage = decrypt_data($storage);
                $storage = json_decode($storage,true);
                $u = getUserNumber($storage);
                display_todo($storage,$u);
            ?>
        </div>
    </body>
    </html>