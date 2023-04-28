<?php
    include "initial.php";
    include_once "hash.php";
    include "priority_calc.php";
    include "note.php";
    include "task.php";
    include "todo.php";
    include "admin.php";

    
?>
<?php
    $queries = array();
    // Fetching raw POST object body because content-type is causing parsing issues
    if(isset($_SERVER['QUERY_STRING']))
        parse_str($_SERVER['QUERY_STRING'], $queries);
    $details = file_get_contents("../data/Details.json");
    $details = json_decode($details, true);
    signUp($queries);
    signIn($details);
    $profilePicImg = getAvatar($details);
    allowAdmin($details);
    $details = json_encode($details);
    file_put_contents("../data/Details.json", $details);
?>
<html>
    <head>
    <title>Main Page</title>
    
    <!-- stylesheets -->
    <link rel="stylesheet" href="../Stylesheets/message.css">
    <link rel="stylesheet" href="../Stylesheets/main.css">
    <link rel="stylesheet" href="../Stylesheets/admin.css">
    <link rel="stylesheet" href="../Stylesheets/compose.css">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="http://fontawesome.github.io/Font-Awesome/assets/font-awesome/css/font-awesome.css"> 
    
    <!-- favicon -->
    <link rel="shortcut icon" href="../media/logo5mix.png" type="image/x-icon">
    
    <!-- scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="../Script/compose.js"></script>
    <script src="../Script/message.js"></script>
    <script defer src="../Script/main.js"></script>
    <script defer src="../Script/admin.js"></script>
</head>
<body onload="pos()">
    <div class="main-parent-wrapper">
        <!-- admin panel -->
        <div class="admin-panel" id="toAdmingo">
            <div id="unlock-images">
                <img src="../media/arrowImg.png" id="arrow-image">
                <img src="../media/quillPenBlack.png" id="quill-black">
            </div>
                <?php
                    $orgs = file_get_contents("../data/Organizations.json");
                    $orgs = json_decode($orgs, true);         
                    $flag = createClass($details, $orgs);
                    createAdminTask($details,$orgs);
                    $orgs1 = json_encode($orgs);
                    file_put_contents("../data/Organizations.json", $orgs1);
                    if($flag=="classroom created" || $flag == "classroom joined"){
                        echo "<script>message('success','message_success')</script>";
                    }
                    else if(!$flag && (isset($_POST['ClassCode']) || isset($_POST['JClassCode']))){
                        echo "<script>message('invalid class code or you are already part of the workspace','error')</script>";
                    }
                    $logon = hash_name(getUser(),AssetType::Logo);
                    $colors = array("red","teal","yellow");
                    $logoc = $profilePicImg===false ? "logo".$colors[$logon] : "uploads/logo".$profilePicImg;
                ?>
            <div id="admin-control-panel">
                <div id="button-info-container">
                    <button id="unlock-button" onclick="switchAdmin()">Unlock</button>
                    <p id="unlock-text-1">You haven't unlocked the create feature as of now!</p>
                    <p id="unlock-text-2">Do you wish to activate admin privileges?</p>
                </div>
                <div id="top-container">
                    <img src="../media/<?php echo $logoc; ?>q.png" id="user-admin-logo" onclick="showAdminMenu()">
                    <?php
                    if (!isset($_COOKIE['user_number'])) {
                        // echo "<script>window.location.href = 'index.php'</script>";
                    } 
                    else{
                        echo 
                        "<div  id='sidepanel-admin' >
                            <div class='panel-user-admin' >
                                <img src='../media/".$logoc."q.png' height=80 width=80 alt='logo' style='margin-left: 20;filter:drop-shadow(2px 2px 5px black);'>
                                <label style='text-decoration:none;color:black;'>Hi, " . getUser() . " !</label>
                            </div>
                            <ul>
                                <li><a href='../HTML/control.html' style='text-decoration:none;'>Control</a><br></li>
                                <li><a href='index.php' style='text-decoration: none;'>Home</a></li>
                                <li><a style='text-decoration: none; cursor:pointer;' onclick='hideAdminMenu()'>Back</a></li>
                            </ul>
                        </div>";
                    }
                    ?>
                    <div class="admin-ctrls">
                        <button id="admin-nav-button-1" onclick="revealWorkspacePanel()"><img src="../media/workspaceWidget.png" id="workspaceBBT"></button>
                        <button id="admin-nav-button-2" onclick="revealToDoPanel()"><img src="../media/todoWidget.png" id="todoBBT"></button>
                    </div>
                    <div class=""></div>
                </div>
                <div id="todo-admin-panel">
                    <h1 id="todo-message">Yay, you got no tasks!</h1>
                    <!-- this div will show the to-do's assigned & needs to complete in other workspaces-->
                </div>
                <div id="admin-workspace-panel">
                    <?php
                        $orgs = file_get_contents("../data/Organizations.json");
                        $orgs = json_decode($orgs, true);
                        displayClass($orgs);
                        $orgs1 = json_encode($orgs);
                        file_put_contents("../data/Organizations.json", $orgs1);
                        ?>
                    <!-- this div will show workpaces the user made & joined other -->
                </div>
                <div class="compose" id="admin-compose-bbt" onclick="class_compose('','','','')"></div>
            </div>
        </div>
        <!-- screen scroll slider  -->
        <div class="snapper">
            <a href="#wrapper" id="snapper">></a>
            <a href="#toAdmingo" id="snapper"><</a>
        </div>
        <!-- user panel -->
        <div class="user-panel" id="wrapper">
            <div class="top" id="dashboard">
                <label id="logo">Your Workstation</label>
                <div class="search-box">
                    <input type="text" class="searchTerm" id="search" placeholder="What you lookin' for ?">
                    </button>
                </div>
                <div id="prof">
                    <img src="../media/<?php echo $logoc; ?>q.png" onclick="showmenu()" style="cursor:pointer;margin-right:30;margin-top:30;" alt="prof" height="75">
                    <?php
                        if (!isset($_COOKIE['user_number'])) {
                            // echo "<script>window.location.href = 'index.php'</script>";
                        } 
                        else {
                            echo "<div  id='sidepanel' >
                            <div class='panel-user' >
                            <img src='../media/".$logoc."q.png' height=80 width=80 alt='logo' style='margin-left: 20;filter:drop-shadow(2px 2px 5px black);'>
                            <label style='text-decoration:none;color:black;'>Hi, " . getUser() . " !</label>
                            </div>
                            <ul>
                            <li><a href='../HTML/chart.html' style='text-decoration:none;'>Dashboard</a><br></li>
                            <li><a href='index.php' style='text-decoration: none;'>Home</a></li>
                            <li><a style='text-decoration: none;cursor:pointer;' onclick='hidemenu()'>Back</a></li>
                            <li><a  id='logout' onclick='clearCookies()' style='text-decoration: none;cursor:pointer'>Log Out</a></li>
                            </ul>
                            </div>";
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
                        $details = file_get_contents("../data/Details.json");
                        $details = json_decode($details, true);
                        $details = json_encode($details);
                        file_put_contents("../data/Details.json", $details);
                        //$user = 0;
                        $alternate = file_get_contents("../data/Data.json");
                        $alternate = json_decode($alternate, true);
                        Delete_Note($alternate);
                        $user = fetch_store($alternate);
                        display($alternate, $user);
                        storeEvents();
                    ?>
                </div>
                <!-- this div is to let user create more notes -->
                <div class="menu" id="comp1" onclick="note_compose('','','','')" style="background-color:#f2f2f2;">
                    <a id="btn1">
                        <img src="../media/quillpen.png" id="note-compose-button" alt="compose">
                    </a>
                </div>
            </div>
            <?php updateNote($alternate) ?>
            <div class="main" id="1">
                <div class="scat" style="background-image:url('../media/background_1.png');background-size:110%;" id="divi2">
                    <?php
                        $alternate = json_encode($alternate);
                        file_put_contents("../data/Data.json", $alternate);
                        $alternate = file_get_contents("../data/Data.json");
                        $alternate = json_decode($alternate, true);
                        $u = task_compose($alternate);
                        Delete_task($alternate);
                        display_task($alternate, $u);
                        $alternate = json_encode($alternate);
                        file_put_contents("../Data/Data.json", $alternate);
                    ?>
                </div>
            </div>
            <!-- this div is for user to create more tasks -->
            <div class="menu" id="comp2" onclick="task_compose('','','','','')" style="background-color:#f2f2f2;">
                <a id="btn1">
                    <img src="../media/goldenperi.png" id="task-compose-button" alt="compose">
                </a>
            </div>
                <?php
                    $alternate = file_get_contents("../Data/Data.json");
                    $alternate = json_decode($alternate, true);
                    updateTask($alternate);
                    $alternate = json_encode($alternate);
                    file_put_contents("../data/Data.json", $alternate);
                ?>
            <div class="main" id="2">
            <div class="scat" style="background-image:url('../media/background_4.png');background-size:110%;" id='divi3'>
                <?php
                    $alternate = file_get_contents("../data/Data.json");
                    $alternate = json_decode($alternate, true);
                    $u = getUserNumber();
                    display_todo($alternate, $u);
                    complete($alternate);
                    $alternate = json_encode($alternate);
                    file_put_contents("../data/Data.json", $alternate);
                ?>
            </div>
        </div>
    </div>
</div>
</body>
<script src="../Script/note.js"></script>
<script src="../Script/tasks.js"></script>
</html>