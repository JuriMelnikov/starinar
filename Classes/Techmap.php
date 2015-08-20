<?php
class Techmap{

    private $techmaps;
    private $connDB;
    private $lastId;

    public function __construct($connDB)
    {
        $this->connDB=$connDB;
        //echo "<br>Это Techmap класс";
        $sql="SELECT * FROM `ns_techmap` WHERE 1";
        $res=mysql_query($sql,$connDB) or die("Ошибка выполнения: ".$sql." errors: ".mysql_error());
        while($row=mysql_fetch_array($res,MYSQL_ASSOC)){
            $this->techmaps[]=$row;
        }
    }
    /**
    *   инициирует поля по id из таблицы ns_techmap доступные через гетеры
    *   
    *   возвращает true при успехе, и false при неудаче
    */

    public function getTime($t_id)
    {
        foreach ($this->techmaps as $row => $cols) { 
            //echo "<br>".$cols['t_id']."=>".$cols['time']; 
            if($cols['t_id']==$t_id){
                return $cols['time'];
            }
        }
        return false;

    }
    /**
    *   Добавляем запись в таб. ns_techmap
    *   Проверяет наличие названия модели и раздела, если нет, то добавляет
    */

    public function addTechmap($serial,$descript,$model,$time,$section)
    {   
        //echo "<br>Techmap:addTechmap:model=$model";
         $instModel=new ModelsList($this->connDB);
         if(!$ml_id=$instModel->getId($model)){
           // echo "<br>Модели $model нет в базе -> добавим";
           if(!$ml_id=$instModel->addModel($model)){
           // echo "<br>Модель $model не добавлена";
           }
        }
       // echo "<br>Techmap:addTechmap:section=$section";
        $instSection=new SectionsList($this->connDB);
        if(!$sl_id=$instSection->getId($section)){
          //  echo "<br>Раздела $section нет в базе -> добавим";
            if(!$sl_id=$instSection->addSection($section)){
          //      echo "<br>Ошибка добавления $section";
            }
         }

            $sql="INSERT INTO `ns_techmap`( `serial`, `descript`, `ml_id`, `time`, `sl_id`) VALUES(
            '$serial',
            '$descript',
            '$ml_id',
            '$time',
            '$sl_id')";
   // echo "<br>Выполняме запрос $sql";
             $res=mysql_query($sql,$this->connDB)or die("Ошибка выполнения: ".$sql." errors: ".mysql_error());
             if ($res > 0) {
                $this->lastId=mysql_insert_id();
            //    echo "<br>Модель $model добавлена в базу";
                return true;
             }else{
                return false;
             }
         
    }
    public function updateTechmap($id,$serial,$descript,$model,$time,$section)
    {
        $instModel=new ModelsList($this->connDB);
        if($ml_id=$instModel->setId($model)){
            $ml_id=$instModel->addModel($model);
        }
        $instSection=new SectionsList($this->connDB);
        if($instSection->setId($section)){
            $ml_id=$instSection->getId();
        }else{
            $instSection->addModel($section);
            $sl_id=$instSection->lastId;
        }
        
        $sql="UPDATE `ns_techmap` SET 
            `serial`='$serial',
            `descript`='$descript',
            `ml_id`='$ml_id',
            `time`='$time',
            `sl_id`='$sl_id'
            WHERE `t_id`='$id'";
//echo "sql=".$sql;
        $res=mysql_query($sql,$this->connDB) or die("Ошибка выполнения: ".$sql." errors: ".mysql_error());
        if (0 == $res) return false;
        if ($res > 0) return true;
    }
    public function deleteTechmap($id)
    {
        $sql="DELETE FROM `ns_techmap` WHERE `t_id`='$id'";
        $res=mysql_query($sql,$this->connDB) or die("Ошибка выполнения: ".$sql." errors: ".mysql_error());
        if (0 == $res) return false;
        if ($res > 0) return true;
    }
    

}