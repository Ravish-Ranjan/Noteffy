<?php
    $oper = $_GET['op'];
    $otplist = file_get_contents(realpath("../data/otps.json"));
    $otplist = json_decode($otplist,true);

    $respjson = array("Message"=>"none");
    switch($oper){
        case 'generate':
            global $respjson;
            header('Content-Type: application/json;charset=utf-8');
            $uname = $_GET['Usern'];$email = $_GET['Email'];
            if(!isset($_GET['Usern']) or !isset($_GET['Email'])){
                $respjson['Message'] = 'no username or email';
                break;
            }
            $otp = rand(1000,9999);
            $size = count($otplist['OTPs']);
            $otplist['OTPs'][$size]['Usern'] = $uname;$otplist['OTPs'][$size]['Email'] = $email;
            $otplist['OTPs'][$size]['OTP'] = $otp;
            //Standardized for OS
            exec("py ".realpath("..\python\mail.py")." $email 1 $otp") or exec("python ".realpath("../python/mail.py")." $email 1 $otp");
            $respjson['Message'] = 'success';
            break;
        case 'validate':
            global $respjson;
            header('Content-Type: application/json;charset=utf-8');
            $uname = $_GET['Uname'];$email = $_GET['Email'];$otp = $_GET['OTP'];
            $respjson = array();
            if(!isset($_GET['Uname']) or !isset($_GET['Email']) or !isset($_GET['OTP'])){
                $respjson['Message'] = 'username,email or otp missing';
                break;
            }
            $flag = false;
            for($i = 0;$i < count($otplist['OTPs']);$i++){
                if($otplist['OTPs'][$i]['Usern']===$uname){
                    if($otp==$otplist['OTPs'][$i]['OTP']){
                        $flag = true;break;
                    }
                }
            }
            if($flag){
                $respjson['Message'] = 'otp matched';
            }
            else{
                $respjson['Message'] = 'otp unmatched';
            }
            break;
        case 'delete':
            global $respjson;
            header('Content-Type: application/json;charset=utf-8');
            $uname = $_GET['Uname'];
            if(!isset($_GET['Uname'])){
                $respjson['Message'] = 'deletion failure';
            }
            $size = count($otplist['OTPs']);
            $flag = false;
            for($i = 0;$i < $size;$i++){
                if($otplist['OTPs'][$i]['Usern']==$uname){
                    array_splice($otplist['OTPs'],$i,1,array());
                    $flag = true;break;
                }
            }
            if(!$flag){
                $respjson['Message'] = 'deletion unsuccessful';
            }
            else{
                $respjson['Message'] = 'deletion successful';
            }
            break;
    }
    echo json_encode($respjson);
    $otplist1 = json_encode($otplist);
    $otplist1 = file_put_contents(realpath("../data/otps.json"),$otplist1);
?>