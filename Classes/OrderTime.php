<?php
// Класс соответствует таблице ns_admin
// в которой хранится год, месяц и неделя Ордера
class OrderTime{

    private $orders;
    private $connDB;

    public function __construct($connDB){
        $this->connDB=$connDB;
//echo "<br>Это сласс OrderTime.php<br>";
        $sql="SELECT * FROM `ns_admin` WHERE 1";
        $res=mysql_query($sql,$connDB) or die("<br>Ошибка выполнения: ".$sql." errors: ".mysql_error());
        while($row=mysql_fetch_array($res,MYSQL_ASSOC)){
            $this->orders[]=$row;
        }
    }
    private function reload()
    {
        $sql="SELECT * FROM `ns_orders` WHERE 1";
        $res=mysql_query($sql,$connDB);
        while($row=mysql_fetch_array($res,MYSQL_ASSOC)){
            $this->orders[]=$row;
        }
    }
    private function getA_id($o_id)
    {
        foreach ($this->orders as $key => $value) {
            if($value['o_id']==$o_id){
                return $value['a_id'];
            }else{
                return false;
            }
        }
    }
    private function existsOrder($a_id)
    {   
        foreach ($this->orders as $key => $value) {
            if($value['a_id']==$a_id){
                return true;
            }else{
                return false;
            }
        }
    }
    /**
    *   Добавляет новый ордер в ns_admin (a_id), тогда и в ns_orders (o_id==a_id)
    *   или ns_order_dubl (od_id->o_id) и выход.
    *   Связывает ордер с моделями: 
    *   таблицы ns_models и ns_counts добавляет массив 
    *   моделей и каунтов, которые ассоциированны с a_id(o_id)
    */
    public function addOrder($vars)
    {  
        extract($vars);
        
            $o=new Orders($this->connDB);
            if(!$o->addOrder($order)){
               // echo "<br>Не могу добавить название $order в таблицу ns_orders.";
               return false;
            }
        //echo "<br>o_id=".   
         $o_id=$o->getLastId();
             // }
        // Добавляем ордер и время
        $query="INSERT INTO `ns_admin`(`o_id`,`aYear`,`month`,`aWeek`) 
                VALUES ('$o_id','$year','$month','$week')";
        if(mysql_query($query,$this->connDB)){
           // echo "<br>OT:addO: $query";
            $last_a_id=mysql_insert_id();
            $this->reload();
            // добавляем модели из ml_ids с количеством из counts
            $m=new Models($this->connDB);
            //$c=new Counts($this->connDB);
            
            foreach ($models as $key => $model) {
              //      echo "<br>model=$model";
                if(!$m->addModel($last_a_id,$model,$counts[$key])){
                    echo "<br>Не могу добавить модель с количеством к ордеру $order";
                    return false;
                }
            }
            return $last_a_id;
        }else{
            //echo "<br>Не могу добавить время для ордера $o_id";
            return false;
        }
     }
    /**
    *   возвращает имя ордера и массивы связанных с ним 
    *   моделей с количеством.
    */
    public function getOrder($a_id)
    {
        $o=new Orders($this->connDB);
        if(!$order=$o->getOrderName($a_id)){
            //echo "<br>Не могу получить имя ордера по $a_id";
            return false;
        }
        $m=new Models($this->connDB);
        $models=$m->getModels($a_id);
        return array(
                        'order' => $order,
                        'models'=>$models,
                     );
    }
}
