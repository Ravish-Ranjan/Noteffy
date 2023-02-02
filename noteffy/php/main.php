<html>
    <head>
        <title>Main Page</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <style>
            @font-face {
                font-family: Minecraftia;
                src: url("../media/Minecraft.ttf");
            }
            a{
                font-size:2vw;
            }

            body{
                display:flex;
                flex-direction:column;
                height:100%;
                width:100%;
            }
            .main{
                display:flex;
                flex-direction:row;
            }
            .menu{
                display:flex;
                flex-direction:column;
                margin:2%;
                justify-content:;
            }
            /* *{outline:0.2vw solid green;} */
            .divi{
                height:34vh;
                width:11vw;
                padding:0 5% 5% 5%;
                margin:5%;
                filter:drop-shadow(5px 5px 10px rgba(0,0,0,0.5));
                background-repeat:no-repeat;
                background-size:contain;
                display:flex;
                flex-direction:column;
                justfy-content:start;
                position:relative;
            }
            .divi>.des>label{
                font-family:Minecraftia;
                font-size:2vw;
                margin:auto;
                width:max-content;
            }
            .divi>p{
                font-size:2vw;
                white-space:nowrap;
                overflow:hidden;
                height:max-content;
                text-overflow:ellipsis;
            }
            .scat{
                grid-template-columns: repeat(4,1fr);
                overflow-y:scroll;
                display:grid;
                background-image:url("../media/wood.jpg");
                /* background-repeat:no-repeat; */
                background-size:contain;
                box-shadow:20px 20px 40px rgba(0,0,0,0.5) inset;
            }
            @media screen and (min-width:1024px) {
                .scat{grid-template-columns: repeat(4,1fr);}
                .divi{width:11vw;}
            }
            @media screen and (min-width:720px) and (max-width:1023px) {
                .scat{grid-template-columns: repeat(3,1fr);}
                .divi{width:15vw;}
                .divi>.des>label{font-size:3vw;}
                .divi>p{overflow:none; font-size:;}
            }
            @media screen and (max-width:719px) {
                .scat{grid-template-columns: repeat(2,1fr);}
                .divi>.des>label{font-size:3vw;}
                .divi{width:22vw;}
                .divi>p{overflow:none;}
            }
            @keyframes fade{
                from{opacity:0;}
                to{opacity:1;}
            }
            .des{
                display:flex;
                justify-content:;
                width:100%;
                max-height:8vh;
            }
            .menu{
                height:7%;
                padding:1.5rem;
                position:fixed;
                bottom: 20;
                border-radius:3rem;
                right: 20;
                display:flex;
                justify-content:center;
                align-items:center;
                width: 12%;
                background-color:rgba(255,255,255,1);
                border: 3px solid #73AD21;
                
            }
            .menu>a{
                display:flex;
                /* flex-direction:column; */
                justify-content:center;
                align-items:center;
            }
            /* Compose form */
            input[type="date"],input[type="time"],input[type="submit"]{
                font-size:20;
            }
            form{
                animation:fade 0.4s ease-in-out;
                position:absolute;top:2%;right:5%;
                display:grid;/* height:60%; */
                width:40%;z-index:4;background:rgba(0,0,0,0.4);
                font-size:2vw;border-radius:1em;
                border: 2px solid black;
                grid-template-rows : repeat(6,1fr);
                grid-template-columns:repeat(1,1fr);
                row-gap:4px;color:white;
                margin-top:15vh;padding-top:3%;
                font-family:"Times New Roman";
            }
            #Form_Caption{
                justify-self:center;
            }
            #close{
                position:absolute;top:-20px;left:-15px;height:50px;width:50px;border-radius:50%;
                background-color:rgba(255,0,0,0.5);content:'x';color:white;
                transition: background-color 0.2s;
            }
            #close:hover{
                background-color:rgba(255,0,0,0.8);
                transition-timing-function:ease-in-out;
            }
            .scat::webkit-scrollbar,.scat::ms-scrollbar{
                width:10;
                background:#23272e;
            }
            .scat::webkit-scollbar-thumb,.scat::ms-scrollbar-thumb{
                background:#23272e;

            }
        </style>
        <script>
            if ( window.history.replaceState ) {
                window.history.replaceState( null, null, window.location.href );
            }
            function message(msg,type){
                console.log("hello world");
                let container = document.createElement("div");
                container.className = type;
                let content = document.createElement("div");
                content.id = "content";
                content.innerText = msg;

                document.body.insertBefore(container,document.body.firstChild);
                container.appendChild(content);
                setTimeout(()=>{
                    console.log("hello");
                    container.remove();
                },1000);
                return;
            }
            function getRandomArbitrary(min, max) {
                return Math.random() * (max - min) + min;
            }
            function pos() {
                var count = $(".divi").length;
                for (let i = 0; i < count; i++){
                    var styles ={
                        "top":getRandomArbitrary(40,0),
                        "right":getRandomArbitrary(-90,0),
                        "rotate":getRandomArbitrary(-13,13)+"deg"
                    };
                    var obj = document.getElementsByClassName("divi");
                    Object.assign(obj[i].style,styles);
                }
            }
            function closeF(){
                document.querySelector('form').remove();
                document.querySelector("#btn1").setAttribute("onclick","compose()");
            }
            function compose(){  
                let noteform = document.createElement("form");
                noteform.setAttribute("action","main.php");noteform.setAttribute("method","POST");
                noteform.setAttribute("onsubmit","return checkEmpty(this)");
                noteform.innerHTML = "<span id='Form_Caption'>ADD A NOTE</span>\
                <button id = 'close' style=\"font-size:2vw;\" onclick = \"closeF()\">x</button>\
                <label for='Date'>Date</label>\
                <input type='date' value='2023-07-16' name='Date' id='Date'>\
                <label for='Title'>Title</label>\
                <input type='text' name='Title' id='Title' placeholder='Title'>\
                <label for='Note'>Content</label>\
                <textarea style='resize:none;' name='Note' id='Note' rows=10 cols=10></textarea>\
                <input type='submit' value='save' id='btn'>"
                document.querySelector("body").appendChild(noteform);
                document.querySelector("#btn1").toggleAttribute("onclick","");
            }
            function checkEmpty(ele){
                let childs = ele.children,flag = true;
                for(i of childs){
                    if(['INPUT','TEXTAREA'].indexOf(i.nodeName)!=-1 && i.value==''){
                        i.style['border'] = "2px solid darkred";
                        flag = false;
                    }
                    else if(['INPUT','TEXTAREA'].indexOf(i.nodeName)!=-1 && i.value!=''){
                        i.style['border-color'] = "2px solid darkgreen";
                    }
                }
                if(flag){
                    document.querySelector("#btn1").toggleAttribute("onclick","compose()");
                }
                return flag;
            }
        </script>
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
                $storage = file_get_contents("storage.json") or die("Could Not open the file");
                $storage = json_decode($storage,True);
                signUp($storage);
                $user = fetch_store($storage);
                
                display($storage,$user);
                $storage = json_encode($storage);
                file_put_contents("storage.json",$storage);
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
