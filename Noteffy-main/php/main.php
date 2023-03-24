<?php
    include "hash.php";
    include "priority_calc.php";
    include "note.php";
    include "task.php";
    include "todo.php";
    $storage = file_get_contents("../data/storage.aes") or die("Could Not open the file");
    $storage = decrypt_data($storage);
    $storage = json_decode($storage,True);

    // details
    $details = file_get_contents("../data/Details.json");
    $details = json_decode($details, true);
    
    // alternate
    $alternate = file_get_contents("../data/Data.json");
    $alternate = json_decode($alternate, true);
?>
<?php
    $queries = array();
    // Fetching raw POST object body because content-type is causing parsing issues
    parse_str($_SERVER['QUERY_STRING'], $queries);
    if(isset($queries['signup'])=='true'){
        $raw = file_get_contents("php://input");
        $jsond = json_decode($raw,true) or die(123);
        if ($jsond['Password'] !== $jsond['Password1']) {
                $data = array('Message'=>'failure');echo $data;
            } 
            else if ($jsond['Password'] === $jsond['Password1']) {
                header('Content-Type: application/json;charset=utf-8');
                $users_count = count($details['Users']);
                str_pad($jsond['Username'], 32, '#', STR_PAD_RIGHT);
                $details['Users'][$users_count]['identifier'] = $users_count;
                $details['Users'][$users_count]['User_Name'] = $jsond['Username'];
                $details['Users'][$users_count]['Password'] = encrypt_data($jsond['Password'], str_pad($jsond["Username"], 32, '#', STR_PAD_RIGHT));
                $details['Users'][$users_count]['Email'] = $jsond['Email'];
                $details['Users'][$users_count]['Type'] = false;
                $details['Users'][$users_count]['Organization_Code'] = null;
                $alternate['User_Data'][$users_count]['identifier'] = $users_count;
                $alternate['User_Data'][$users_count]['Notes'] = array();
                $alternate['User_Data'][$users_count]['To-do'] = array();
                // $storage1 = json_encode($storage);
                // $storage1 = encrypt_data($storage1);
                // $storage1 = file_put_contents("../data/storage.aes",$storage1) or die("Could not close file");
                $details = json_encode($details);
                $alternate = json_encode($alternate);
                file_put_contents("../data/Details.json", $details);
                file_put_contents("../data/Data.json", $alternate);
                $respdata = array('Message'=>'success');
                $data = json_encode($respdata);
                echo $data;
        }
        die();
    }
?>
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
        <div class="top" id="dashboard">
            <label id="logo">Your Workstation</label>
            <div id="prof">
                    <img src="../media/logoredq.png" onclick="showmenu()" style="cursor:pointer;margin-right:30;margin-top:30;" alt="prof" height="75">
                    <?php
                        if(getUser()==" "){
                            // echo "<script>window.location.href = 'index.php'</script>";
                        }
                        else{
                            echo "<div  id='sidepanel' >
                            <div class='panel-user' >
                                <img src='../media/logoredq.png' height=100 width=100 alt='logo' style='filter:drop-shadow(2px 2px 5px black);'>
                                <label style='text-decoration:none;color:black;'>Hi, ".getUser()." !</label>
                            </div>
                            <ul>
                                <li><a href='../HTML/chart.html' style='text-decoration:none;'>Scoreboard</a><br></li>
                                <li><a href='../HTML/signUp.html' id='logout' onclick='clearCookies()' style='text-decoration: none;'>Log Out</a></li>
                                <li><a href='#' style='text-decoration: none;' onclick='hidemenu()'>Workspace</a></li>
                                <li><a href='index.php' style='text-decoration: none;'>Home</a></li>
                            </ul>
                            </div>" ;
                            setcookie("user_number",getUserNumber($storage),0,"/");
                        }
                        ?>
            </div>
        </div>
        <div class="tab">
            <button class="tbs" onclick="openTab(event, '0')"><img src="../media/notesWidget.png" id="noteWidgetImage"></button>
            <button class="tbs" onclick="openTab(event, '1')"><img src="../media/taskWidget.png" id="taskWidgetImage"></button>
            <button class="tbs" onclick="openTab(event, '2')"><img src="../media/todoWidget.png" id="bbtWidgetImage"></button>
        </div>
        <div class="main" id="0">
            <div class="scat" id="divi1">
                <?php  
                    signUp($storage);
                    signIn($storage);
                    Delete_Note($storage);
                    $storage = json_encode($storage);
                    $storage = encrypt_data($storage);
                    file_put_contents("../data/storage.aes",$storage) or die("Failed to encode");      
                    //$user = 0;
                    $storage = file_get_contents("../data/storage.aes") or die("Could Not open file");
                    $storage = decrypt_data($storage);
                    $storage = json_decode($storage,true);
                    $alternate = file_get_contents("../data/Data.json");
                    $alternate = json_decode($alternate, true);
                    $user = fetch_store($alternate);
                    display($alternate,$user);
                    $alternate = json_encode($alternate);
                    file_put_contents("../data/Data.json", $alternate);
                ?>
            </div>
            <!-- this div is to let user create more notes -->
            <div class="menu" id="comp1" onclick = "note_compose('','','','')" style="background-color:#f2f2f2;">
                <a id="btn1">
                    <img src="../media/quillpen.png" id="note-compose-button" alt="compose">
                </a>
            </div>
        </div>
        <?php updateNote($storage) ?>
        <div class="main" id="1" >
            <div class="scat" style="background-image:url('../media/background_1.png');background-size:110%;" id="divi2">
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
            <div class="menu" id="comp2" onclick = "task_compose('','','','','')" style="background-color:#f2f2f2;">
                <a id="btn1">
                    <img src="../media/goldenperi.png"id="task-compose-button" alt="compose">
                </a>
            </div>
        </div>
        <?php updateTask($storage)?>
        <div class="main" id="2">
            <div class="scat" style="background-image:url('../media/background_4.png');background-size:110%;" id='divi3'>
            <?php
                $storage = file_get_contents("../data/storage.aes") or die("Could Not open file");
                $storage = decrypt_data($storage);
                $storage = json_decode($storage,true);
                $u = getUserNumber($storage);
                display_todo($storage,$u);
                complete($storage);
                $storage = json_encode($storage);
                $storage = encrypt_data($storage);
                file_put_contents("../data/storage.aes",$storage) or die("Failed to encode");  
            ?>
        </div>
    </body>
<script src="../Script/note.js"></script>
<script src="../Script/tasks.js"></script>
</html>