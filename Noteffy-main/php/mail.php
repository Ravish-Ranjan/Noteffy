<?php
    function Email($mail){ // this function mails from php to send otp to user to sign up
        $otp = rand(1000,9999);
        $to = $mail;
        $subject = "Successfully signed in";
        $txt = "
        <div style='font-family: Helvetica,Arial,sans-serif;min-width:1000px;overflow:auto;line-height:2'>
        <div style='margin:50px auto;width:70%;padding:20px 0'>
          <div style='border-bottom:1px solid #eee'>
            <a href='' style='font-size:1.4em;color: #00466a;text-decoration:none;font-weight:600'>Noteffy</a>
          </div>
          <p style='font-size:1.1em'>Hi,</p>
          <p>Thank you for choosing Noteffy. Use the following OTP to complete your Sign Up procedures. OTP is valid for 5 minutes</p>
          <h2 style='background: #00466a;margin: 0 auto;width: max-content;padding: 0 10px;color: #fff;border-radius: 4px;'>$otp</h2>
          <p style='font-size:0.9em;'>Regards,<br />Noteffy</p>
          <hr style='border:none;border-top:1px solid #eee' />
          <div style='float:right;padding:8px 0;color:#aaa;font-size:0.8em;line-height:1;font-weight:300'>
            <p>Noteffy</p>
            <p>Near my <b>ASS</b></p>
            <p>New Delhi</p>
          </div>
        </div>
      </div>
         ";
        $headers = "MIME-Version: 1.0"."\r\n";
        $headers.= "Content-type:text/html;charset=UTF-8"."\r\n";
        $headers.= "From: noteffy.email@gmail.com" . "\r\n"."CC:"."\r\n";
        $result = mail($to,$subject,$txt,$headers);
        if($result){
          return $otp;
        }
        else{
          echo "<script>window.location.href = '../html/signUp.html?errc=invm&activity=signup'</script>";
        }
    }
?>