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
    *   возвращает данные для функции faCheckOrder
    *
    */
    public function checkOrder($value)
    {
      $week=(int)$value->week;
      $month=(int)$value->month;
      $year=(int)$value->year;
      $order=mysql_real_escape_string(trim((string)$value->order));
      $model=mysql_real_escape_string(trim((string)$value->mName));
      $sl_id=(int)$value->sl_id;

      $i=0;
      foreach ($this->results as $key => $row) {
        if($row['week']==$week AND 
            $row['month']==$month AND 
              $row['year']==$year AND 
                $row['order_name']==$order AND 
                  $row['model']==$model AND 
                    $row['sl_id']==$sl_id ){
          $data["List"][$i]=array(
                                "family"=>$row["family"],
                                "name"=>$row["name"],
                                "serial"=>$row["serial"],
                                "descript"=>$row["operate"],
                                "countDid"=>$row["countDid"]
          );
        }
        $i++;
      }
      return $data;
    }
    /**
    *   возвращает массив для вывода таблицы выполненной работы за неделю 
    */
    public function getWeekTable($w_id,$week,$month,$year)
    { 
        $i=0;
        $sql="SELECT * FROM `ns_results` WHERE `w_id`='$w_id' AND `week`='$week' AND `year`='$year' ORDER BY date DESC";
               //echo $sql;
       $result=mysql_query($sql,$this->connDB) or die("Ошибка выполнения: ".$sql." errors: ".mysql_error());
       
       while($value=mysql_fetch_array($result,MYSQL_ASSOC)){
           $res['data'][$i]['r_id']=$value['r_id'];
           $res['data'][$i]['t_id']=$value['t_id'];
           $res['data'][$i]['serial']=$value['serial'];
           $res['data'][$i]['order']=$value['order_name'];
           $res['data'][$i]['model']=$value['model'];
           $res['data'][$i]['section']=$value['section'];
           $res['data'][$i]['operate']=$value['operate'];
           $res['data'][$i]['countDid']=$value['countDid'];
           $res['data'][$i]['payment']=$value['w_id_payment'];
           $res['data'][$i]['time']=$value['operate_time'];
           $res['data'][$i]['sum']+=$value['w_id_payment']*$value['operate_time']*$value['countDid'];
           $sumTime+=$value['operate_time'];
           $sumPayment+=$value['w_id_payment']*$value['operate_time']*$value['countDid'];
           $i++;
       }
            $res['sumTime']=round($sumTime,2);
            $res['sumPayment']=round($sumPayment,2);
        if($result > 0){
            $res['status']=true;
            return $res;
        }else return false; 
        
    }
     /**
    *   возвращает массив для вывода таблицы выполненной работы за месяц 
    */
    public function getMonthTable($w_id,$month,$year)
    { 
        $i=0;
        $sql="SELECT * FROM `ns_results` WHERE `w_id`='$w_id' AND `month`='$month' AND `year`='$year' ORDER BY date DESC";
               //echo $sql;
       $result=mysql_query($sql,$this->connDB) or die("Ошибка выполнения: ".$sql." errors: ".mysql_error());
       
       while($value=mysql_fetch_array($result,MYSQL_ASSOC)){
           $res['data'][$i]['r_id']=$value['r_id'];
           $res['data'][$i]['t_id']=$value['t_id'];
           $res['data'][$i]['serial']=$value['serial'];
           $res['data'][$i]['order']=$value['order_name'];
           $res['data'][$i]['model']=$value['model'];
           $res['data'][$i]['section']=$value['section'];
           $res['data'][$i]['operate']=$value['operate'];
           $res['data'][$i]['countDid']=$value['countDid'];
           $res['data'][$i]['payment']=$value['w_id_payment'];
           $res['data'][$i]['time']=$value['operate_time'];
           $res['data'][$i]['sum']=$value['w_id_payment']*$value['operate_time']*$value['countDid'];
           $sumTime+=$value['operate_time'];
           $sumPayment+=$value['w_id_payment']*$value['operate_time']*$value['countDid'];
           $i++;
       }
            $res['sumTime']=round($sumTime,2);
            $res['sumPayment']=round($sumPayment,2);
        if($result > 0){
            $res['status']=true;
            return $res;
        }else return false; 
    }
     /**
    *   Добавляет результаты работы швеи в таблицу 
    */
    public function getAdd($args)
    { 
        extract($args);

        $sql="INSERT INTO `ns_results`(`t_id`,`a_id`,`o_id`,`order_name`,`m_id`, `ml_id`, `model`, `sl_id`, `serial`, `section`, `w_id`,`family`,`name`,`w_id_payment`,`operate`,`operate_time`, `date`, `week`, `month`, `year`, `countDid`) 
                             VALUES ('$t_id','$a_id','$o_id','$order','$m_id','$ml_id','$model_name','$sl_id','$serial','$section_name','$w_id','$family','$name','$payment','$descript','$time','$date_now','$week', '$month','$year','$countDid')";
        $res=mysql_query($sql,$this->connDB) or die("Ошибка выполнения Result:getAdd ".$sql." errors: ".mysql_error());
        if($res>0) 
            return true;
        else 
            false;  
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