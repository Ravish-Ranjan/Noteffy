<?php
    function priority_calc($item){ // this function is to calculate the priority of a task based on given time
        $time = explode(":",$item["Time"])[0];
        $cur = explode(":",Date("h:i"))[0];
        $day = $item["Date"];
        $time = $time%12;
        $dif = date_diff(new DateTime($day),new DateTime("now"));
        $temp = $dif->h+(($dif->d)*24);
        $temp+= ($time-$cur);
        if($temp<=23)
            return 1;
        else if($temp<=47 && $temp>23)
            return 2;
        else
            return 3;
    }
?>