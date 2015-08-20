<?php
class SectionsList{
    private $sections=array();
    private $section;
    private $connDB;
    private $lastId=0;


    public function __construct($connDB){
        $this->connDB=$connDB;
       // echo "<br>Это сласс SessionsList.php";
        $sql="SELECT * FROM `ns_section_list` WHERE 1";
        $res=mysql_query($sql,$connDB) or die("Ошибка выполнения: ".$sql." errors: ".mysql_error());
        while($row=mysql_fetch_array($res,MYSQL_ASSOC)){
            $this->sections[]=$row;
            // foreach ($row as $key => $value) {
            //     echo "$key : $value <br>";
            // }
        }
    }
    /**
    *   Проверяет существование раздела с именем $sectionName
    *   в поле $sections. Возвращяет true или false
    */
    private function existsSection($sectionName)
    {   
        foreach ($this->sections as $key => $value){
            if($value['lSection']===$sectionName){
                return true;
            }else{
                return false;
            }
        }
    }
    /**
    *   Перезаписывает массив $sections
    *
    */
    private function setSections()
    {  // echo "<br>обновляем список разделов";
        unset($this->sections);
        $sql="SELECT * FROM `ns_section_list` WHERE 1";
        $res=mysql_query($sql,$this->connDB) or die("SetSections errors: ".mysql_error());
        while($row=mysql_fetch_array($res,MYSQL_ASSOC)){
                $this->sections[]=$row;
        }
        if($res>0){
          //  echo "<br>Обновили список разделов";
            return true;
        }else{
          //  echo "<br>Список разделов не обновлен.";
            return false;
        }
    }
    /**
    *   Возвращает $id для имени раздела ($sectionName)
    *   возвращает id раздела, или false
    */
    public function getId($sectionName)
    { 
        foreach ($this->sections as $row => $cols) {  
            if($cols['lSection']===$sectionName){
                return $cols['sl_id'];
            }
        }
        return false;
    }
    /**
    *   Возвращает имя раздела, или false
    */
    public function getNameSection($sl_id)
    { 
        foreach ($this->sections as $row => $cols) {  
            //echo "<br>".$cols['sl_id']."=>".$cols['lSection'];
            if($cols['sl_id']==$sl_id){
                return $cols['lSection'];
            }
        }
        return false;
    }
    /**
    *   Возвращает название раздела по id или false 
    *   
    */
    public function getSection($id)
    {
        $sql="SELECT `lSection` FROM `ns_section_list` WHERE `sl_id`='$id'";
        $res=mysql_query($sql,$this->connDB);
        $row=mysql_fetch_array($res,MYSQL_ASSOC);
        if (0 == $res) return false;
        if ($res > 0) return $row['lSection'];

    }

    /**
    *   Добавляем имя раздела в таблицу
    *   Обновляет массив в $sections
    *   Возвращает true или false
    */
    public function addSection($name)
    {
        echo "<br>Добавляем раздел";
        if(!$this->existsSection($name)){
            $sql="INSERT INTO `ns_section_list`(`lSection`) VALUES ('$name')";
            $res=mysql_query($sql,$this->connDB) or die("Ошибка выполнения: ".$sql." errors: ".mysql_error());
            $this->lastId=mysql_insert_id();
            if ($res > 0) {
               // echo "<br>Добавили раздел, теперь обновим";
                if(!$this->setSections()){
               //     echo "<br>Ошибка";
                }
                return $this->lastId;
            }
        }else{
           // echo "<br>Раздел $name не добавлен";
            return false;
        } 
        
        
    }
    public function updateSection($name, $id)
    {
        if(!$this->existsSection($name)){
            $sql="UPDATE `ns_section_list` SET `lSection`='$name' WHERE `sl_id`='$id'";
            $res=mysql_query($sql,$this->connDB) or die("Ошибка выполнения: ".$sql." errors: ".mysql_error());
            if ($res > 0) {
                $this->setSections();
                return true;
            }
        }else{
            return false;
        }
    }
    public function deleteSection($id)
    {
        $sql="DELETE FROM `ns_section_list` WHERE `sl_id`='$id'";
        $res=mysql_query($sql,$this->connDB) or die("Ошибка выполнения: ".$sql." errors: ".mysql_error());
        if (0 == $res) return false;
        if ($res > 0) {
            $this->setSections();
            return true;
        }else{ 
            return false;
        }
    }
    public function getLastId(){
        return $this->lastId;
    }
}