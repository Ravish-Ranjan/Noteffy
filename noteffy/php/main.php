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
        <div class="top" style="height:15%;width:100%;">
            <a href="signUp.php">SIGN UP</a>
        </div>
        <div class="main" style="height:85%;width:100%;">
            <div class="scat" style="height:100%;width:100%;">
                <?php
                function signUp(&$jsonData){
                    if(isset($_POST['User_Name']) && isset($_POST['Password']) && isset($_POST['Password1']) && isset($_POST['Email'])){
                        if($_POST['Password']!==$_POST['Password1']){
                            echo "<script>
                                message('Sign Up failed','message_failure');
                            </script>";
                        }
                        else{
                            $users_count = count($jsonData['Users']);
                            $jsonData['Users'][$users_count]['User_Name'] = $_POST['User_Name'];
                            $jsonData['Users'][$users_count]['Password'] = $_POST['Password'];
                            $jsonData['Users'][$users_count]['Email'] = $_POST['Email'];
                            $jsonData['Users'][$users_count]['Notes'] = array();
                            echo "<script>message('Successfull Logged in','message_success')</script>";
                        }
                    }
                }
                function fetch_store(&$jsonData){
                    $user = -1;
                    $User_count = count($jsonData['Users']);
                    for($i=0;$i<$User_count;$i++){
                        if($jsonData['Users'][$i]['User_Name']=="_ravishranjan_")
                            $user = $i;
                    }
                    if($user===-1)
                        die("User not found");
                    if(isset($_POST['Title']) && isset($_POST['Note']) && isset($_POST['Date'])){
                        $Note_count = count($jsonData['Users'][$user]['Notes']);
                        $jsonData['Users'][$user]['Notes'][$Note_count]['Title'] = $_POST['Title'];
                        // $jsonData['Users'][$user]['Notes'][$Note_count]['Time'] = $_POST['Time'];
                        $jsonData['Users'][$user]['Notes'][$Note_count]['Date'] = $_POST['Date'];
                        $jsonData['Users'][$user]['Notes'][$Note_count]['Content'] = $_POST['Note'];
                    }
                    return $user;
                }
                function display($jsonData,$user){
                    $count = count($jsonData['Users'][$user]['Notes']);
                    $pin = array("../media/pinred.png","../media/pinyellow.png","../media/pingreen.png");
                    $note = array("../media/note1.png","../media/note2.png","../media/note3.png");
                    for ($i=0; $i < $count; $i++){
                        $item = $jsonData['Users'][$user]['Notes'][$i]; 
                        $j = $i+1;
                        $x = rand(0,2);
                        $y = rand(0,2);
                        $title = substr(explode(' ',$item['Title'])[0],0,10);
                        $content = $item['Content'];
                        $visible = substr($content,0,25);
                        echo "
                            <div class=\"divi\" style=\"background-image:url($note[$x]);overflow:hidden\">
                            <div class=\"des\"hidden>
                            <label style=\"overflow:;\">$j.$title</label>
                            <img src=$pin[$y] height=\"55\" width=\"55\">
                            </div>
                            <p>$visible</p>
                            </div>";
                    }
                }
                $storage = file_get_contents("../data/storage.json") or die("Could Not open the file");
                $storage = json_decode($storage,True);
                signUp($storage);
                $user = fetch_store($storage);
                
                display($storage,$user);
                $storage = json_encode($storage);
                file_put_contents("../data/storage.json",$storage);
                ?>
            </div>
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
    </body>
</html>
