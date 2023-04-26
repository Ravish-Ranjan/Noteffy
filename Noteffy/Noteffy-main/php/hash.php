<?php
$opts = 0;$type = 'aes-256-cbc';
$iv = 'Noteffy-12345678';$dbkey = '7w!z%C*F-JaNdRgUkXn2r5u8x/A?D(G+';

function encrypt_data(&$data,$key1 = ""){ // this function encrypts the user data for security
    global $type,$iv,$opts;
    if($key1==""){
        global $dbkey;
        $encoded = openssl_encrypt($data,$type,$dbkey,$opts,$iv);
    }
    else{
        $encoded = openssl_encrypt($data,$type,$key1,$opts,$iv);
    }
    
    return $encoded;
}
function decrypt_data(&$data,$key1 = ""){ // this function decrypts the data so that it can be used for further uses
    global $type,$iv,$opts;
    if($key1==""){
        global $dbkey;
        $decoded = openssl_decrypt($data,$type,$dbkey,$opts,$iv);
    }
    else
        $decoded = openssl_decrypt($data,$type,$key1,$opts,$iv);
    return $decoded;
}
function hash_name($word,$lim){
    $exp = str_split($word);
    $tot = 0;
    foreach($exp as $letter){
        $tot+=ord($letter);
    }
    return round(1+($tot%$lim));
}
?>