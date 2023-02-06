<?php
$opts = 0;$type = 'aes-256-cbc';
$iv = 'Noteffy-12345678';$dbkey = '7w!z%C*F-JaNdRgUkXn2r5u8x/A?D(G+';

function encrypt_data(&$data,$key1 = ""){
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
function decrypt_data(&$data,$key1 = ""){
    global $type,$iv,$opts;
    if($key1==""){
        global $dbkey;
        $decoded = openssl_decrypt($data,$type,$dbkey,$opts,$iv);
    }
    else
        $decoded = openssl_decrypt($data,$type,$key1,$opts,$iv);
    return $decoded;
}
?>