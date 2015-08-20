<?php
class ModeslList{
    private $appointments=array();
    private $appointment;
    private $connDB;
    private $lastId=0;
    private $id=null;

    public function __construct($connDB){
        $this->connDB=$connDB;
        $sql="SELECT * FROM 'ns_appointments' WHERE 1";
        $res=mysql_query($sql,$connDB) or die("Ошибка выполнения: ".$sql);
        while($row=mysql_fetch_array($res,MYSQL_ASSOC)){
        	$this->appointments[]=$row;
        }
    }
    private function existsAppointments($appointment)
    {   
        foreach ($this->appointments as $key => $value) {
            if(in_array($appointment, $value)){
                return true;
            }else {
                return false;
            }
        }
    }
    public function setId($appointments)
    {   
        foreach ($this->appointments as $key => $value) {
            if($value['appointment']===$appointment){
                $this->id=$value['wa_id'];
                return true;
            }else{
                $this->id=null;
                return false;
            }
        }
    }
    public function getId()
    {
        return $this->id;
    }
    public function setAppointment($id)
    {
        $sql="SELECT * FROM 'ns_appointment' WHERE `wa_id`='$id'";
            $res=mysql_query($sql,$this->connDB);
            while($row=mysql_fetch_array($res,MYSQL_ASSOC)){
                $this->appointment=$row['appointment'];   
            }
        if (0 == $res) return false;
        if ($res > 0) return true;

    }
    public function getAppointment()
    {
        return $this->appointments;
    }

    public function addAppointment($name)
    {
        if(!existsAppointment($name)){
            $sql="INSERT INTO `ns_appointments`(`appointment`) VALUES ('$name')";
            $res=mysql_query($sql,$this->connDB) or die("Ошибка выполнения: ".$sql);
            $this->lastId=mysql_insert_id();
        }
        if (0 == $res) return false;
        if ($res > 0) return true;
    }
    public function updateAppointment($name, $id)
    {
        if(!existsAppointment($name)){
            $sql="UPDATE `ns_appointments` SET `appointment`='$name' WHERE `wa_id`='$id'";
            return $res=mysql_query($sql,$this->connDB);
        }
        if (0 == $res) return false;
        if ($res > 0) return true;
    }
    public function deleteAppointment($id)
    {
        $sql="DELETE FROM `ns_appointnments` WHERE `wa_id`='$id'";
        $res=mysql_query($sql,$this->connDB);
        if (0 == $res) return false;
        if ($res > 0) return true;
    }
    public function getLastId()
    {
        return $this->lastId;
    }
}