<?php
    header("Content-Type:application/json;character=Utf-8");
    include "hash.php";
    $data = array("message"=>"success");
    if(isset($_GET['value'])){
        $data['res'] = decrypt_data($_GET['value'],'');
    }
    else{
        $data["message"] = "failure";
    }
    echo json_encode($data);
?>