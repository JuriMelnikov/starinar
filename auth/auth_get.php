<?php
//session_start();
require_once 'auth_class.php';
$user = new authClass();
if ( isset($_GET['logout']) && $_GET['logout'] == 1 ) 
	$user->logout('http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']);
if ( !$user->is_loaded() ){
if ( isset($_POST['uname']) && isset($_POST['pwd'])){//если есть и логин и пароль
	  if ( !$user->login($_POST['uname'],$_POST['pwd'])){//если login класса = ложь, сообщаем
	  //Mention that we don't have to use addslashes as the class do the job
	    echo '<center><font color="red">Неправильный логин и/или пароль</font></center>';
	  }else{											//если login класса = истина, редирект
	    //user is now loaded
	    header('Location: http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']);
	  }
}
echo '<!DOCTYPE html>
<html>
 <head>
   <title>Аутентификация</title>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <link rel="stylesheet" type="text/css" href="../style/reset.css">
   <link rel="stylesheet" type="text/css" href="../style/astyle.css">		
 </head>
<body>
<div id="auth">
	<h1>Введите, пожалуйста, логин и пароль</h1><br><br>
	<p><form method="post" action="'.$_SERVER['PHP_SELF'].'" >
	 Логин:<br><input type="text" name="uname" ><br><br >
	 Пароль:<br><input type="password" name="pwd" ><br ><br >
	 <input type="submit" value="Войти" >
	</form>
	</p>
</div>
</body></html>'
	;
	die();
}else{//если userID есть то рисуем ссылку для выхода.
  //User is loaded
  echo '<a id="logout" href="'.$_SERVER['PHP_SELF'].'?logout=1">Выйти</a>';
  if(!$user->check())$user->logout('http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']);
}

?>