<?php
    $email = "ravishranjan2003@gmail.com";
    $main = __DIR__;
    $all = explode("\php",$main)[0];
    $all =  $all."\python\mail.py";
    $type = 1;
    exec("python $all $email $type 1234");
?>