<?php

function show($data){
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}

function sweetAlert($title,$msg = "",$type = "success"){
    $_SESSION['temp_msg'] = $title;
    $_SESSION['temp_msg_secondery'] = $msg;
    $_SESSION['temp_msg_type'] = $type;
}

function get_cart_count(){

    if(isset($_SESSION['cart'])){
        return count($_SESSION['cart']);
    }

    return 0;
}