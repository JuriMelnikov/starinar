<?php
class Result1{
    
    private $results;
    private $connDB;

    public function __construct($connDB)
    {
        $this->connDB=$connDB;
        echo "<br>Это Result1 класс";
        $sql="SELECT * FROM `ns_results1` WHERE 1";
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
    *   возвращает зарплату работника за месяц и год
    */
    public function getPayment($w_id,$month,$year)
    {
        echo "<br> Теперь добываем зарплату для $w_id,$month,$year";
        foreach ($this->results as $key => $value) {
            if(($value['w_id']==$w_id) && ($value['month']==$month) && ($value['year']==$year)){
               $payment+=$value['operate_time']*$value['w_id_payment']*$value['countDid'];
            }        
        }
        
        return $payment;
    }


}