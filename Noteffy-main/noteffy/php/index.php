<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../media/logo5mix.png">
    <title>Welcome | Noteffy</title>
    <script>
        
    </script>
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        @font-face {
            font-family: codec;
            src: url('../media/Codec-Cold-Regular-trial.ttf');
        }

        @font-face {
            font-family: codec-extrabold;
            src: url('../media/Codec-Cold-Heavy-trial.ttf');
        }

        @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@600&display=swap');

        ::-webkit-scrollbar {
            width: 9px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 20px;
        }

        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 20px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        .ParaVideo {
            height: 68.49vh;
            padding-bottom: 3.66vw;
            padding-top: 3.66vw;
        }

        .ParaVideo video {
            height: 117%;
            top: 0.73vw;
            right: 0;
            bottom: 0;
            position: fixed;
            z-index: -999;
        }

        .ParaContent {
            background-color: #00a2ff;
            height: 60.88vh;
        }

        .ParaContent2 {
            background-color: #00ff91;
            height: 60.88vh;
        }

        .footer {
            background-color: #141414;
            height: 30.44vh;
        }

        p {
            font-size: 2.19vw;
        }

        .header {
            position: relative;
            top: 0;
            left: 0;
        }

        #gradient-header {
            width: 100%;
            height: 10.65vh;
            position: relative;
            top: 0;
            left: 0;
        }

        #noteffy-logo {
            position: absolute;
            left: 43.92vw;
            top: 0.73vw;
            width: auto;
            height: 7.30vh;
        }

        #sign-up-link {
            position: absolute;
            font-family: codec-extrabold;
            background-color: #ff008a;
            color: white;
            padding: 1.02vw 1.83vw;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            right: 14.64vw;
            top: 0.73vw;
            border-radius: 2.92vw;
        }

        #sign-up-link:hover {
            background-color: #191919;
            transition: 0.5s;
        }

        #log-in-link {
            font-family: codec-extrabold;
            position: absolute;
            color: white;
            padding: 1.02vw 1.83vw;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            right: 5.12vw;
            top: 0.73vw;
            border-radius: 2.92vw;
        }

        #log-in-link:hover {
            border-radius: 2.92vw;
            background-color: #ff008a;
            transition: 0.5s;
        }

        #vl {
            border-left: 0.14vw solid #ffffff;
            height: 7.61vw;
            position: absolute;
            margin-left: 18.30vw;
            margin-top: 5.49vw;
        }

        a {
            font-family: 'Open Sans', sans-serif;
            color: #555;
            text-decoration: none;
            display: inline-block;
        }

        a:hover {
            color: #ffffff;
            transition: 0.5s;
        }

        #footer-links {
            text-align: center;
            padding-top: 5.12vw;
        }

        li {
            display: inline-block;
        }

        ul {
            display: inline-block;
        }

        #address {
            color: #ffffff;
            font-family: 'Open Sans', sans-serif;
            text-align: center;
            font-size: 0.87vw;
        }

        #footer-logo {
            height: 7.61vh;
            width: 9.51vw;
            margin-left: 1.46vw;
            display: inline-block;
        }

        P {
            font-family: codec;
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="../media/gradientHeader.png" id="gradient-header">
        <img src="../media/noteffyTitle.png" id="noteffy-logo">
        <a href="../HTML/signUp.html?flag=1" target="_blank" id="sign-up-link">Sign Up</a>
        <a href="../HTML/signUp.html?flag=0 " target="_blank" id="log-in-link" >Log In</a>
    </div>
    <div class="ParaVideo">
        <video autoplay muted loop>
            <source src="../media/animationVideo.mp4" type="video/mp4">
        </video>
    </div>
    <div class="ParaContent">
        <div class="container">
            <p>some content here for later</p>
        </div>
    </div>
    <div class="ParaContent2">
        <div class="container">
            <p>contact us form for later</p>
        </div>
    </div>
    <div class="footer">
        <div>
            <div id="footer-links">
                <ul>
                    <li><a href="../HTML/signUp.html?flag=0>">Log In</a></li>&nbsp;&nbsp;&nbsp;
                    <li><a href="../HTML/signUp.html?flag=1">Sign Up</a></li>&nbsp;&nbsp;&nbsp;
                    <li><a href="#">About Us</a></li>&nbsp;&nbsp;&nbsp;
                    <li><a href="#">Contact Us</a></li>&nbsp;&nbsp;&nbsp;
                </ul>
            </div>
            <br>
            <p id="address">Add: meri nani ka ghar, Kurla(W), Mumbai, Maharashtra, India</p>
            <div id="footer-logo">
                <img src="../media/noteffyTitleBlack.png" id="footer-logo">
            </div>
        </div>
    </div>
</body>

</html>