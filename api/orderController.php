<?php

require_once(__DIR__.'/src/conn.php');
require_once(__DIR__.'/src/Order.php');

if($_SERVER["REQUEST_METHOD"]==="POST"){
    if(intval($_POST['quantity'])<=0 || floatval($_POST['price'])<=0.00){
        $jsonRespond=  json_encode(['status'=>'fail', 'reason'=>'quantity or price is 0 or lesser']);
        echo($jsonRespond);
    }
    else{
        $orderToAdd = new Order();
        $orderToAdd->setQuantity($_POST['quantity']);
        $orderToAdd->setPrice($_POST['price']);
        if($result=$orderToAdd->saveToDB($conn)){
            $jsonRespond=  json_encode(['status'=>'success']);
            echo($jsonRespond);
        }
        else{
            $jsonRespond=  json_encode(['status'=>'fail']);
            echo($jsonRespond);
        }
    } 
}
