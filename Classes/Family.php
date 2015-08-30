<?php
class Family {
    private $w_id;
    private $family;
    private $name;
    private $serial;
    private $count;

    public function __construct()
    {
        // echo "Family - constructor";
        // if($w_id != 0){
        //   $this->w_id=$w_id;
        // }
        // if($count != 0){
        //   $this->count=$count;
        // }

        // if($family != ''){
        //   $this->family=$family;  
        // }
        // if($name != ''){
        //   $this->name=$name;  
        // }
        // if($serial != ''){
        //   $this->serial=$serial;  
        // }        
    }
    public function getW_id()
    {
        return $this->w_id;
    }
    public function getFamily()
    {
        return $this->family;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function getSerial()
    {
        return $this->serial;
    }
    
    public function getCount()
    {
        return $this->count;
    }


    public function setW_id($w_id)
    {
        $this->w_id=$w_id;
    }
    public function setFamily($family)
    {
        $this->family=$family;
    }
    public function setName($name)
    {
        $this->name=$name;
    }
    public function setSerial($serial)
    {
        $this->serial=$serial;
    }
     public function setCount($count)
    {
        $this->count=$count;
    }
}