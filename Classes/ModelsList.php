<?php
class ModelsList{
    private $models=array();
    private $model;
    private $connDB;
    private $lastId=null;

    public function __construct($connDB){
        $this->connDB=$connDB;
       // echo "Это класс ModelsList.php<br>";
       // echo "<br>Инициируем массив моделей в поле models";
        $sql="SELECT * FROM `ns_model_list` WHERE 1";
        $res=mysql_query($sql,$connDB) or die("<br>Ошибка выполнения: ".$sql." errors: ".mysql_error());
        while($row=mysql_fetch_array($res,MYSQL_ASSOC)){
            $this->models[]=$row;
        }
        //print_r($this->models);
        // foreach ($this->models as $key => $value) {
        //     foreach ($value as $key => $list) {
        //         echo $list;
        //     }
            
        // }
    }

    /**
    *   Проверяет существование модели с именем $modelName
    *   в поле $models. Возвращяет true или false
    */
    private function existsModel($modelName)
    {   
       // echo "<br>Посмотрим, есть ли модель $modelName";
        foreach ($this->models as $row => $cols) {  
            if($cols['mName']==$modelName){
               // echo "<br>existsModel:есть такая модель";
                return true;
            }
        }
        //echo "<br>existsModel: нет такой модели";
        return false;
    }

    /**
    *   Перезаписывает массив моделей в поле $models;
    */
    private function setModels()
    {
        unset($this->models);
        //echo '<br> setModels';
        $sql="SELECT * FROM `ns_model_list` WHERE 1";
        $res=mysql_query($sql,$this->connDB) or die("Ошибка выполнения: ".$sql." errors: ".mysql_error());
        while($row=mysql_fetch_array($res,MYSQL_ASSOC)){
            $this->models[]=$row;
        }
        if($res>0){
            //echo "<br>Обновили список моделей";
            return true;
        }else{
           // echo "<br>Список моделей не обновлен.";
            return false;
        }
    }
     /**
    *   Возвращает имя модели $mName для $ml_id или false
    *   
    */

   public function getNameModel($ml_id)
    { 
        foreach ($this->models as $row => $cols) {  
            if($cols['ml_id']==$ml_id){
                return $cols['mName'];
            }
        }
       // echo "<br>Нет такой модели: $ml_id";
        return false;
    }
    /**
    *   Возвращает id модели, или false
    */

   public function getId($modelName)
    { 
        foreach ($this->models as $row => $cols) {  
            if($cols['mName']===$modelName){
                return $cols['ml_id'];
            }
        }
       // echo "<br>Нет такой модели: $modelName";
        return false;
    }
    /**
    *   Возвращает название модели по id
    *   или false - ошибка
    */
    public function getModel($id)
    {
        $sql="SELECT `mName` FROM `ns_model_list` WHERE `ml_id`='$id'";
            $res=mysql_query($sql,$this->connDB) or die("Ошибка выполнения: ".$sql." errors: ".mysql_error());
            $row=mysql_fetch_array($res,MYSQL_ASSOC);
        if (0 == $res) return false;
        if ($res > 0) return $row['mName'];

    }

    /**
    *   Добавляем имя модели в таблицу
    *   Обновляет массив в $models
    *   Возвращает true или false
    */
    public function addModel($name)
    {
       // echo "<br>ModelsList:addModel:name ='".$name."'<br>";
        if(!$this->existsModel($name)){
          //  echo "Пииишем в базу модель $name";
            $sql="INSERT INTO `ns_model_list`(`mName`) VALUES ('$name')";
            $res=mysql_query($sql,$this->connDB) or die("Ошибка выполнения: ".$sql." errors: ".mysql_error());
            $this->lastId=mysql_insert_id();
            if ($res > 0) {
               // echo "<br>Добавили модель с ml_id=$this->lastId";
                if(!$this->setModels()){
               //     echo "<br>Ошибка при обновлении списка моделей";
                }
                return $this->lastId;
            }
        }else{
           // echo "<br>Модель $name не добавлена";
            return false;
        }
    }
    public function updateModel($name, $id)
    {
        if(!$this->existsModel($name)){
            $sql="UPDATE `ns_model_list` SET `mName`='$name' WHERE `ml_id`='$id'";
        $res=mysql_query($sql,$this->connDB) or die("Ошибка выполнения: ".$sql." errors: ".mysql_error());
        if ($res > 0) {
            $this->setModels();
            return true;
        }
        }else{
            return false;
        }   
    }

    public function deleteModel($id)
    {
        $sql="DELETE FROM `ns_model_list` WHERE `ml_id`='$id'";
        $res=mysql_query($sql,$this->connDB) or die("Ошибка выполнения: ".$sql." errors: ".mysql_error());
        if (0 == $res) return false;
        if ($res > 0) {
            $this->setModels();
            return true;
        }else{
            return false;
        }
    }

    public function getLastId()
    {
        return $this->lastId;
    }
}