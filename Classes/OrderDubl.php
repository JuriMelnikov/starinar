<?php
// Класс соответствует таблице ns_admin
// в которой хранится год, месяц и неделя Ордера
class OrderDubl{

    private $orders;
    private $connDB;

    public function __construct($connDB)
    {
        echo "<br>мы внутри OrderDubl";
        $this->connDB=$connDB;
        $sql="SELECT * FROM `ns_order_dubl` WHERE 1";
        $res=mysql_query($sql,$connDB);
        while($row=mysql_fetch_array($res,MYSQL_ASSOC)){
            $this->orders[]=$row;
        }

    }
    private function reload()
    {
        $sql="SELECT * FROM `ns_order_dubl` WHERE 1";
        $res=mysql_query($sql,$connDB);
        while($row=mysql_fetch_array($res,MYSQL_ASSOC)){
            $this->orders[]=$row;
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
        $o=new Orders($this->connDB);
        if(!$o_id=$o->getIdOrder($order)){
            echo "<br>Не могу определить o_id для $order";
            return false;
        }
        $query="INSERT INTO `ns_order_dubl`(`o_id`,`aYear`,`month`,`aWeek`) 
                VALUES ('$o_id','$year','$month','$week')";
        if(mysql_query($query)){
            $last_od_id=mysql_insert_id();
            $this->reload();
            return $last_od_id;
        }
        else
            return false;
    }

}