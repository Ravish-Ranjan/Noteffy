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
            <label for="Date">Date</label>
            <input type="date" value='2023-07-16' name='Date' id='Date'>
            <label for="Time">Time</label>
            <input type = "time" value='12:12'  id='Time' name='Time'>
            <label for="Title">Title</label>
            <input type="text" name='Title' id='Title' placeholder='Title'>
            <label for="Note">Content</label>
            <textarea style="resize:none;" name='Note' id='Note' rows=20 cols=10></textarea>
            <input type="submit" value="save" id='btn'>
        </form>
    _END;

?>
