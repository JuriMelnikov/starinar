<?php
class authClass{
private $dbName = 'nirgiservis';
private $dbHost = 'localhost';
private $dbPort = 3306;
private $dbUser = 'nirgiservis';
private $dbPass = 'Rjhjnf^NS2012';
private $dbUsersTable  = 'auth_members';
private $dbSessionsTable  = 'auth_sessions';
private $sessionVariable = 'userSessionValue';
private $tbUsersFields = array(
  	'userID'=> 'id', 
	'w_id'=>'w_id',
  	'login' => 'login',
  	'pass'  => 'password',
  	'active'=> 'active'
  );
  private $tbSessionsFields = array(
  	'userID'=> 'userID', 
  	'time' => 'time',
  	'hash'  => 'hash'
  );
  private $remTime = 120;//2 минуты
  private $remCookieName = 'nirgiservis';
  private $remCookieDomain = '';
  private $passMethod = 'sha1';
  private $userID;
  private $dbConn;
  private $userData=array();
  // public $a_level;
  
//Конструктор
public function  __construct(){
	$this->remCookieDomain = $this->remCookieDomain == '' ? $_SERVER['HTTP_HOST'] : $this->remCookieDomain;
	$this->dbConn=mysql_connect($this->dbHost.':'.$this->dbPort, $this->dbUser, $this->dbPass) or die(mysql_error());
	 mysql_select_db($this->dbName, $this->dbConn)or die(mysql_error($this->dbConn));  
	 mysql_query('SET NAMES utf8');
	 if(!isset( $_SESSION )) session_start();
	 if ( !empty($_SESSION[$this->sessionVariable]) )
		    $this->loadUser( $_SESSION[$this->sessionVariable]);
	 
}  
//----------- public ---------------------- 

public function is_loaded() { 
//echo "Аутентификация=".$this->userID;
	 return empty($this->userID) ? false : true;
}

/* 
	принимает идентификатор пользователя и уровень доступа.
	возвращает логин или false
 */
  public function getAccount($worker_id,$level){
$w_id=(int)$worker_id;
$level=(int)$level;
if($level==3)$query="SELECT * FROM auth_members WHERE w_id='$w_id'";
if($level==5)$query="SELECT * FROM auth_members WHERE level='5'";
if($level==7)$query="SELECT * FROM auth_members WHERE level='7'";
if($level==13)$query="SELECT * FROM auth_members WHERE level='13'";
$result=mysql_query($query)or die("Запрос не выполнен".mysql_error());
	if ( @mysql_num_rows($result) == 0 ){
		return false;
	}else{
		$row=mysql_fetch_array($result,MYSQL_ASSOC);
		return $row["name"];	
	}
}
//если w_id нет или нет такой записи - false, else login
public function getLogin($w_id){
if($w_id=='')return false;
$result=$this->query("SELECT `{$this->tbUsersFields['login']}` FROM `{$this->dbUsersTable}` 
		WHERE `{$this->tbUsersFields['w_id']}` = '$w_id'  LIMIT 1");
	if (@mysql_num_rows($result) == 0){
		return false;
	}
	$row=mysql_fetch_array($result,MYSQL_ASSOC);
	return $row["name"];	
}
public function getAuthW_id(){
$data["w_id"]=$this->userData["w_id"];
$data["level"]=$this->userData["level"];
	return $data;
}

/* 
	записывает строку с аккаунтом.
	возвращает истину или ложь
 */
 public function setAccount($worker_id,$level,$login,$password ){
	$worker_id=(int)$worker_id;
	$level=(int)$level;
	$login=$this->escape($login);
	$password=$this->escape($password); 
	switch(strtolower($this->passMethod)){
		  case 'sha1':
		  	$password = SHA1($password); break;
		  case 'md5' :
		  	$password = MD5($password);break;
		  case 'nothing':
		  	$password = $password;
		}

	if($level==3)$query="SELECT name FROM auth_members WHERE w_id='$worker_id'";
	if($level==5){$query="SELECT name FROM auth_members WHERE level='5'";$worker_id=0;}
	if($level==7){$query="SELECT name FROM auth_members WHERE level='7'";$worker_id=0;}
	if($level==13){$query="SELECT name FROM auth_members WHERE level='13'";$worker_id=0;}
	$resNameFromLevel=$this->query($query);
	if ( @mysql_num_rows($resNameFromLevel) == 0 ){
		$query="INSERT `auth_members`(`w_id`, `level`, `name`, `password`, `active`) VALUES ('$worker_id','$level','$login','".$password."','1')";
	}else{
		if($level > 3)$query="UPDATE auth_members SET name='$login',password='".$password."',active='1' WHERE level='$level'";
		else $query="UPDATE `auth_members` SET `name`='$login',`password`='".$password."',`active`='1' WHERE `w_id`='$worker_id'";
	}
	$result=$this->query($query);
	return $set = mysql_affected_rows($this->dbConn)!= -1 ?	 true : false;
}

 public function login($uname, $password) {
    	$uname = $this->escape($uname);
    	$password = $originalPassword = $this->escape($password);
		
		switch(strtolower($this->passMethod)){
		  case 'sha1':
		  	$password = SHA1($password); break;
		  case 'md5' :
		  	$password = MD5($password);break;
		  case 'nothing':
		  	$password = $password;
		}
		//echo " login=".$uname." pass=".$password." level=".$level;
		$res = $this->query("SELECT * FROM `{$this->dbUsersTable}` 
		WHERE `{$this->tbUsersFields['login']}` = '$uname' AND `{$this->tbUsersFields['pass']}` = '$password' AND `{$this->tbUsersFields['active']}` = '1' LIMIT 1");
		if ( @mysql_num_rows($res) == 0){
			//echo "такого имени или пароля нет";	
			return false;
		}
			
		$this->userData = mysql_fetch_array($res,MYSQL_ASSOC);
		
		$this->userID = $this->userData[$this->tbUsersFields['userID']];
		$_SESSION[$this->sessionVariable] = $this->userID;
			
return true;
}
  /*
	по идентификатору пользователя определяет уровень доступа
	возвращает уровень или ложь
  */
public function ident($w_id = 0){
	if($this->is_loaded()){
	//$res=$this->query("SELECT * FROM `{$this->dbUsersTable}` WHERE `{$this->tbUsersFields['userID']}` = '".$this->escape($this->userID)."' LIMIT 1");
	//echo "userID=".$this->userID;
		//if ( @mysql_num_rows($res) == 0 )
		//	return false;
		//$row=mysql_fetch_array($res,MYSQL_ASSOC);
		//echo "w_id=".$w_id." row[w_id]=".$row["w_id"];
		//if($w_id==$row["w_id"])
		if($this->userData['w_id']==$w_id)
			return $this->userData["level"];
	}
	return false;
}

public function logout($redirectTo = '') {
    //setcookie($this->remCookieName, '', time()-3600);
    $_SESSION[$this->sessionVariable] = '';
    $this->userData = '';
	$this->userID = '';
    if ( $redirectTo != '' && !headers_sent()){
	   header('Location: '.$redirectTo );
	   exit;//To ensure security
	}
  }
  public function getW_id() {
	if($this->is_loaded()){
		$arr["w_id"]=$this->userData["w_id"];
		$arr["level"]=$this->userData["level"];
		return $arr;
	}
	return false;
  }
  
//--------------- private ------------------

private function escape($str) {
    $str = get_magic_quotes_gpc()?stripslashes($str):$str;
    $str = mysql_real_escape_string($str, $this->dbConn);
    return $str;
  }
  
private function loadUser($userID) {
	$res = $this->query("SELECT * FROM `{$this->dbUsersTable}` WHERE `{$this->tbUsersFields['userID']}` = '".$this->escape($userID)."' LIMIT 1");
    if ( @mysql_num_rows($res) == 0 )
    	return false;
    $this->userData = mysql_fetch_array($res,MYSQL_ASSOC);
    $this->userID = $userID;
    $_SESSION[$this->sessionVariable] = $this->userID;
    return true;
 }
 private function query($sql) {
   	$res = mysql_query($sql, $this->dbConn);
	return $res;
  }
 }
?>