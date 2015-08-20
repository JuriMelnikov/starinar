<?php
class Workers{

    private $workers;
    private $lastId;

    public function __construct($connDB)
    {
        $this->connDB=$connDB;
         echo "<br>==>Это сласс Workers.php";
        $sql="SELECT * FROM `ns_workers` WHERE 1";
        $res=mysql_query($sql,$connDB) or die("Ошибка выполнения: ".$sql." errors: ".mysql_error());
        while($row=mysql_fetch_array($res,MYSQL_ASSOC)){
            $this->workers[]=$row;
        }
    }
    
    public function getFamily($w_id)
    {
        foreach ($this->workers as $row => $cols) {  
            if($cols['w_id']==$w_id){
                return $cols['family'];
            }
        }
        return false;
    }   
        public function getName($w_id)
    {
        foreach ($this->workers as $row => $cols) {  
            if($cols['w_id']==$w_id){
                return $cols['name'];
            }
        }
        return false;
    }  
        public function getPayment($w_id)
    {
        foreach ($this->workers as $row => $cols) {  
            if($cols['w_id']==$w_id){
                return $cols['payment'];
            }
        }
        return false;
    }  
       
    public function addWorker($L1,$L2,$L3,$L4,$L5,$family,$name,$kood,$appointment,$telefon,$bankCount,$city,$adress,$payment)
    {
        
        $sql="INSERT INTO `ns_workers`(`L1`,`L2`,`L3`,`L4`,`L5`,
        `family`,`name`,`kood`,`wa_id`,`telefon`,`bankCount`,`city`,`adress`,`payment`) 
        VALUES ('$L1','$L2','$L3','$L4','$L5','$family','$name',
        '$kood', '$w_id', '$telefon','$bankCount','$city','$adress','$payment')";
            $res=mysql_query($sql,$this->connDB());
            $this->lastId=mysql_insert_id();
        if (0 == $res) return false;
        if ($res > 0) return true;
    }
    public function updateOrder($id,$L1,$L2,$L3,$L4,$L5,$family,$name,$kood,$appointment,$telefon,$bankCount,$city,$adress,$payment)
    {
        $sql="INSERT INTO `ns_workers`(`L1`,`L2`,`L3`,`L4`,`L5`,`family`,`name`,`kood`,`wa_id`,`telefon`,`bankCount`,`city`,`adress`,`payment`) 
    VALUES ('$L1','$L2','$L3','$L4','$L5','$family','$name','$kood', '$wa_id',
    '$telefon','$bankCount','$city','$adress','$payment')";
        return $res=mysql_query($sql,$this->connDB);
        if (0 == $res) return false;
        if ($res > 0) return true;
    }
    public function deleteOrder($id)
    {
        $sql="DELETE ns_workers,auth_members FROM ns_workers,auth_members WHERE ns_workers.w_id=auth_members.w_id AND ns_workers.w_id='$id'";
        $res=mysql_query($sql,$this->connDB);
        if (0 == $res) return false;
        if ($res > 0) return true;
    }
    public function getLastId()
    {
        return $this->lastId;
    }
}