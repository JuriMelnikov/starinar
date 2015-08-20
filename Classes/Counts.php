<?php
// Класс соответствует таблице ns_admin
// в которой хранится год, месяц и неделя Ордера
class Counts{

    private $counts;
    private $connDB;

    public function __construct($connDB)
    {
        $this->connDB=$connDB;
        $sql="SELECT * FROM `ns_counts` WHERE 1";
            $res=mysql_query($sql,$connDB);
            while($row=mysql_fetch_array($res,MYSQL_ASSOC)){
                $this->counts[]=$row;
            }

    }
   
    public function addCount($a_id,$m_id,$count)
    {   
        
        $query="INSERT INTO ns_counts (a_id, m_id,count) 
                VALUES ('$a_id','$m_id','$count')";
//echo "<br>C:addC:$query";
        if(mysql_query($query,$this->connDB))
            return mysql_insert_id();
        else{
            echo "<br>C:addC: не моду добавить количество. ".mysql_error();
            return false;
        }
    }
     /**
    *   Возвращает количество изделий в модели m_id, 
    *   
    */
    public function getCount($m_id)
    {
        foreach ($this->counts as $key => $value) {
            if($value['m_id']==$m_id){
                $conut=$value['count'];
            }
        }
        if(!empty($count)){
            return $count;
        }else{
            return false;
        }
        
    }
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

}