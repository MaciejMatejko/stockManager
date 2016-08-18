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
        $orderToAdd->setPrice(round($_POST['price'], 2));
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

if($_SERVER["REQUEST_METHOD"]==="GET"){
    if(intval($_GET['quantity'])<=0){
        $jsonRespond=  json_encode(['status'=>'fail', 'reason'=>'quantity is 0 or lesser']);
        echo($jsonRespond);
    }else{
        if(isset($_GET['quantity'])){
            if($price=Order::loadFromDB($conn, $_GET['quantity'])){
                echo($price);
            } 
        }
        else{
            $jsonRespond=  json_encode(['status'=>'fail']);
            echo($jsonRespond);
        }
    }
}

if($_SERVER["REQUEST_METHOD"]==="PUT"){
    parse_str(file_get_contents("php://input"), $data);
    $quantity=$data['quantity'];
    if(Order::sell($conn, $quantity)){
        $jsonRespond=  json_encode(['status'=>'success']);
        echo($jsonRespond);
    }
    else{
        $jsonRespond=  json_encode(['status'=>'fail']);
        echo($jsonRespond);
    }
}


