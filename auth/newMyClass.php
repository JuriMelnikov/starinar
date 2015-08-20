<?php
class toBase{
/* filds */
private $db="ns";
private $pass="ns";
private $user="ns";
private $host="localhost";
private $port = ""; 
private $connDB;/*дескриптор соединения*/

private $dbUsersTable  = 'auth_members';
private $dbWorkersTable = 'ns_workers';
private $sessionVariable = 'userID';
private $tbUsersFields = array(
  	'userID'=> 'id', 
	'w_id'=>'w_id',
  	'login' => 'login',
  	'pass'  => 'password',	
  );
private $tbWorkersFields = array(
	'w_id'=>'w_id',
	'L1'=>'L1',
	'L2'=>'L2',
	'L3'=>'L3',
	'L4'=>'L4',
	'L5'=>'L5'
);
private $err_001 = "Select to db is missing";
private $err_002 = "Query is not executed";

private $remTime = 120;/*2 минуты жизнь cookies */
private $remCookieName = 'nirgiservis'; /*имя кука в браузере*/

private $passMethod = 'sha1'; /* метод шифрования пароля */
private $userData=array(); /*данные пользователя по полю id из таб auth_members*/
private $userID;  /*идентификатор пользователя id из таб auth_members*/
private $authWorker=array(); /*данные по полю w_id из таб ns_workers */

/* Constructor */
function __construct(){
//;
	//connect with db 
	$connDB=mysql_connect($this->host.':'.$this->port, 
	$this->user, $this->pass);
	$this->connDB=$connDB;
	mysql_select_db($this->db, $this->connDB) or die($this->err_001);
	 mysql_query('SET NAMES utf8');
/* если нет сессии - открываем */
	 if(!isset( $_SESSION )) session_start();
/* если $sessionVariable не пустая то считываем данные 
авроризованного пользователя в $userID*/	 
	 if ( !empty($_SESSION[$this->sessionVariable]) && $_SESSION['ip']==$_SERVER['REMOTE_ADDR'] )
		    $this->loadUser( $_SESSION[$this->sessionVariable]);
	
}
/* Destructor 
function __destruct() {
	mysql_close($connDB);
}
*/
public function getConnDB()
{
	return $this->connDB;
}
/* Считываем данные авторизованного пользователя*/
private function loadUser($userID) {
/*считываем из таб auth_members данные пользователя с id=$userID*/
	$res = $this->resQuery("SELECT * FROM `{$this->dbUsersTable}` WHERE `{$this->tbUsersFields['userID']}` = '".$this->escape($userID)."' LIMIT 1");
    /*если пользователя с id=$userID нет, возврощаем false*/
	if ( @mysql_num_rows($res) == 0 )
    	return false;
	/*если пользователь с id=$userID есть, то заносим его данные 
	 в приватные поля и переменную сессии*/
    $this->userData = mysql_fetch_array($res,MYSQL_ASSOC);
    $this->userID = $userID;
    $_SESSION[$this->sessionVariable] = $this->userID;
	
	/*Считываем данные из ns_workers 
	для определения уровня доступа пользователя
	и записываем их в поле authWorker*/
	$res = $this->resQuery("SELECT L1,L2,L3,L4,L5 FROM `{$this->dbWorkersTable}` WHERE `{$this->tbWorkersFields['w_id']}` = '".$this->userData['w_id']."' LIMIT 1");
    $this->authWorker = mysql_fetch_array($res,MYSQL_ASSOC);
	return true;
 }
 /*Очищаем данные для запроса*/
 private function escape($str) {
    $str = get_magic_quotes_gpc()?stripslashes($str):$str;
    $str = mysql_real_escape_string($str, $this->connDB);
    return $str;
  }
private function getip(){
if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"),"unknown"))
$ip = getenv("HTTP_CLIENT_IP");

elseif (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
$ip = getenv("HTTP_X_FORWARDED_FOR");

elseif (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
$ip = getenv("REMOTE_ADDR");

elseif (!empty($_SERVER['REMOTE_ADDR']) && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
$ip = $_SERVER['REMOTE_ADDR'];

else
$ip = "unknown";

return($ip);
}

/*Блокирует ip после трех неправильных наборов на 10 минут*/
private function blockIP($ip){

$query="SELECT * FROM `delay_login` WHERE `ip`='$ip'";
$result=$this->resQuery($query);
	if (@mysql_num_rows($result) == 0){//строки нет
		$time=time()+5;
		$query="INSERT INTO `delay_login`(`ip`,`time`,`count`) VALUES ('$ip','$time','1')";
		$result=$this->resQuery($query);
		return;
	}
	else{//строка есть
		$time=time()+5;
		$query="UPDATE `delay_login` SET `time`='$time', `count`=`count`+1 WHERE `ip`='$ip'";
		$result=$this->resQuery($query);
		return;
	}
}

private function unblockIP($ip){
/* ищем в таблице ip пользователя и удаляем строку*/
$query="SELECT * FROM `delay_login` WHERE `ip`='$ip'";
$result=$this->resQuery($query);
	if (@mysql_num_rows($result) != 0){
	$query="DELETE FROM `delay_login` WHERE `ip`='$ip'";
			$result=$this->resQuery($query);
	}
	return;
}


public function getCount(){
$ip=$this->getip();
$query="SELECT * FROM `delay_login` WHERE `ip`='$ip'";
$result=$this->resQuery($query);
	if (@mysql_num_rows($result)!=0){//строка есть
	$row=mysql_fetch_array($result,MYSQL_ASSOC);
	return $row["count"];
	}
return 0;
}

//если w_id нет или нет такой записи - false, else login
public function getLogin($w_id){
if($w_id=='')return false;
$result=$this->resQuery("SELECT `{$this->tbUsersFields['login']}` FROM `{$this->dbUsersTable}` 
		WHERE `{$this->tbUsersFields['w_id']}` = '$w_id'  LIMIT 1");
	if (@mysql_num_rows($result) == 0){
		return false;
	}
	$row=mysql_fetch_array($result,MYSQL_ASSOC);
	return $row[$this->tbUsersFields['login']];	
}

/*Возвращает w_id авторизованного пользователя*/
public function getAuthW_id(){
return $this->userData['w_id'];
}
/* 
	записывает строку с аккаунтом.
	возвращает истину или ложь
 */
 public function setAccount($w_id,$login,$password ){
	$w_id=(int)$w_id;
	$login=$this->escape(substr(trim($login),0,20));
	$password=$this->escape(substr(trim($password),0,20)); 
	switch(strtolower($this->passMethod)){
		  case 'sha1':
		  	$password = SHA1($password); break;
		  case 'md5' :
		  	$password = MD5($password);break;
		  case 'nothing':
		  	$password = $password;break;
		}

	$query="SELECT login FROM auth_members WHERE w_id='$w_id'";
	
	$resLogin=$this->resQuery($query);
	if ( @mysql_num_rows($resLogin) == 0 ){
		$query="INSERT `{$this->dbUsersTable}`(`{$this->tbUsersFields['w_id']}`,  `{$this->tbUsersFields['login']}`, `{$this->tbUsersFields['pass']}`) VALUES ('$w_id','$login','$password')";
	}else{		
		 $query="UPDATE `{$this->dbUsersTable}` SET `{$this->tbUsersFields['login']}`='$login',`{$this->tbUsersFields['pass']}`='$password' WHERE `{$this->tbUsersFields['w_id']}`='$w_id'";
	}
	$result=$this->resQuery($query);
	return $set = mysql_affected_rows($this->connDB)!= -1 ?	 true : false;
}

/* Request */
public function resQuery($sql){
	$res = mysql_query($sql, $this->connDB) or die($this->err_002." ".$sql." ".mysql_error());
	return $res;
}
/* Проверяем права доступа к данной страничке */
public function accessYes($Lx){
if(empty($this->userID))
	return 0; /*если нет ид пользователя - выход с ложь*/
	
if($Lx=='L1'){
	if($this->authWorker['L1']){
		if($this->authWorker['L1'] && $this->authWorker['L3'])
			return -2; /*если есть ид польз. и у него есть доступ к L1 и L3 (швеи и ордера)*/
		if(($this->authWorker['L1'] && $this->authWorker['L4'])||($this->authWorker['L1'] && $this->authWorker['L5']))
			return -1; /*если есть ид польз. и у него есть доступ к L1  и еще к любой из L4,L5 (модели и работники) */
		else 
			return $this->userData['w_id'];/*если есть ид польз. и у него есть доступ к $Lx странице (швеи) - выход с w_id пользователя*/
	}else{
		return 0;
	}
}elseif($Lx=='L2'){
	if($this->authWorker['L2']){
		if(($this->authWorker['L1'] && $this->authWorker['L4'])||($this->authWorker['L1'] && $this->authWorker['L5']))
			return -1; /*если есть ид польз. и у него есть доступ к L1  и еще к любой из L4,L5 (модели и работники) */
		else 
			return $this->userData['w_id'];/*если есть ид польз. и у него есть доступ к $Lx странице (швеи) - выход с w_id пользователя*/
	}
}elseif($Lx=='L3'){
	if($this->authWorker['L3']){
		if($this->authWorker['L1'] && $this->authWorker['L3'] && !$this->authWorker['L2'] && !$this->authWorker['L4'] && !$this->authWorker['L5'])
			return -2; /*если есть ид польз. и у него есть доступ к L1 и L3 (швеи и ордера)*/
		if(($this->authWorker['L1'] && $this->authWorker['L4'])||($this->authWorker['L1'] && $this->authWorker['L5']))
			return -1; /*если есть ид польз. и у него есть доступ к L1  и еще к любой из L4,L5 (модели и работники) */
		else 
			return $this->userData['w_id'];/*если есть ид польз. и у него есть доступ к $Lx странице (швеи) - выход с w_id пользователя*/
	}
}else{
	if($this->authWorker[$Lx])
		return $this->userData['w_id']; /*если есть ид польз. и у него есть доступ к $Lx странице - выход с w_id пользователя*/
	else 
		return 0;/*если есть ид польз. но у него нет доступа к $Lx странице - выход с фолс*/
}	
}
/**
* процедура авторизации
* Параметры
* $logn, $passwd, $idPage
* Алгоритм:
* 1. Проверяем нет ли ip в таблице задержки, если есть возвращаем 0.
* 2. Вырезаем первые 20 символов из $logn, $passwd;
* 3. Создаем хэш из пароля.
* 4. Запрашиваем в базе все поля, где в строке имеются указанные логин и хэш пароля.
* 5. Если результат = 0, записываем для ip задержку на 5 сек. и возвращаем 0.
* 6. Запоминаем в сессии id записи в UserID, ip соединения.
* 7. Считываем для w_id права доступа к страницам.
* 8. Если доступ к странице указанной в $idPage не разрешен, возвращаем 0
* 9. Удаляем ip из таблицы задержки и возвращаем 1.
**/
public function login($logn, $passwd, $idPage){
 $ip=$this->getip();
 $query="SELECT * FROM `delay_login` WHERE `ip`='$ip'";
 $res = $this->resQuery($query);
 if ( @mysql_num_rows($res) != 0){
 $row=mysql_fetch_array($res,MYSQL_ASSOC);
 $delay=$row["time"]-time();
 $count=$row["count"];
 if($delay>0) return 0;
 }
	$login=substr((string)$logn,0,19);
	$password=substr((string)$passwd,0,19);
	$login = $this->escape($login);
	$password = $this->escape($password);
	
	switch(strtolower($this->passMethod)){
	  case 'sha1':
		$password = SHA1($password); break;
	  case 'md5' :
		$password = MD5($password);break;
	  case 'nothing':
		$password = $password;
	}

	$result = $this->resQuery("SELECT * FROM `{$this->dbUsersTable}` 
	WHERE `{$this->tbUsersFields['login']}` REGEXP BINARY '$login' AND `{$this->tbUsersFields['pass']}` = '$password' LIMIT 1");
	if ( @mysql_num_rows($result) == 0){
		$this->blockIP($this->getip());	
		return 0;
	}
	
	$this->userData = mysql_fetch_array($result,MYSQL_ASSOC);
	
	$this->userID = $this->userData[$this->tbUsersFields['userID']];
	$_SESSION[$this->sessionVariable] = $this->userID;
	$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
	//$w_id=$this->userData['w_id'];
	$result = $this->resQuery("SELECT L1,L2,L3,L4,L5 FROM `{$this->dbWorkersTable}` WHERE `{$this->tbWorkersFields['w_id']}` = '".$this->userData['w_id']."' LIMIT 1");
	$this->authWorker = mysql_fetch_array($result,MYSQL_ASSOC);	
	
	$access=$this->accessYes($idPage);
	if($access==0){
		$this->blockIP($this->getip());	
		$this->logout($_SERVER['PHP_SELF']);
		return 0;
	}
	else
		$this->unblockIP($this->getip());
	return 1;
}
public function logout($redirectTo) {
    //setcookie($this->remCookieName, '', time()-3600);
    $_SESSION[$this->sessionVariable] = '';
    $this->userData = '';
	$this->userID = '';
	$this->authWorker = '';
   // if ( $redirectTo != '' && !headers_sent()){
	   header('Location: '.$redirectTo );
	//   exit;//To ensure security
	//}
}

}