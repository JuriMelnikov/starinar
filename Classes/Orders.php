<?php
class Orders{
    private $orders;
    private $order;
    private $connDB;
    private $lastId=0;

    public function __construct($connDB)
    {
       // echo "<br>Orders:Мы в сонструкторе Orders";
        $this->connDB=$connDB;
        $sql="SELECT * FROM `ns_orders` WHERE 1";
        $res=mysql_query($sql,$connDB);
        while($row=mysql_fetch_array($res,MYSQL_ASSOC)){
            $this->orders[]=$row;
        }
       // echo "<br>Orders:отработали конструктор.";
    }

    private function reload(){
       $sql="SELECT * FROM `ns_orders` WHERE 1";
        $res=mysql_query($sql,$connDB);
        while($row=mysql_fetch_array($res,MYSQL_ASSOC)){
            $this->orders[]=$row;
        }
    }
    private  function existsOrder($orderName)
    {   
//echo "<br>Orders:это функция existsOrder";
        foreach ($this->orders as $key => $value) {
            if($value['order']==$orderName){
//echo "<br>Orders: ордер есть!";
                return $value['o_id'];
            }else{ 
//echo "<br>Orders:нету такого ордера $orderName";
                return false;
            }
        }
    }
      /**
    *   Возвращает имя ордера по o_id или false
    *
    */
    public function getOrderName($o_id)
    {
        foreach ($this->orders as $row => $cols) {  
           // echo "<br>".$cols[p_id]."=>".$cols['order'];
            if($cols['o_id']==$o_id){
                return $cols['order'];
            }
        }
        //echo "<br>Нет такого ордера: $o_id";
        return false;
    }
   /**
    *   Возвращает имя ордера по o_id или false
    *
    */
    public function getIdOrder($name)
    {
        foreach ($this->orders as $row => $cols) {  
           // echo "<br>".$cols[p_id]."=>".$cols['order'];
            if($cols['order']==$name){
                return $cols['o_id'];
            }
        }
        //echo "<br>Нет такого ордера: $name";
        return false;
    }
    /**
    *   Добавляет имя ордера по имени
    *
    */
    public function addOrder($name)
    {
        //echo "<br>O:addO: !";
        if(!$o_id=$this->existsOrder($name)){
         $sql="INSERT INTO `ns_orders`(`order`) VALUES ('$name')";
         //echo "<br>sql=".$sql;
            $res=mysql_query($sql,$this->connDB);
            $this->lastId=mysql_insert_id();
        }else{ 
            $res=0;
        }
        if (0 == $res){
           // echo "<br> Добавить имя ордера не удалось. ".mysql_error(); 
            return false;
        }
        if ($res > 0){
           // echo "<br>O:addO:Добавили название ордера $name"; 
            $this->reload(); 
            return true;
        }
    }
    
    public function updateOrder($name, $id)
    {
        if(!existsOrder($name)){
            $sql="UPDATE `ns_orders` SET `order`='$name' WHERE `o_id`='$id'";
            return $res=mysql_query($sql,$this->connDB);
        }
        if (0 == $res) return false;
        if ($res > 0) {$this->reload();return true;}
    }
    public function deleteOrder($id)
    {
        $sql="DELETE FROM `ns_orders` WHERE `o_id`='$id'";
        $res=mysql_query($sql,$this->connDB);
        if (0 == $res) return false;
        if ($res > 0) {$this->reload();return true;}
    }
    public function getLastId()
    {
        return $this->lastId;
    }
}