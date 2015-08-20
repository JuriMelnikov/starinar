<?php
class Models{

    private $models;
    private $connDB;
    public function __construct($connDB){
        $this->connDB=$connDB;
       // echo "<br>Это сласс Models.php";
        //echo "<br>Инициируем массив моделей в поле models";
        $sql="SELECT * FROM `ns_models` WHERE 1";
        $res=mysql_query($sql,$connDB) or die("<br>Ошибка выполнения: ".$sql." errors: ".mysql_error());
        while($row=mysql_fetch_array($res,MYSQL_ASSOC)){
            $this->models[]=$row;
        }
    }
    /**
    *   Возвращает ид ордера a_id связанного с моделью m_id или false
    *
    */
    public function getA_id($m_id)
    {
        foreach ($this->models as $row => $cols) {  
            if($cols['m_id']==$m_id){
                return $cols['a_id'];
            }
        }
        //echo "<br>Нет такой модели: $m_id";
        return false;
    }
    /**
    *   Возвращает идентификатор имени ml_id,
    *   связанного с идентификатором модели m_id или false
    *
    */
    public function getMl_id($m_id)
    {

        foreach ($this->models as $row => $cols) {  
            //echo "<br>$row-->".$cols['m_id']." = ".$cols['ml_id'];
            if($cols['m_id']==$m_id){
                return $cols['ml_id'];
            }
        }
        //echo "<br>Нет такой модели: $m_id";
        return false;
    }
    /**
    *   Возвращает имя модели по идентификатору m_id, или false
    *
    */
    public function getNameModel($m_id)
    {
        $ml_id=$this->getMl_id($m_id);
        //echo "<br>getNameModel:ml_id=$ml_id";
        $c=new Counts($this->connDB);
        $count=$c->getCount($ml_id);
        $ml=new ModelsList($this->connDB);
        $nameModel=$ml->getNameModel($ml_id);
        return array(
                        'count' => $count,
                        'model'=> $nameModel
                     );
    }
    /**
    *   Добавляет модель с именем ml_id связанную с a_id и
    *   добавляет количество изделий count
    */
    public function addModel($a_id,$model,$count)
    {
        //echo "<br> Это addModel model=$model";
        $modl=new ModelsList($this->connDB);
 //echo "<br>ml_id=".      
        $ml_id=$modl->getId($model);
      //  echo "Пробуем вставить модель с ml_id=$ml_id и a_id = $a_id";
       // echo "<br>".
        $query="INSERT INTO `ns_models`(`a_id`,`ml_id`) 
                VALUES ('$a_id','$ml_id')";
        if(mysql_query($query,$this->connDB)){
            $m_id=mysql_insert_id();
            //вставим количество моделей
            $c=new Counts($this->connDB);
            if(!$c->addCount($a_id,$m_id,$count)){
                //echo "Количество моделей не добавлено!";
                exit;
            }
            //echo "модель и количество добавлены";
            return true;
        }else{
            echo mysql_error();
            return false;
        }
    }
    /**
    *   Возвращает массив models с именем модели (model) и количеством (count), 
    *   которые связаны с ордером a_id
    */
    public function getModels($a_id)
    {
        foreach ($this->models as $key => $value) {
            if($value['a_id']==$a_id){
                $m_id=$value['m_id'];
                $models[]=$this->getNameModel($m_id);
            }
        }
        if(!empty($models)){
            return $models;
        }else{
            return false;
        }
        
    }


}