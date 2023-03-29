<?php
    function codeGenerator(){
        $str = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
        $code = substr(str_shuffle($str), 0, 6);
        $code = encrypt_data($code,'');
        return $code;
    }
     function createOrganization(){
        $code = array();
        if(isset($_GET['create'])){
            header("Content-Type:application/json;charcter=Utf-8");
            $jsondata = file_get_contents("../data/Organizations.json");
            $jsondata = json_decode($jsondata, true);
            $random_code = codeGenerator();
            $code["code"] = $random_code;
            $code['situation'] = "code_generated";
            $len = getUserNumber();


            $jsondata["Organizations"][$len]["Admin"] = getUserNumber();
            $jsondata["Organizations"][$len]["group"] = array();
            $jsondata["Organizations"][$len]["code"] = encrypt_data($random_code,'');
            $jsondata = json_encode($jsondata);
            file_put_contents("../data/Organizations.json", $jsondata);
            echo json_encode($code);
            die();
        }
        else{
        $code["situation"] = "code_not_genrated";
        }
    }
?>