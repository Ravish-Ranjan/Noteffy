<?php
    function Email($mail){
        $to = $mail;
        $subject = "Successfully signed in";
        $txt = "Sign Up successfull";
        $headers = "From: gaurangtyagi7@gmail.com"."\r\n".
        "CC:ravish4076@rla.du.ac.in";
        mail($to,$subject,$txt,$headers);
    }
?>