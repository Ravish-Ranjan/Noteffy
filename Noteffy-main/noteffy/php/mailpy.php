<?php
    function pymail($email){ // this function calls python mailing function from command line args to mail otp
        $otp = rand(1000,9999);
        exec('python "../python/mail.py" '.$email.' '.$otp.'');  
        return $otp;  
    }
?>  