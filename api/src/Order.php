<?php

class Order {
    
    private $id;
    private $quantity;
    private $price;
    
    public function __construct() {
        $this->id = -1;
        $this->quantity = null;
        $this->price = null;
    }
    
    public function getId()
    {
        return $this->id;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }
    
    public function saveToDB(mysqli $conn)
    {
        if($this->id === -1){
            $sql = "INSERT INTO Orders (quantity, price) VALUES ('{$this->getQuantity()}', '{$this->getPrice()}')";
            if($conn->query($sql)){
                $this->id= $conn->insert_id;
                return true;
            }
            return false;
        }
        else{
            $sql = "UPDATE Orders SET quantity = '{$this->getQuantity()}', price = '{$this->getPrice()}' WHERE id = {$this->getId()}";
            if($conn->query($sql) === true){
                return true;
            }
            else{
                return false;
            }
        }
    }


}

