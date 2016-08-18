<?php

require_once(__DIR__.'/src/conn.php');
require_once(__DIR__.'/src/Order.php');

if($_SERVER["REQUEST_METHOD"]==="POST"){
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
