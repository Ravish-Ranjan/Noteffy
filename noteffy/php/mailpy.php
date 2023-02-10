<?php
    function pymail($email){
        $otp = rand(1000,9999);
        exec('python "../python/mail.py" '.$email.' '.$otp.'');  
        return $otp;  
    }
?>  