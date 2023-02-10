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
        <div class="top">
            <img src="../media/noteffytitle.png" id="logo">
            <div id="prof">
                <a href="../HTML/signUp.html" id="prof" style="margin:0 2% 0 2%;">
                    <img src="..\media\goldbody2.png" alt="prof" height="75" >
                    <?php
                        include("hash.php");
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
            <button class="tbs" onclick="openTab(event, 'Notes')">Notes</button>
            <button class="tbs" onclick="openTab(event, 'Tasks')">Tasks</button>
        </div>
        <div class="main" id="Notes">
            <div class="scat">
                <?php
                    include "mailpy.php";
                    function signUp(&$jsonData){
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
                            $email = $jsonData["Users"][$users_count]["Email"];
                            $otp = pymail($email);
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
                            // echo "<script>message('Successfully Logged in','message_success'); window.location.href = window.location.href</script>";
                        }
                    }
                }
                function signIn(&$jsonData){
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
                function getUser(){
                    if(isset($_COOKIE["user"])){
                        return $_COOKIE["user"];
                    }
                    else
                        return " "; 
                }
                function fetch_store(&$jsonData){
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
                function display(&$jsonData,$user){
                    $count = count($jsonData['Users'][$user]['Notes']);
                    for ($i=0; $i < $count; $i++){
                        $item = $jsonData['Users'][$user]['Notes'][$i]; 
                        $j = $i+1;
                        $noteimg = "../media/note".rand(1,3).".png";
                        $pinimg = "../media/pin".rand(1,3).".png";
                        $title = substr(explode(' ',$item['Title'])[0],0,8);
                        $content = $item['Content'];
                        $visible = substr($content,0,25);
                        echo "
                            <div class=\"divi\" style=\"background-image:url($noteimg);\">
                                <div class=\"des\">
                                    <label>$j.$title</label>
                                    <img src=$pinimg>
                                </div>
                                <p>$visible</p>
                            </div>";
                    }
                }
                signUp($storage);
                signIn($storage);
                $m = fetch_store($storage);
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
            <div class="menu" id="comp1" onclick = "compose()">
                <a id="btn1" style="background-color:yellow;">
                    <label style="font-size:30;">Compose</label>
                </a>
            </div>
        </div>
        <div class="main" id="Tasks" >
            <div class="scat" style="background-image:url('../media/wood2.jpg');">
                <?php
                function display_task($jsonData,$user){
                    $count = count($jsonData['Users'][$user]['Notes']);
                    for ($i=0; $i < $count; $i++){
                        $item = $jsonData['Users'][$user]['Notes'][$i]; 
                        $j = $i+1;
                        $noteimg = "../media/note".rand(1,3).".png";
                        $pinimg = "../media/pin".rand(1,3).".png";
                        $title = substr(explode(' ',$item['Title'])[0],0,8);
                        $content = $item['Content'];
                        $visible = substr($content,0,25);
                        echo "
                            <div class=\"divi\" style=\"background-image:url($noteimg);\">
                                <div class=\"des\">
                                    <label>$j.$title</label>
                                    <img src=$pinimg>
                                </div>
                                <p>$visible</p>
                            </div>";
                    }
                }
                ?>
                </div>
            </div>
            <div class="menu" id="comp2" onclick = "testblank()">
                <a id="btn1" style="background-color:teal;">
                    <label style="font-size:30;">Compose</label>
                </a>
            </div>
        </div>
    </body>
</html>