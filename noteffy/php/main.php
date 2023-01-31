<html>
    <head>
        <title>Main Page</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <style>
            @font-face {
                font-family: Minecraftia;
                src: url("../media/Minecraft.tff");
            }
            a{
                text-decoration:none;
                color:black;
            }
            body{
                display:flex;
                flex-direction:column;
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
                height:26vh;
                width:11vw;
                padding:0 5% 5% 5%;
                margin:5%;
                filter:drop-shadow(5px 5px 10px rgba(0,0,0,0.5));
                background-repeat:no-repeat;
                background-size:contain;
                display:grid;
                position:relative;
            }
            .divi p{
                /* width:5vw; */
            }
            .divi>.des>label{
                font-family:Minecraftia;
                font-size:1.5vw;
                margin:auto;
                width:max-content;
            }
            .divi>p{
                font-size:20;
                white-space:nowrap;
                overflow:hidden;
                text-overflow:ellipsis;
            }
            .scat{
                grid-template-columns: repeat(4,1fr);
                overflow-y:scroll;
                display:grid;
                background-image:url("../media/wood.jpg");
                background-size:contain;
            }
            @media screen and (min-width:1024px) {
                .scat{grid-template-columns: repeat(4,1fr);}
                .divi{width:11vw;}
            }
            @media screen and (min-width:720px) and (max-width:1023px) {
                .scat{grid-template-columns: repeat(3,1fr);}
                .divi{width:17vw;}
                .divi>.des>label{font-size:3vw;}
                .divi>p{overflow:none; font-size:;}
            }
            @media screen and (max-width:719px) {
                .scat{grid-template-columns: repeat(2,1fr);}
                .divi>.des>label{font-size:3vw;}
                .divi{width:22vw;}
                .divi>p{overflow:none;}
            }
            .des{
                display:flex;
                justify-content:;
                width:100%;
                max-height:8vh;
            }
            #btn{
                height:40px;
                width:auto;
                background-color:lime;
                box-shadow:-2px 2px 5px black;
            }
        </style>
        <script>
            function getRandomArbitrary(min, max) {
                return Math.random() * (max - min) + min;
            };
            function pos() {
                var count = $(".divi").length;
                for (let i = 0; i < count; i++){
                    var styles ={
                        "top":getRandomArbitrary(60,0),
                        "right":getRandomArbitrary(-90,0),
                        "rotate":getRandomArbitrary(-13,13)+"deg"
                    };
                    var obj = document.getElementsByClassName("divi");
                    Object.assign(obj[i].style,styles);
                }
            };
        </script>
    </head>
    <body onload="pos()">
        <div class="top" style="height:10%;width:100%;"></div>
        <div class="main" style="height:90%;width:100%;">
            <div class="scat" style="height:100%;width:90%;">
                <?php
                function fetch_store(&$jsonData){
                    $user = -1;
                    if(isset($_POST['Title'])!=null && isset($_POST['Note']) && isset($_POST['Date'])!=null && isset($_POST['Time'])!=null){
                        $User_count = count($jsonData['Users']);
                        for($i=0;$i<$User_count;$i++){
                            if($jsonData['Users'][$i]['User_Name']=="Gaurang Tyagi"){
                                $Note_count = count($jsonData['Users'][$i]['Notes']);
                                $jsonData['Users'][$i]['Notes'][$Note_count]['Title'] = $_POST['Title'];
                                $jsonData['Users'][$i]['Notes'][$Note_count]['Time'] = $_POST['Time'];
                                $jsonData['Users'][$i]['Notes'][$Note_count]['Date'] = $_POST['Date'];
                                $jsonData['Users'][$i]['Notes'][$Note_count]['Content'] = $_POST['Note'];
                                $user = $i;
                                break;
                            }
                        }
                        if($user===-1)
                            die("User not found");
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
                        $y = rand(0,2);;
                        $title = $item['Title'];
                        $content = $item['Content'];
                        $visible = substr($content,0,25);
                        echo <<<_END
                            <a href="..HTML/index.html"><div class = "divi" style="background-image:url($note[$x]);overflow:hidden">
                            <div class="des">
                            <label>$j.$title</label>
                            <img src=$pin[$y] height="55" width="55">
                            </div>
                            <p>$visible</p>
                            </div></a>;
                        _END;
                    }
                }
                $storage = file_get_contents("storage.json") or die("Could Not open the file");
                $storage = json_decode($storage,True);
                $user = fetch_store($storage);
                if($user===-1)
                    $user = 0;
                
                display($storage,$user);
                $storage = json_encode($storage);
                file_put_contents("storage.json",$storage);
                ?>
            </div>
            <div class="menu"style="height:90%;width:10%;">
                <button id="btn" onclick="redirect()">Compose</button>
            </div>
        </div>
    </body>
    <script src="../Script/script1.js"></script>
</html>
