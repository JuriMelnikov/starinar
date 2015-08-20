<?php
class Result{
    
    private $results;
    private $connDB;

    public function __construct($connDB)
    {
        $this->connDB=$connDB;
        //echo "<br>Это Result1 класс";
        $sql="SELECT * FROM `ns_results` WHERE 1";
        $res=mysql_query($sql,$connDB) or die("Ошибка выполнения: ".$sql." errors: ".mysql_error());
        while($row=mysql_fetch_array($res,MYSQL_ASSOC)){
            $this->results[]=$row;
        }
       // echo "<br>Инициировали массив results";
        //print_r($this->results);
    }
    /**
    *   возвращает отработанное работником время за месяц
    */
    public function getTime($w_id,$month,$year)
    { 
        foreach ($this->results as $key => $value) {
            if(($value['w_id']==$w_id) && ($value['month']==$month) && ($value['year']==$year)){
               $time+=$value['operate_time'];
            }        
        }   
        return $time;
    }
    /**
    *   возвращает массив для вывода таблицы выполненной работы за неделю 
    */
    public function getWeekTable($w_id,$week,$month,$year)
    { 
        foreach ($this->results as $key => $value) {
            if(($value['w_id']==$w_id) && ($value['week']==$week) && ($value['year']==$year)){
               $res[$key]['t_id']=$value['t_id'];
               $res[$key]['serial']=$value['serial'];
               $res[$key]['order']=$value['order'];
               $res[$key]['model']=$value['model'];
               $res[$key]['section']=$value['section'];
               $res[$key]['operate']=$value['operate'];
               $res[$key]['countDid']=$value['countDid'];
               $res[$key]['payment']=$value['payment'];
               $res[$key]['time']=$value['time'];
               $res[$key]['sum']=$value['payment']*$value['time']*$value['countDid'];
            }        
        }   
        return $res;
    }
     /**
    *   возвращает массив для вывода таблицы выполненной работы за месяц 
    */
    public function getMonthTable($w_id,$month,$year)
    { 
        foreach ($this->results as $key => $value) {
            //echo "<br>$key";
            if(($value['w_id']==$w_id) && ($value['month']==$month) && ($value['year']==$year)){
               $res[$key]['t_id']=$value['t_id'];
               $res[$key]['serial']=$value['serial'];
               $res[$key]['order']=$value['order'];
               $res[$key]['model']=$value['model'];
               $res[$key]['section']=$value['section'];
               $res[$key]['operate']=$value['operate'];
               $res[$key]['countDid']=$value['countDid'];
               $res[$key]['payment']=$value['payment'];
               $res[$key]['time']=$value['time'];
               $res[$key]['sum']=$value['payment']*$value['time']*$value['countDid'];
            }        
        }   
        return $res;
    }
     /**
    *   Добавляет результаты работы швеи в таблицу 
    */
    public function getAdd($w_id,$week,$month,$year)
    { 
        foreach ($this->results as $key => $value) {
            if(($value['w_id']==$w_id) && ($value['week']==$week) && ($value['year']==$year)){
               $res[$key]['t_id']=$value['t_id'];
               $res[$key]['serial']=$value['serial'];
               $res[$key]['order']=$value['order'];
               $res[$key]['model']=$value['model'];
               $res[$key]['section']=$value['section'];
               $res[$key]['operate']=$value['operate'];
               $res[$key]['countDid']=$value['countDid'];
               $res[$key]['payment']=$value['payment'];
               $res[$key]['time']=$value['time'];
               $res[$key]['sum']=$value['payment']*$value['time']*$value['countDid'];
            }        
        }   
        return $res;
    }
    /**
    *   возвращает зарплату работника за месяц и год
    */
    public function getPayment($w_id,$month,$year)
    {
        //echo "<br> Теперь добываем зарплату для $w_id,$month,$year";
        foreach ($this->results as $key => $value) {
            if(($value['w_id']==$w_id) && ($value['month']==$month) && ($value['year']==$year)){
               $payment+=$value['operate_time']*$value['w_id_payment']*$value['countDid'];
            }        
        }
        
        return $payment;
    }


}