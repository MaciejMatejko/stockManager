<?php
require_once(__DIR__.'/conn.php');

class Order {
    
    private $id;
    private $quantity;
    private $price;
    
        public static function sell(mysqli $conn, $quantity)
    {
        $sql = "DELETE FROM Orders WHERE quantity=$quantity LIMIT 1";
        if($conn->query($sql)){
            return true;
        }
        return false;
    }
    
    public static function loadFromDB(mysqli $conn, $quantity)
    {
        $sql = "SELECT  NULL AS id, NULL AS quantity, NULL AS price, NULL AS total
                FROM dual
                WHERE (@total := 0)
                UNION
                SELECT id, quantity, price, @total := @total + quantity AS total
                FROM Orders
                WHERE @total < $quantity
                GROUP BY id DESC;";
        $result = $conn->query($sql);
        if($result != false){
            if($result->num_rows>0){
                while($row=$result->fetch_assoc()){
                    $ret[]=$row;
                }
            }
        }else{
            return false;
        }
        
        return self::calculatePrice($ret, $quantity);
    }
    
    public static function calculatePrice($array, $quantity)
    {
        $sum=0;
        $price=0;
        if(count($array)===1){
            return round(($array[0]["price"]*1.1), 2);
        }
        else{
            foreach($array as $row){
                if($quantity >= ($sum + $row["quantity"])){
                    $price = $price + ($row["quantity"]*$row["price"]);
                    $sum+=$row["quantity"];
                }else{
                    $price = $price + (($quantity-$sum)*$row["price"]);
                    $sum=$quantity; 
                }
                
            }
            return round(($price/$sum)*1.1, 2);
        }
    }
    
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

