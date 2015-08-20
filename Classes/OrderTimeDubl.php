<?php
// Класс соответствует таблице ns_admin
// в которой хранится год, месяц и неделя Ордера
class OrderTimeDubl{

    private $orders;
    private $connDB;

    public function __construct($connDB)
    {
        
        $this->connDB=$connDB;
        $sql="SELECT * FROM `ns_order_dubl` WHERE 1";
        $res=mysql_query($sql,$connDB);
        while($row=mysql_fetch_array($res,MYSQL_ASSOC)){
            $this->orders[]=$row;
        }
//echo "<br>мы внутри OrderTimeDubl";
    }
    private function reload()
    {
        $sql="SELECT * FROM `ns_order_dubl` WHERE 1";
        $res=mysql_query($sql,$this->connDB);
        while($row=mysql_fetch_array($res,MYSQL_ASSOC)){
            $this->orders[]=$row;
        }
    }
    private function getA_id($o_id)
    {
        $sql="SELECT `a_id` FROM `ns_admin` WHERE `o_id`='$o_id'";
        $res=mysql_query($sql,$this->connDB);
        while($row=mysql_fetch_array($res,MYSQL_ASSOC)){
            if($res>0){
                return $a_id=$row['a_id'];
            }
            if($res==0){
                return false;
            }
        }
    }
    public function existsOrder($o_id)
    {   
        foreach ($this->orderTime as $key => $value) {
            if(in_array($o_id, $value[$o_id])){
                return true;
            }else{
                return false;
            }
        }
    }
    /**
    *   Добавляет запись в таблицу ns_order_dubl
    *
    */
     public function addOrder($order,$month,$week,$year)
     {
         //echo "<br>OTD:addO:начало";
         $o=new Orders($this->connDB);
        if(!$o_id=$o->getIdOrder($order)){
           // echo "<br>OTD:addO:Не могу определить o_id для $order";
            return false;
        }
        if(!$a_id=$this->getA_id($o_id)){
           // echo "<br>OTD:addO:Не могу определить a_id для $o_id";
            return false;
        }
        $query="INSERT INTO `ns_order_dubl`(`a_id`,`o_id`,`year`,`month`,`week`) 
                VALUES ('$a_id','$o_id','$year','$month','$week')";
       // echo "<br>OT:addO:query:$query";
        if(mysql_query($query,$this->connDB)){
            $last_od_id=mysql_insert_id();
            $this->reload();
            return $last_od_id;
        }else{
            return false;
        }
     }

}