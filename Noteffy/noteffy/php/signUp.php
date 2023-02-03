<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/media/logo5mix.png" type="image/x-icon">
    <title>Notes</title>
    <style>
        *{
            margin:0;
            padding:0;
        }
        form{
            display:grid;
            grid-template-rows : repeat(6,1fr);
            grid-template-columns:repeat(1,1fr);
            row-gap:10px;
            margin-top:25vh;
            font-family:"Times New Roman";
        }
        #Form_Caption{
            justify-self:center;
        }
        #btn{
            width:20vw;
            height:2em;
            justify-self:center;
            background-color:lime;
            border:1px solid lime;
            box-shadow:-2px 2px 4px black;
            margin-bottom:10px;
        }
    </style>
</head>
<body>
    
</body>
</html>
<?php
    echo <<<_END
    <form action='main.php' method='POST'>
        <span id='Form_Caption'>ADD A NOTE</span>
            <label for="User">User Name</label>
            <input type="text" placeholder='Enter user name' name='User_Name' id='User'>
            <label for="Pass">Create Password</label>
            <input type = "password"   id='Pass' name='Password'>
            <label for="Pass1">Confirm Password</label>
            <input type = "password" id='Pass1' name='Password1'>
            <label for="Email">Email</label>
            <input type="Email" name='Email' id='Email' placeholder='Email'>
            <input type="submit" value="Sign Up" id='btn'>
        </form>
    _END;

?>