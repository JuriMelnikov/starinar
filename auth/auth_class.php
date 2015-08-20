<?php
class authClass{
private $dbName = 'nirgiservis';
private $dbHost = 'localhost';
private $dbPort = 3306;
private $dbUser = 'nirgiservis';
private $dbPass = 'Rjhjnf^NS2012';
private $dbTable  = 'auth_members';
private $sessionVariable = 'userSessionValue';
private $tbFields = array(
  	'userID'=> 'id', 
  	'login' => 'name',
  	'pass'  => 'password',
  	'email' => 'email',
  	'active'=> 'active'
  );

private $remTime = 30;//2592000;One month
private $remCookieName = 'ckSavePass';
private $remCookieDomain = '';
private $passMethod = 'sha1';
private $displayErrors = true;
private $userID;
private $dbConn;
private $userData=array();

//constuctor
public function authClass(){
$this->remCookieDomain = $this->remCookieDomain == '' ? $_SERVER['HTTP_HOST'] : $this->remCookieDomain;
$this->dbConn=mysql_connect($this->dbHost.':'.$this->dbPort, $this->dbUser, $this->dbPass) or die(mysql_error());
 mysql_select_db($this->dbName, $this->dbConn)or die(mysql_error($this->dbConn));
 if ( !empty($_SESSION[$this->sessionVariable]) )
	$this->loadUser( $_SESSION[$this->sessionVariable] );
	if ( isset($_COOKIE[$this->remCookieName]) && !$this->is_loaded()) {
	echo 'I know you<br />';
	      $u = unserialize(base64_decode($_COOKIE[$this->remCookieName]));
	      $this->login($u['uname'], $u['password']);
	    }
}
//получаем результат запроса $res, где $userID соответсвует записи с полем  
private function loadUser($userID) {
	$res = $this->query("SELECT * FROM `{$this->dbTable}` WHERE `{$this->tbFields['userID']}` = '".$this->escape($userID)."' LIMIT 1");
    if ( mysql_num_rows($res) == 0 )
    	return false;
    $this->userData = mysql_fetch_array($res);
    $this->userID = $userID;
    $_SESSION[$this->sessionVariable] = $this->userID;
    return true;
}

private function query($sql) {
	$res = mysql_query($sql, $this->dbConn) or die(mysql_error());
	return $res;
}

public function is_loaded() {
    return empty($this->userID) ? false : true;
}

public function login($uname, $password, $remember = false, $loadUser = true) {
    	$uname = $this->escape($uname);
    	$password = $originalPassword = $this->escape($password);
		switch(strtolower($this->passMethod)){
		  case 'sha1':
		  	$password = "SHA1('$password')"; break;
		  case 'md5' :
		  	$password = "MD5('$password')";break;
		  case 'nothing':
		  	$password = "'$password'";
		}
		$res = $this->query("SELECT * FROM `{$this->dbTable}` 
		WHERE `{$this->tbFields['login']}` = '$uname' AND `{$this->tbFields['pass']}` = $password LIMIT 1",__LINE__);
		if ( @mysql_num_rows($res) == 0){
			return false;
		}
		if ( $loadUser ) {
			$this->userData = mysql_fetch_array($res);
			$this->userID = $this->userData[$this->tbFields['userID']];
			$_SESSION[$this->sessionVariable] = $this->userID;
			  $cookie = base64_encode(serialize(array('uname'=>$uname,'password'=>$originalPassword)));
			  $a = setcookie($this->remCookieName,$cookie,time()+$this->remTime, '/', $this->remCookieDomain);
			
		}
		return true;
}
private function escape($str) {
    $str = get_magic_quotes_gpc() ? stripslashes($str) : $str;
    $str = mysql_real_escape_string($str);
    return $str;
}
public function logout($redirectTo = '') {
    setcookie($this->remCookieName, '', time()-3600);
    $_SESSION[$this->sessionVariable] = '';
    $this->userData = '';
    if ( $redirectTo != '' && !headers_sent()){
	   header('Location: '.$redirectTo );
	   exit;//To ensure security
	}
  }
public function check() {  
	$u = unserialize(base64_decode($_COOKIE[$this->remCookieName]));
	if($this->login($u['userID'], $u['password']))
	      $this->login($u['uname'], $u['password']);
}
}
?>