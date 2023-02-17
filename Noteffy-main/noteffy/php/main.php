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
                        include "note.php";
                        include "task.php";
                        include "todo.php";
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
           
                $storage = file_get_contents("../data/storage.aes") or die("Could Not open file");
                $storage = decrypt_data($storage);
                $storage = json_decode($storage,true);
                $u = getUserNumber($storage);
                display_todo($storage,$u);
            ?>
        </div>
    </body>
    </html>