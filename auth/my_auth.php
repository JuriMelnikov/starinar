<?php
require_once 'my_auth_class.php';
$user = new authClass();//если есть сессия определяет $this->userID


if ( isset($_GET['logout']) && $_GET['logout'] == 1 ) 
	$user->logout('http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']);
	


if ( !$user->is_loaded()){
		 // echo " 111 ".$user->a_level." ".$_SERVER['PHP_SELF'] ;
	//если нету $this->userID, т.е. сессии нет
	if ( isset($_POST['uname']) && isset($_POST['pwd'])){
	echo(" есть логин и пароль ");
	//если есть и логин и пароль
	//проверяем функцией login
	  if ( !$user->login($_POST['uname'],$_POST['pwd'])){
	  
	  //если login или пароль неправильные, сообщаем
	  //Mention that we don't have to use addslashes as the class do the job
	    echo '<center><font color="red">Неправильный логин и/или пароль</font></center>';
	  }else{											
	  //если login и пароль правильные, записываем userID в сессию и устанавливаем куки на 300 с, посылаем заголовки, что приведет к загрузки контента, т.к $user->is_loaded == true.
	    //user is now loaded
	    header('Location: http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']);
	  }
	}
	echo '<!DOCTYPE html>
	<html>
	 <head>
	   <title>Аутентификация</title>
	   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	   <link rel="stylesheet" type="text/css" href="../auth/reset.css">
	   <link rel="stylesheet" type="text/css" href="../auth/auth_style.css">		
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
	</body>
	</html>';
	die();
}else{
	/* if(isset($op)){
		switch ($op){
			case 'admin':$a_level=7;break;
			case 'techmap':$a_level=7;break;
			case 'worker':$a_level=7;break;
			case 'techmap':$a_level=7;break;
			case 'buch':$a_level=5;break;
			case 'seamstress':$a_level=3;break;
			default : $a_level=3;break;
		} 
	}
	 */// if(!$user->ident($a_level)){ 
		// $user->logout('http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']);
		// die();
	// }
	//если есть $this->userID, т.е. сессия есть и пользователь авторизован
	//echo '<a id="logout" href="'.$_SERVER['PHP_SELF'].'?logout=1">Выйти</a>';
}

?>