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
        <script src="../script/compose.js"></script>
        <script src="../script/main.js"></script>
        <script src="../script/message.js"></script>
        
    </head>
    <body onload="pos()">
        <div class="top">
            <img src="../media/noteffytitle.png" id="logo">
            <div id="prof">
                <a href="../HTML/signUp.html" id="prof" style="margin:0 2% 0 2%;">
                <script src="https://cdn.lordicon.com/ritcuqlt.js"></script>
                <lord-icon
                src="https://cdn.lordicon.com/dxjqoygy.json"
                trigger="loop"
                delay="2000"
                stroke="150"
                colors="primary:#121331,secondary:#38d8ba"
                style="width:50px;height:50px">
            </lord-icon>
            <?php
            include("hash.php");
            $storage = file_get_contents("../data/storage.aes") or die("Could Not open the file");
            $storage = decrypt_data($storage);
            $storage = json_decode($storage,True);
            if(getUser($storage)==" "){
                echo "<p>Sign Up</p>";
            }
            else{
                 echo "<p>".getUser($storage)."<br>
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
                
                function signUp(&$jsonData){
                    echo 123;
                    count($jsonData['Users']);
                    if(isset($_POST['Username']) && isset($_POST['Password']) && isset($_POST['Password1']) && isset($_POST['Email'])){
                        if($_POST['Password']!==$_POST['Password1']){
                            echo 1234124;
                            echo "<script>
                                message('Sign Up failed','message_failure');
                            </script>";
                        }
                        else{
                            echo "WHy whyw y";
                            $users_count = count($jsonData['Users']);
                            echo $users_count;
                            str_pad($_POST["Username"],32,' ',STR_PAD_RIGHT);
                            $jsonData['Users'][$users_count]['User_Name'] = $_POST['Username'];
                            $jsonData['Users'][$users_count]['Password'] = encrypt_data($_POST['Password'],str_pad($_POST["Username"],32,' ',STR_PAD_RIGHT));
                            $jsonData['Users'][$users_count]['Email'] = $_POST['Email'];
                            $jsonData['Users'][$users_count]['Notes'] = array();
                            setcookie("user",$_POST['User_Name'],time()+(24*60*60),"/");
                            echo $jsonData['Users'][$users_count];
                            echo "<script>message('Successfull Logged in','message_success'); window.location.href = window.location.href</script>";
                        }
                    }
                }
                function signIn(&$jsonData){
                    if(isset($_POST['User_Name_']) && isset($_POST['Password_'])){
                        $users_count = count($jsonData["Users"]);
                        echo $users_count;
                        for($i = 0;$i < $users_count;$i++){
                            // echo $i.'<br>';
                            if($jsonData["Users"][$i]["User_Name"] === $_POST['User_Name_'] && $jsonData["Users"][$i]["Password"]===encrypt_data($_POST["Password_"],str_pad($_POST["User_Name_"],32,'#',STR_PAD_RIGHT))){
                                echo $jsonData["Users"][$i]["Password"].':'.encrypt_data($_POST["Password_"],str_pad($_POST["User_Name_"],32,'#',STR_PAD_RIGHT));
                                setcookie("user",$jsonData["Users"][$i]["User_Name"]);
                                echo "<script>window.location.href = window.location.href</script>";
                                return ;
                            }
                            else{
                                // die("User not found");
                            }
                        }
                    }

                }
                function getUser(&$jsonData){
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
                    // $userName = "_ravishranjan_";
                    for($i=0;$i<$User_count;$i++){
                        if($jsonData['Users'][$i]['User_Name']==$userName)
                            $user = $i;
                        }
                    if($user==-1)
                    {
                        die(" User not found");
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
                // signUp($storage);
                signIn($storage);
                
                $m = fetch_store($storage);
                $storage = json_encode($storage);
                $storage = encrypt_data($storage);
                file_put_contents("../data/storage.aes",$storage);

                // $user = 0;
                $storage = file_get_contents("../data/storage.aes") or die("Could Not open file");
                $storage = decrypt_data($storage);
                $storage = json_decode($storage,true);
                $user = fetch_store($storage);
                display($storage,$user);
                ?>
            </div>
            <div class="menu">
                <a id="btn1" onclick = "compose()">
                    <script src="https://cdn.lordicon.com/ritcuqlt.js"></script>
                    <lord-icon
                    src="https://cdn.lordicon.com/wloilxuq.json"
                    trigger="loop"
                    delay="2000"
                    stroke="100"
                    colors="primary:#121331,secondary:#66d7ee"
                    style="rotate:40deg;width:70px;height:70px">
                    </lord-icon>
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
            <div class="menu">
                <a id="btn1" onclick = "">
                    <script src="https://cdn.lordicon.com/ritcuqlt.js"></script>
                    <lord-icon
                    src="https://cdn.lordicon.com/wloilxuq.json"
                    trigger="loop"
                    delay="2000"
                    stroke="100"
                    colors="primary:#121331,secondary:#66d7ee"
                    style="rotate:40deg;width:70px;height:70px">
                    </lord-icon>
                    <label style="font-size:30;">Compose</label>
                </a>
            </div>
        </div>
    </body>
</html>